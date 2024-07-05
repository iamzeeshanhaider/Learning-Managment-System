<?php

namespace App\Http\Livewire\Backend;

use App\Enums\GeneralStatus;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Course;
use App\Models\CourseMaster;
use App\Models\Module;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class CourseTable extends DataTableComponent
{
    public string $tableName = 'courses';
    public array $courses = [];
    public $courseMaster = null;
    public $module = null;

    public $columnSearch = [
        'name' => null,
    ];

    public function mount($courseMaster, $module): void
    {
        if (isset($courseMaster) && CourseMaster::where('id', $courseMaster)->exists()) {
            $this->courseMaster = $courseMaster;
        }

        if (isset($module) && Module::where('id', $module)->exists()) {
            $this->module = $module;
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
            Column::make(trans('Title'), 'title')->sortable()->searchable(),
            Column::make(trans('Price'), 'price')->sortable()->view('components.partials.price'),
            Column::make(trans('Instructor'), 'instructor.name'),
            Column::make(trans('Location'), 'location.type')->view('components.partials.type'),
            Column::make(trans('Slug'), 'slug')->hideIf(true),
            Column::make(trans('Image'), 'image')->hideIf(true),
            Column::make(trans('Status'), 'status')->view('components.partials.status')->sortable(),
            Column::make(trans('Action'), 'slug')->view('jambasangsang.backend.courses.partials.action'),
        ];
    }

    public function builder(): Builder
    {
        return Course::query()->when($this->courseMaster ?? null, fn ($query) => $query->where('course_master_id', $this->courseMaster))
            ->when($this->module ?? null, fn ($query) => $query->where('module_id', $this->module))
            ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('name', 'like', '%' . $name . '%'))
            ->with(['course_master', 'location'])
            ->withCount(['lessons', 'students', 'quizzes'])
            ->latest('courses.created_at');
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
                ->filter(function(Builder $builder, string $value) {
                    $builder->where('courses.status', $value);
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
        Course::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Enabled()]);

        $this->clearSelected();
    }

    public function disable()
    {
        Course::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Disabled()]);

        $this->clearSelected();
    }

}
