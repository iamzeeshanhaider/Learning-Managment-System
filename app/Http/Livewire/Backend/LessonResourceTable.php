<?php

namespace App\Http\Livewire\Backend;

use App\Enums\GeneralStatus;
use App\Models\Lesson;
use App\Models\LessonFolder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\LessonResource;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class LessonResourceTable extends DataTableComponent
{

    public string $tableName = 'lesson_resources';
    public array $lesson_resources = [];
    public $lesson, $folder;

    public $columnSearch = [
        'name' => null,
    ];

    public function mount(Lesson $lesson, $folder = null): void
    {
        $this->lesson = $lesson;
        $this->folder = $folder ? LessonFolder::find($folder->id) : null;
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
            Column::make(trans('File'), 'file')->hideIf(true),
            Column::make(trans('URL'), 'url')->hideIf(true),
            Column::make(trans('Extention'), 'extention')->hideIf(true),
            Column::make(trans('Name'), 'name')
                ->format(
                    fn ($value, $row, Column $column) => '
                        <a href="' . $row->file() . '" target="_blank" class="text-truncate">' . $row->name . '</a>
                    '
                )
                ->html()->sortable()->searchable(),
            Column::make(trans('Status'), 'status')->view('components.partials.status')->sortable(),
            Column::make(trans('Type'), 'type')->view('jambasangsang.backend.lessons.resources.partials.types')->sortable(),
            Column::make(trans('Action'), 'slug')->view('jambasangsang.backend.lessons.resources.partials.action'),
        ];
    }
    public function builder(): Builder
    {
        $q = LessonResource::query()->where(['lesson_id' => $this->lesson->id, 'folder_id' => $this->folder ? $this->folder->id : null]);
        $lesson_resources = $q->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('lesson_resource.name', 'like', '%' . $name . '%'))
            ->with(['lesson', 'folder'])
            ->latest('lesson_resources.created_at');

        return $lesson_resources;
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
                    $builder->where('lesson_resources.status', $value);
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

        LessonResource::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Enabled()]);

        $this->clearSelected();
    }

    public function disable()
    {
        LessonResource::whereIn('id', $this->getSelected())->update(['status' => GeneralStatus::Disabled()]);

        $this->clearSelected();
    }
}
