<?php

namespace App\Observers;

use App\Models\Payment;

class PaymentObserver
{
    /**
     * Handle the Payment "saving" event.
     *
     * @param  \App\Models\Payment $payment
     * @return void
     */
    public function saving(Payment $payment)
    {
        if(request()->hasFile('proof_of_payment')){
            $payment->proof_of_payment = uploadOrUpdateFile(request()->file('image'), $payment->proof_of_payment, \constPath::PaymentProof);
        }
    }
}
