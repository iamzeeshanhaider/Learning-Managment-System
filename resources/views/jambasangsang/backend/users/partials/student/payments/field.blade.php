<div>
    <div class="row">
        <div class="col-md-6">
            <label for="fee" class="mb-1 control-label">@lang('Fee')</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="fee-addon1">{{ Config::get('settings.symbol') }}</span>
                </div>
                <input
                    type="number" class="form-control" placeholder="0" id="fee" name="fee" aria-label="fee"
                    {{ isset($batchUser) ? 'readonly' : '' }}
                    aria-describedby="fee-addon1" step="0.01" min="0" value="{{ isset($batchUser) ? $batchUser->fee : old('fee') }}">
            </div>
        </div>

        <div class="col-md-6">
            <label for="discount" class="mb-1 control-label">@lang('Discount') <small>(in %)</small></label>
            <div class="input-group mb-3">
                <input type="number" class="form-control" placeholder="0" aria-label="discount" id="discount"
                {{ isset($batchUser) ? 'readonly' : '' }}
                    name="discount" aria-describedby="discount-addon1"step="0.01" min="0"
                    value="{{ isset($batchUser) ? $batchUser->discount : old('discount') }}">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="discount-addon1">%</span>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="fee_after_discount" class="mb-1 control-label">@lang('Fee After Discount')</label>
                <input id="fee_after_discount" name="fee_after_discount" min="0" step="0.01" type="number"
                    class="form-control valid" readonly value="{{ isset($batchUser) ? $batchUser->fee_after_discount : old('fee_after_discount') }}">
            </div>
        </div>

        <div class="col-md-6">
            <label for="amount_paid" class="mb-1 control-label">@lang('Amount Paid')</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="amount_paid-addon1">{{ Config::get('settings.symbol') }}</span>
                </div>
                <input type="number" class="form-control" placeholder="0" id="amount_paid" name="amount_paid"
                    aria-label="amount_paid" aria-describedby="amount_paid-addon1" required min="0" step="0.01"
                    value="{{ old('amount_paid') }}"
                    @isset($batchUser)
                    max="{{ $batchUser->getBalance() }}"
                    @endisset
                >
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="invoice_id" class="mb-1 control-label">@lang('Invoice Ref')</label>
                <input id="invoice_id" name="invoice_id" type="text" class="form-control valid"
                    value="{{ old('invoice_id') }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="next_payment_due_date" class="mb-1 control-label">@lang('Next Payment Due Date')</label>
                <input id="next_payment_due_date" name="next_payment_due_date" type="date" min="{{ now() }}"
                    class="form-control valid" value="{{ old('next_payment_due_date') }}">
            </div>
        </div>

        <div class="col-md-6">
            <label for="payment_mode" class="mb-1 control-label">@lang('Payment mode')</label>
            <div class="input-group">
                <select class="form-control" aria-label="Select Payment Mode" name="payment_mode" id="payment_mode">
                    <option selected disabled value="">Select Payment Mode</option>
                    <option value="cash">Cash</option>
                    <option value="cheque">Cheque</option>
                    <option value="card">Card</option>
                    <option value="mobile_wallet">Mobile Wallet</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="others">Others</option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="proof_of_payment" class="mb-1 control-label">@lang('Proof of Payment')</label>
                <input id="proof_of_payment" name="proof_of_payment" type="file" value=""
                    class="form-control proof_of_payment" accept="image/*, .pdf">
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('fee').addEventListener('keyup', function(e) {
        updateFeePayable();
    })
    document.getElementById('discount').addEventListener('keyup', function(e) {
        updateFeePayable();
    })

    function updateFeePayable() {
        const feeAmount = parseFloat(document.getElementById("fee").value),
            discountPercentage = parseFloat(document.getElementById("discount").value) / 100;
        document.getElementById('fee_after_discount').value = parseFloat(feeAmount).toFixed(2);

        if (feeAmount > 0 && discountPercentage > 0) {
            setTimeout(function() {
                let feePayable = feeAmount - (feeAmount * discountPercentage);
                document.getElementById('fee').value = parseFloat(feeAmount).toFixed(2);
                document.getElementById('fee_after_discount').value = parseFloat(feePayable).toFixed(2);
                document.getElementById('amount_paid').setAttribute('max', parseFloat(feeAmount).toFixed(2));
            }, 2000);
        }
    }
</script>
