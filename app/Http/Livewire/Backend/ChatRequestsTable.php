<?php

namespace App\Http\Livewire\Backend;

use App\Models\User;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Chat;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\GeneralStatus;

class ChatRequestsTable extends DataTableComponent
{
    public $userID = 'all';
    public string $tableName = 'chats';
    public array $logs = [];

    public $columnSearch = [
        'status' => null,
        'issue' => null,
        'assigned_to_id' => null,
    ];

    public function mount($userID): void {}

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setPerPageAccepted([10, 25, 50, 100])
            ->setFiltersStatus(false)
            ->setFiltersVisibilityStatus(true)
            ->setFilterLayout('slide-down')
            ->setColumnSelectDisabled()
            ->setEmptyMessage('No results found')
            ->setHideBulkActionsWhenEmptyEnabled();
    }


    public function columns(): array
    {
        return [
            Column::make(trans('ID'), 'id')->hideIf(true),
            Column::make(trans('User'), 'created_by.name'),

            Column::make(trans('Instructor'), 'assigned_to_id')
                ->format(
                    fn($value, $row, Column $column) =>isset($row->assigned_to->name) ? $row->assigned_to->name : ""
                )
                ->html(),
            Column::make(trans('Status'), 'status'),
            Column::make(trans('Date'), 'created_at'),
            Column::make(trans(''), 'id')->view('jambasangsang.backend.chat_requests.partials.action'),
        ];
    }

    public function filters(): array
    {
        return [
            //
        ];
    }

    public function builder(): Builder
    {
        return Chat::with(['created_by', 'assigned_to'])
            ->latest('chats.created_at');
    }




}
