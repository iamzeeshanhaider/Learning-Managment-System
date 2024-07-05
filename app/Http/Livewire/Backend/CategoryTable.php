<?php

namespace App\Http\Livewire\Backend;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\GeneralStatus;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class CategoryTable extends DataTableComponent
{
    public string $tableName = 'categories';
    public array $categories = [];

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
            Column::make(trans('Name'), 'name')->sortable()->searchable(),
            Column::make(trans('Slug'), 'slug')->hideIf(true),
            Column::make(trans('Description'), 'description')->view('jambasangsang.backend.categories.partials.editor-display'),
            Column::make(trans('Status'), 'status')->view('components.partials.status')->sortable(),
            Column::make(trans('Action'), 'slug')->view('jambasangsang.backend.categories.partials.action'),
        ];
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
                    $builder->where('status', $value);
                }),
        ];
    }

    public function builder(): Builder
    {
        return Category::query()
            ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('name', 'like', '%' . $name . '%'))
            ->withCount(['courses_master'])
            ->latest();
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
        Category::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Enabled()]);

        $this->clearSelected();
    }

    public function disable()
    {
        Category::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Disabled()]);

        $this->clearSelected();
    }
}
