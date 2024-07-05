<div>
    <div class="mb-3 card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5 border-right">
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Batch:</h6>
                        </div>
                        <div class="col-sm-8 text-secondary">
                            {{ str_limit($payment_log->batch->name ?? '', 56) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Course:</h6>
                        </div>
                        <div class="col-sm-8 text-secondary">
                            {{ str_limit($payment_log->course->title ?? '', 60) }}
                            <p class="m-0 p-0">
                                <small>{{ str_limit($payment_log->course->course_master->name ?? '', 60) }}</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-5 border-right">
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Fee:</h6>
                        </div>
                        <div class="col-sm-8 text-secondary">
                            {{ formatMoney($payment_log->fee) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Fee After Discount:</h6>
                        </div>
                        <div class="col-sm-8 text-secondary">
                            {{ formatMoney($payment_log->fee_after_discount) }}
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-5 border-right">
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Discount(%):</h6>
                        </div>
                        <div class="col-sm-8 text-secondary">
                            {{ formatDiscount($payment_log->discount) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Next Payment Due Date:</h6>
                        </div>
                        <div class="col-sm-8 text-secondary">
                            {{ $payment_log->next_payment_due_date ? $payment_log->next_payment_due_date->format('d F, Y') : '' }}
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-5 border-right">
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Balance:</h6>
                        </div>
                        <div class="col-sm-8 text-secondary">
                            {{ formatMoney($payment_log->getBalance()) }}
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Total Amount Paid:</h6>
                        </div>
                        <div class="col-sm-8 text-secondary">
                            {{ formatMoney($payment_log->getTotalPayments()) }}
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-12">
                    <h6 class="my-2">Transaction History:</h6>
                </div>
                <div class="col-sm-12 text-secondary">

                    {{-- {{ $payment_log->payment }} --}}
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Amount Paid</th>
                                <th>Invoice ID</th>
                                <th>Payment Mode</th>
                                <th>Proof of Payment</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ formatMoney($payment_log->payment->amount_paid) }}</td>
                                <td>{{ $payment_log->payment->invoice_id ?? '' }}</td>
                                <td>{{ ucwords($payment_log->payment->payment_mode ?? '') }}</td>
                                <td>
                                    @isset($payment_log->payment->proof_of_payment)
                                        <a href="{{ $payment_log->payment->proof_of_payment }}" target="_blank"><small>preview</small></a>
                                    @endisset
                                </td>
                                <td>{{ $payment_log->payment->created_at }}</td>
                            </tr>
                            @foreach ($payment_log->payment->children as $key => $payment)
                            <tr>
                                <td>{{ formatMoney($payment->amount_paid) }}</td>
                                <td>{{ $payment->invoice_id ?? '' }}</td>
                                <td>{{ ucwords($payment->payment_mode ?? '') }}</td>
                                <td>
                                    @isset($payment->proof_of_payment)
                                        <a href="{{ $payment->proof_of_payment }}" target="_blank"><small>preview</small></a>
                                    @endisset
                                </td>
                                <td>{{ $payment->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- {{ $user->city ?? '' }} --}}
                </div>
            </div>
            <hr>
        </div>
    </div>
</div>
