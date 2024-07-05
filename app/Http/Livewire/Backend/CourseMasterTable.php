<?php

namespace App\Http\Livewire\Backend;

use App\Enums\GeneralStatus;
use App\Models\Category;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\CourseMaster;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class CourseMasterTable extends DataTableComponent
{
    public string $tableName = 'courseMaster';
    public array $courseMaster = [];
    public $category = null;

    public $columnSearch = [
        'name' => null,
    ];

    public function mount($category): void
    {
        if (isset($category) && Category::where('id', $category)->exists()) {
            $this->category = $category;
        }
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
            Column::make(trans('Name'), 'name')->sortable()->searchable(),
            Column::make(trans('Description'), 'description')->view('jambasangsang.backend.course_master.partials.editor-display'),
            Column::make(trans('Status'), 'status')->view('components.partials.status')->sortable(),
            Column::make(trans('Action'), 'slug')->view('jambasangsang.backend.course_master.partials.action'),
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
        return CourseMaster::query()->when($this->category ?? null, fn ($query) => $query->where('category_id', $this->category))
            ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('name', 'like', '%' . $name . '%'))
            ->withCount(['courses'])
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
        CourseMaster::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Enabled()]);

        $this->clearSelected();
    }

    public function disable()
    {
        CourseMaster::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Disabled()]);

        $this->clearSelected();
    }
}
