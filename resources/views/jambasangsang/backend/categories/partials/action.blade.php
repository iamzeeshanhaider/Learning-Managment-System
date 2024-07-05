<div class="btn-group">
    <a onclick="handleGeneralModal(this)"
        class="text-white btn btn-sm btn-primary"
        data-link="{{ route('categories.edit', $row->slug) }}" title="Edit Category">
        <i class="fa fa-edit"></i>
    </a>
    <a onclick="handleGeneralModal(this)"
        class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        data-link="{{ route('categories.show', $row->slug) }}" title="Preview">
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('courses_masters.index', ['category' => $row->slug]) }}"
        class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        title="View Courses">Course Masters ({!! formatCount($row->courses_master_count) !!})</a>
</div>
