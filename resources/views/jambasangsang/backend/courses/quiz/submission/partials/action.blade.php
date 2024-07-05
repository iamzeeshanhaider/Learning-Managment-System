<div class="btn-group">
    <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-primary"
        data-link="{{ route('submission.show', ['quiz' => $this->quiz->slug, 'submission' => $row->id]) }}"
        title="Preview Submission">
        <i class="fa fa-eye"></i>
    </a>
</div>
