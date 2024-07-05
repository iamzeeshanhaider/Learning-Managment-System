<div class="btn-group">
    <a onclick="handleGeneralModal(this)" class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        data-link="{{ route('users.edit', ['group' => $this->group, 'user' => $row->slug]) }}" title="Edit User">
        <i class="fa fa-edit"></i>
    </a>
    <a href="{{ route('users.show', ['group' => $this->group, 'user' => $row->slug]) }}"
        class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}" title="Preview User Data">
        Manage
    </a>
</div>
