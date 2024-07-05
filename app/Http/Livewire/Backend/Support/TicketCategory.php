<?php

namespace App\Http\Livewire\Backend\Support;

use App\Enums\GeneralStatus;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\TicketCategory as ModelTicketCategory;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class TicketCategory extends DataTableComponent
{
    public string $tableName = 'ticket_categories';
    public array $batches = [];

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
            Column::make(trans('Slug'), 'slug')->hideIf(true),
            Column::make(trans('Name'), 'name')->sortable()->searchable(),
            Column::make(trans('Created By'), 'created_by.name'),
            Column::make(trans('Created At'), 'created_at'),
            Column::make(trans('Status'), 'status')->view('components.partials.status')->sortable(),
            Column::make(trans('Action'), 'slug')->view('jambasangsang.backend.support.category.partials.action'),
        ];
    }

    public function builder(): Builder
    {
        return ModelTicketCategory::query()
            ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('ticket_categories.name', 'like', '%' . $name . '%'))
            ->when($this->getAppliedFilterWithValue('enabled'), fn ($query, $status) => $query->where('status', $status))
            ->with('created_by')
            ->withCount(['tickets'])
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
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('ticket_categories.status', $value);
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
        ModelTicketCategory::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Enabled()]);

        $this->clearSelected();
    }

    public function disable()
    {
        ModelTicketCategory::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Disabled()]);

        $this->clearSelected();
    }
}
