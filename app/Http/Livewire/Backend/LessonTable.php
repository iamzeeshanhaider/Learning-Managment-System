<?php

namespace App\Http\Livewire\Backend;

use App\Enums\GeneralStatus;
use App\Models\Course;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class LessonTable extends DataTableComponent
{
    public string $tableName = 'lessons';
    public array $lessons = [];
    public $course = null;

    public $columnSearch = [
        'name' => null,
        'title' => null,
    ];


    public function mount($course): void
    {
        if (isset($course) && Course::where('id', $course)->exists()) {
            $this->course = $course;
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
            Column::make(trans("Name"), "name")->sortable()->searchable(),
            Column::make(trans('Learning Outcome'), 'outcome')->view('jambasangsang.backend.lessons.partials.editor-display'),
            Column::make(trans("Course"), "course.title")->searchable(),
            Column::make(trans('Status'), 'status')->view('components.partials.status')->sortable()->sortable(),
            Column::make(trans('Action'), 'slug')->view('jambasangsang.backend.lessons.partials.action'),
            Column::make(trans('Image'), 'image')->hideIf(true),
        ];
    }
    public function builder(): Builder
    {
        return Lesson::query()->when($this->course ?? null, fn ($query) => $query->where('course_id', $this->course))
            ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('name', 'like', '%' . $name . '%'))
            ->when($this->columnSearch['title'] ?? null, fn ($query, $title) => $query->where('course.title', 'like', '%' . $title . '%'))
            ->with([
                'course' => fn ($q) => $q->with('course_master:id,name')->latest()
            ])
            ->withCount(['resources', 'folders'])
            ->latest('lessons.created_at');
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
                    $builder->where('lessons.status', $value);
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
        Lesson::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Enabled()]);

        $this->clearSelected();
    }

    public function disable()
    {
        Lesson::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Disabled()]);

        $this->clearSelected();
    }
}
