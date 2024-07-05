<?php

namespace App\Http\Livewire\Backend;

use App\Enums\GeneralStatus;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class EventTable extends DataTableComponent
{
    public string $tableName = 'events';
    public array $events = [];

    public $columnSearch = [
        'title' => null,
    ];

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
            Column::make(trans('Title'), "title")->searchable()->sortable(),
            Column::make(trans('Date'), "date"),
            Column::make(trans('Group'), "group")->sortable(),
            Column::make(trans('Status'), 'status')->view('components.partials.status')->sortable(),
            Column::make(trans('Action'), 'slug')->view('jambasangsang.backend.events.partials.action'),
        ];
    }

    public function builder(): Builder
    {
        return Event::query()
            ->when($this->columnSearch['title'] ?? null, fn ($query, $name) => $query->where('events.title', 'like', '%' . $name . '%'))
            ->latest();
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Status', 'status')
                ->options([
                    '' => 'All',
                    'Enabled' => 'Published',
                    'Disabled' => 'Draft',
                ])
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('events.status', $value);
                }),
        ];
    }

    public function bulkActions(): array
    {
        return [
            'enable' => 'Publish',
            'draft' => 'Draft',
        ];
    }

    public function enable()
    {
        Event::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Enabled()]);
        $this->clearSelected();
    }

    public function draft()
    {
        Event::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Disabled()]);
        $this->clearSelected();
    }
}
