<?php

namespace App\Http\Livewire\Backend;

use App\Enums\GeneralStatus;
use App\Models\Course;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\ComponentColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class UserTable extends DataTableComponent
{
    public string $tableName = 'users';
    public string $group = 'student';
    public array $users = [];
    public $course = null;
    public bool $filterByBatch = false;

    public $columnSearch = [
        'name' => null,
        'lname' => null,
        'email' => null,
        'username' => null
    ];

    public function mount(string $group, $course, $filterByBatch = false): void
    {
        if (isset($course) && $course !== 'all' && Course::where('id', $course)->exists()) {
            $this->course = Course::find($course);
        } else {
            $this->course = $course;
        }
        $this->group = $group;
        $this->filterByBatch = $filterByBatch;
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
            Column::make(trans('Image'), 'image')->hideIf(true),
            Column::make(trans('Last Name'), 'lname')->hideIf(true),
            ComponentColumn::make("Name", "name")
                ->component('partials.user_profile')
                ->attributes(fn ($value, $row, Column $column) => [
                    'user' => $row
                ])->searchable()->sortable(),
            Column::make(trans('Email'), "email")->searchable()->sortable(),
            Column::make(trans('Phone'), "phone"),
            Column::make(trans("Username"), "username")->searchable()->sortable(),
            Column::make(trans('Status'), 'status')->view('components.partials.status')->sortable(),
            Column::make(trans('Action'), 'slug')->view('jambasangsang.backend.users.partials.action'),
        ];
    }

    public function builder(): Builder
    {
        $q = User::query()->role([$this->group])->when($this->filterByBatch, fn ($qu) => $qu->whereHas('batches', function ($query) {
            $query->where('batch_id', getActiveBatch()->id);
        }));

        if ($this->course !== 'all') {
            $q = $q->whereHas('courses', function ($query) {
                $query->where('course_id', $this->course->id);
            });
        }

        $q->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('name', 'like', '%' . $name . '%'))
            ->when($this->columnSearch['lname'] ?? null, fn ($query, $lname) => $query->where('lname', 'like', '%' . $lname . '%'))
            ->when($this->columnSearch['email'] ?? null, fn ($query, $email) => $query->where('email', 'like', '%' . $email . '%'))
            ->when($this->columnSearch['username'] ?? null, fn ($query, $username) => $query->where('username', 'like', '%' . $username . '%'))
            ->latest();

        return $q;
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Status', 'status')
                ->options([
                    '' => 'All',
                    'Enabled' => 'Enabled',
                    'Disabled' => 'Disabled',
                ])
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('users.status', $value);
                }),
        ];
    }

    public function bulkActions(): array
    {
        return [
            'enable' => 'Enable',
            'disable' => 'Disable',
        ];
    }

    public function enable()
    {
        User::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Enabled()]);
        $this->clearSelected();
    }

    public function disable()
    {
        User::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Disabled()]);
        $this->clearSelected();
    }
}
