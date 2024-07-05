<?php

namespace App\Http\Livewire\Backend;

use App\Enums\GeneralStatus;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Payment;
use App\Models\BatchUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class PaymentsTable extends DataTableComponent
{
    public string $tableName = 'payments';
    public string $group = 'student';
    public string $student;
    public array $payments = [];

    public function mount(string $group, string $student): void
    {
        if ($group === 'student') {
            $this->group = $group;
        }

        if ($student && User::where('id', $student)->exists()) {
            $this->student = $student;
        }
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
            Column::make(trans('Batch'), 'batch.name'),
            Column::make(trans('Course'), 'course.title'),
            Column::make(trans('Fee'), 'fee')->format(
                fn ($value, $row, Column $column) => formatMoney($value)
            )
                ->html(),
            Column::make(trans('Discount'), 'discount')->format(
                fn ($value, $row, Column $column) => formatDiscount($value)
            )
                ->html(),
            Column::make(trans('Fee After Discount'), 'fee_after_discount')->format(
                fn ($value, $row, Column $column) => formatMoney($value)
            )
                ->html(),
            Column::make(trans('Action'), 'id')->view('jambasangsang.backend.users.partials.student.payments.action'),
        ];
    }

    public function builder(): Builder
    {
        $query = BatchUser::where('student_id', $this->student)
            ->with([
                'student',
                'batch',
                'payment' => fn ($q) => $q->with('children'),
                'course' => fn ($q) => $q->with('course_master'),
            ])
            ->latest('batch_users.created_at');
        return $query;
    }
}
