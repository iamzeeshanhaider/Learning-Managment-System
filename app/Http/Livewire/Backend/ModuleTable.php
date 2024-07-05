<?php

namespace App\Http\Livewire\Backend;

use App\Enums\GeneralStatus;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Module;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class ModuleTable extends DataTableComponent
{
    public string $tableName = 'modules';
    public array $modules = [];

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
            Column::make(trans('Image'), 'image')
                ->format(
                    fn ($value, $row, Column $column) => '
                    <img src="' . $row->image() . '" alt="' . $row->name . '" width="60" height="60" style="object-fit: contain; object-position: top center;">
                    '
                )
                ->html(),
            Column::make(trans('Name'), 'name')->searchable()->sortable(),
            Column::make(trans('Description'), 'description')->view('jambasangsang.backend.modules.partials.editor-display'),
            Column::make(trans('Status'), 'status')->view('components.partials.status')->sortable(),
            Column::make(trans('Action'), 'slug')->view('jambasangsang.backend.modules.partials.action'),
        ];
    }

    public function builder(): Builder
    {
        return Module::query()
            ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('modules.name', 'like', '%' . $name . '%'))
            ->withCount(['courses'])
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
                    $builder->where('modules.status', $value);
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
        Module::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Enabled()]);

        $this->clearSelected();
    }

    public function disable()
    {
        Module::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Disabled()]);

        $this->clearSelected();
    }
}
