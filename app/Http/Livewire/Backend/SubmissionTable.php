<?php

namespace App\Http\Livewire\Backend;

use App\Models\Quiz;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Submission;
use Illuminate\Database\Eloquent\Builder;

class SubmissionTable extends DataTableComponent
{
    public string $tableName = 'submissions';
    public $quiz;
    public array $submissions = [];

    public $columnSearch = [
        'name' => null,
        'course_title' => null,
        'batch_name' => null,
    ];

    public function mount(Quiz $quiz): void
    {
        $this->quiz = $quiz;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setPerPageAccepted([10, 25, 50, 100])
            ->setColumnSelectDisabled()
            ->setEmptyMessage('No results found')
            ->setHideBulkActionsWhenEmptyEnabled();
    }

    public function columns(): array
    {
        return [
            Column::make(trans('ID'), 'id')->hideIf(true),
            Column::make(trans('Student ID'), "student.bio.student_id"),
            Column::make(trans('Course'), "quiz.course.title")->searchable(),
            Column::make(trans('Batch'), "batch.name")->searchable(),
            Column::make(trans('Date of Submission'), 'created_at')
                ->format(
                    fn ($value, $row, Column $column) => $value->diffForHumans()
                )
                ->html(),
            Column::make(trans('Score'), 'id')->view('jambasangsang.backend.courses.quiz.submission.partials.score_formatter')->sortable(),
            Column::make(trans('Action'), 'id')->view('jambasangsang.backend.courses.quiz.submission.partials.action'),
        ];
    }

    public function builder(): Builder
    {
        $q = Submission::where('quiz_id', $this->quiz->id)->with(['student' => fn ($q) => $q->with('bio'), 'quiz']);

        $q->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->whereHas('student', function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }))
            ->when($this->columnSearch['batch_name'] ?? null, fn ($query, $batch_name) => $query->whereHas('batch', function ($query) use ($batch_name) {
                $query->where('batches.name', 'like', '%' . $batch_name . '%');
            }))
            ->when($this->columnSearch['course_title'] ?? null, fn ($query, $course_title) => $query->whereHas('course', function ($query) use ($course_title) {
                $query->where('courses.title', 'like', '%' . $course_title . '%');
            }));

        $q->latest('submissions.created_at')->get()->groupBy('student_id');

        return $q;
    }

    public function bulkActions(): array
    {
        return [
            // 'mass_grade' => 'Mass Grade',
        ];
    }

    public function mass_grade($request)
    {
        Submission::whereIn('id', $this->getSelected())->update(['grade' => $request->get('grade')]);
        $this->clearSelected();
    }
}
