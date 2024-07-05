<div class="btn-group">
    <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-primary" title="View More"
        data-link="{{ route('student.payment_log', $row->id) }}">
        <i class="fa fa-eye"></i>
    </a>
    <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-primary" title="View More"
        data-link="{{ route('student.payment.add', $row->id) }}">
        <i class="fa fa-plus"></i> Add Payment
    </a>
</div>
