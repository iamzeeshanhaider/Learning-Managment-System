<?php

namespace App\Http\Livewire\Backend;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Attendance as ModelAttendance;
use Illuminate\Database\Eloquent\Builder;

class AttendanceTable extends DataTableComponent
{
    public string $tableName = 'attendances';
    public array $attendances = [];

    public $columnSearch = [
        'name' => null,
    ];

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
            Column::make(trans('User'), 'user.name')->sortable(),

            Column::make(trans('Date'), 'date')
            ->format(
                fn($value, $row, Column $column) => '<span" >'.$row->date->format('Y-m-d'). '</span>'
            )->html()->sortable(),

            Column::make(trans('Time In'), 'time_in')
            ->format(
                fn($value, $row, Column $column) => '<span" >'.$row->time_in->format('H:i A'). '</span>'
            )->html()->sortable(),

            Column::make(trans('Time Out'), 'time_out')
            ->format(
                fn($value, $row, Column $column) => '<span" >'.$row->time_out->format('H:i A'). '</span>'
            )->html()->sortable(),
        ];
    }

    public function builder(): Builder
    {
        return ModelAttendance::query()
            ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->whereHas('user', function ($q) use ($name) {
                $q->where('name', 'LIKE', '%' . $name . '%')->orWhere('lname', 'LIKE', '%' . $name . '%');
            }))->latest('attendances.created_at');
    }
}
