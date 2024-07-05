<?php

namespace App\Http\Livewire\Backend\Support;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Ticket as ModelTicket;
use App\Notifications\SupportTicketCreated;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\ComponentColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class Ticket extends DataTableComponent
{
    public string $tableName = 'tickets';
    public $user, $category;

    public $columnSearch = [
        'message' => null,
        'name' => null,
    ];

    public function mount($category): void
    {
        $this->category = !is_null($category) ? $category : null;
        $this->user = auth()->user();
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setPerPageAccepted([10, 25, 50, 100])
            ->setFiltersEnabled()
            ->setColumnSelectDisabled()
            ->setEmptyMessage('No results found')
            ->setHideBulkActionsWhenEmptyEnabled();
    }

    public function columns(): array
    {
        return [
            Column::make(trans('ID'), 'id')->hideIf(true),
            Column::make(trans('Slug'), 'slug')->hideIf(true),
            ComponentColumn::make("Created By", "user.name")
                ->hideIf($this->user->isStudent())
                ->component('partials.user_profile')
                ->attributes(fn ($value, $row, Column $column) => [
                    'user' => $row->user
                ])->searchable()->sortable(),

            ComponentColumn::make("Assigned To", "instructor.name")
                ->component('partials.user_profile')
                ->attributes(fn ($value, $row, Column $column) => [
                    'user' => $row->instructor
                ])->searchable()->sortable(),
            Column::make(trans('Message'), 'message')->view('jambasangsang.backend.support.tickets.partials.message')->searchable(),
            Column::make(trans('Created At'), 'created_at'),
            Column::make(trans('Priority'), 'priority')->hideIf($this->user->isStudent())->sortable(),
            Column::make(trans('Status'), 'status')->view('components.partials.status')->searchable(),
            Column::make(trans('Action'), 'slug')->view('jambasangsang.backend.support.tickets.partials.action'),
        ];
    }

    public function builder(): Builder
    {
        return ModelTicket::query()
            ->when($this->columnSearch['message'], function ($query, $message) {
                $query->where('tickets.message', 'like', '%' . $message . '%');
            })
            ->when($this->columnSearch['name'] ?? null, function ($query, $name) {
                $query->whereHas('user', function ($query) use ($name) {
                    $query->where('user.name', 'like', '%' . $name . '%')
                        ->orWhere('user.lname', 'like', '%' . $name . '%');
                })->orWhereHas('instructor', function ($query, $name) {
                    $query->where('instructor.name', 'like', '%' . $name . '%')
                        ->orWhere('instructor.lname', 'like', '%' . $name . '%');
                });
            })
            ->when($this->category, function ($query) {
                $query->where('category_id', $this->category->id);
            })
            ->when($this->user->isStudent(), function ($query) {
                $query->where('user_id', $this->user->id);
            })
            ->when($this->user->isInstructor(), function ($query) {
                $query->where('instructor_id', $this->user->id);
            })
            ->with([
                'user' => fn ($q) => $q->with('roles'),
                'instructor' => fn ($q) => $q->with('roles'),
                'category'
            ])
            ->withCount(['comments'])
            ->orderByRaw("CASE WHEN tickets.status = 'open' THEN 0 ELSE 1 END")
            ->latest();
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Status', 'status')
                ->options([
                    '' => 'All',
                    'open' => 'Open',
                    'closed' => 'Closed',
                ])
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('tickets.status', $value);
                }),
        ];
    }

    public function bulkActions(): array
    {
        return [
            'open' => 'Open',
            'closed' => 'Closed',
            'assignToSelf' => auth()->user()->isAdmin() ? 'Assign to Self' : null,
        ];
    }

    public function open()
    {
        ModelTicket::whereIn('id', $this->getSelected())->update(['status' => 'open']);

        static::notifyConcernedUsers($this->getSelected());

        $this->clearSelected();
    }

    public function closed()
    {
        ModelTicket::whereIn('id', $this->getSelected())->update(['status' => 'closed']);

        static::notifyConcernedUsers($this->getSelected());

        $this->clearSelected();
    }

    public function assignToSelf()
    {
        ModelTicket::whereIn('id', $this->getSelected())->update(['instructor_id' => auth()->id()]);

        $this->clearSelected();
    }

    public static function notifyConcernedUsers($tickets)
    {
        $tickets = ModelTicket::whereIn('id', $tickets)->get();

        foreach ($tickets as $ticket) {
            // notify student
            $ticket->user->notify(new SupportTicketCreated('student', $ticket, 'Support Ticket Updated', 'Your support ticket has been ' . ucwords($ticket->status)));

            // notify instructor
            if ($ticket->instructor_id) {
                $ticket->instructor->notify(new SupportTicketCreated('instructor', $ticket, 'Support Ticket Updated', 'An assigned ticket has been ' . ucwords($ticket->status)));
            }
        }
    }
}
