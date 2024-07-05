<?php

namespace App\Http\Livewire\Backend;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Batch;
use Illuminate\Database\Eloquent\Builder;

class BatchTable extends DataTableComponent
{
    public string $tableName = 'batches';
    public array $batches = [];

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
            Column::make(trans('Name'), 'name')->sortable()->searchable(),
            Column::make(trans('Description'), 'description')->view('jambasangsang.backend.batches.partials.editor-display'),
            Column::make(trans('Enrolled Students'), 'slug')
                ->format(
                    fn ($value, $row, Column $column) => '<span" >' . $row->students_count . '</span>'
                )
                ->html()->sortable(),
            Column::make(trans('Action'), 'slug')->view('jambasangsang.backend.batches.partials.action'),
        ];
    }

    public function builder(): Builder
    {
        return Batch::query()
            ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->where('name', 'like', '%' . $name . '%'))
            ->with(['students', 'courses'])->withCount(['students'])->latest('batches.created_at');
    }
}
