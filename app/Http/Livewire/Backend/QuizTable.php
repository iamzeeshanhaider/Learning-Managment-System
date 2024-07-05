<?php

namespace App\Http\Livewire\Backend;

use App\Enums\GeneralStatus;
use App\Models\Course;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class QuizTable extends DataTableComponent
{
    public string $tableName = 'quizzes';
    public array $quizzes = [];
    public $course;
    public bool $filterByBatch = false;

    public $columnSearch = [
        'name' => null,
        'batch_name' => null,
    ];

    public function mount($course = null, $filterByBatch = false): void
    {
        $this->course = !is_null($course) ? Course::find($course) : $course;
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
            Column::make(trans('Slug'), "slug")->hideIf(true),
            Column::make(trans('Title'), "title")->searchable(),
            Column::make(trans('Batch'), 'batch.name')
                ->format(
                    fn ($value, $row, Column $column) => str_limit($value, 50)
                )
                ->html()->sortable()->searchable(),
            Column::make(trans('Start Date'), 'start_time')
                ->format(
                    fn ($value, $row, Column $column) => '<small data-expire="' . (!is_null($row->start_time) ? $row->start_time : '') . '" class="m-1 ' . (!is_null($row->start_time) && $row->start_time->isFuture() ? 'iro-countdown text-success' : 'text-danger') . '" >' . !is_null($row->start_time) && $row->start_time ? $row->start_time->format('j/m/Y - H:i A') : 'N/A' . '</small>'
                )
                ->html()->sortable(),
            Column::make(trans('End Date'), 'end_time')
                ->format(
                    fn ($value, $row, Column $column) => '<small data-expire="' . (!is_null($row->end_time) ? $row->end_time : '') . '" class="m-1 ' . (!is_null($row->end_time) && $row->end_time->isFuture() ? 'iro-countdown text-success' : 'text-danger') . '" >' . !is_null($row->end_time) && $row->end_time ? $row->end_time->format('j/m/Y - H:i A') : 'N/A' . '</small>'
                )
                ->html()->sortable(),
            Column::make(trans('Duration'), 'duration')
                ->format(
                    fn ($value, $row, Column $column) => gmdate('i:s', $value)
                )
                ->html()->sortable(),
            Column::make(trans('Status'), 'status')->view('components.partials.status'),
            Column::make(trans('Action'), 'slug')->view('jambasangsang.backend.courses.quiz.partials.action'),
        ];
    }

    public function builder(): Builder
    {
        return Quiz::query()
            ->with(['submissions', 'course'])
            ->withCount(['submissions'])
            ->when($this->course, fn ($query) => $query->where('course_id', $this->course->id))
            ->when($this->filterByBatch, fn ($query) => $query->where('batch_id', getActiveBatch()->id))
            ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('quizzes.name', 'like', '%' . $name . '%'))
            ->when($this->columnSearch['batch_name'] ?? null, fn ($query, $batch_name) => $query->whereHas('batch', function ($query) use ($batch_name) {
                $query->where('batches.name', 'like', '%' . $batch_name . '%');
            }))
            ->latest('quizzes.created_at');
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Status', 'status')
                ->options([
                    '' => 'All',
                    'enabled' => 'Publish',
                    'disabled' => 'Un-Publish',
                ])
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('quizzes.status', $value);
                }),
        ];
    }


    public function bulkActions(): array
    {
        return [
            'enable' => 'Publish',
            'disable' => 'Un-Publish',
        ];
    }

    public function enable()
    {
        Quiz::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Enabled()]);
        $this->clearSelected();
    }

    public function disable()
    {
        Quiz::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Disabled()]);
        $this->clearSelected();
    }
}
