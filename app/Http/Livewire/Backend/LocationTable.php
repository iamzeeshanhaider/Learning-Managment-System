<?php

namespace App\Http\Livewire\Backend;

use App\Enums\GeneralStatus;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Location;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class LocationTable extends DataTableComponent
{
    public string $tableName = 'locations';
    public array $locations = [];

    public $columnSearch = [
        'name' => null,
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
            Column::make(trans('Slug'), "slug")->hideIf(true),
            Column::make(trans('Name'), "name")->sortable()->searchable(),
            Column::make(trans('Description'), 'description')->view('jambasangsang.backend.locations.partials.editor-display')->collapseOnMobile(),
            Column::make(trans('Seat capacity'), "seat_capacity")->sortable(),
            Column::make(trans('Remaining Seat'), "remaining_seat")->sortable(),
            Column::make(trans('Type'), 'type')->view('components.partials.type')->collapseOnMobile(),
            Column::make(trans('Status'), 'status')->view('components.partials.status')->sortable(),
            Column::make(trans('Action'), 'slug')->view('jambasangsang.backend.locations.partials.action'),
        ];
    }

    public function builder(): Builder
    {
        return Location::query()
            ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('name', 'like', '%' . $name . '%'))
            ->latest();
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Status', 'status')
            ->options([
                    '' => 'All',
                    'enabled' => 'Enabled',
                    'disabled' => 'Disabled',
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->where('locations.status', $value);
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
        Location::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Enabled()]);

        $this->clearSelected();
    }

    public function disable()
    {
        Location::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Disabled()]);

        $this->clearSelected();
    }
}
