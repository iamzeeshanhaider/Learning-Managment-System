<?php

namespace App\Http\Livewire\Backend;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\GeneralStatus;

class ActivityLogsTable extends DataTableComponent
{
    public $userID = 'all';
    public string $tableName = 'activity_logs';
    public array $logs = [];

    public $columnSearch = [
        'action' => null,
        'name' => null,
    ];

    public function mount($userID): void
    {
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
            Column::make(trans('Model'), 'module_name')->hideIf(true),
            Column::make(trans('User'), 'user.name')->sortable()->searchable(),
            Column::make(trans('IP'), 'ip_address'),
            Column::make(trans('Action'), 'action')->sortable()
                ->format(
                    fn ($value, $row, Column $column) => '<span" >' . $row->action . ' ' . $row->module_name . '</span>'
                )
                ->html(),

            Column::make(trans('Date'), 'created_at'),
            Column::make(trans(''), 'id')->view('jambasangsang.backend.activity_logs.partials.action'),
        ];
    }

    public function builder(): Builder
    {
        return ActivityLog::query()
            ->when($this->userID !== 'all', fn ($query) => $query->where('user_id', $this->userID))
            ->when($this->columnSearch['name'] ?? null, fn ($query, $name) => $query->whereHas('user', function ($query) use ($name) {
                $query->where('users.name', 'like', '%' . $name . '%');
            }))
            ->latest('activity_logs.created_at');
    }
}
