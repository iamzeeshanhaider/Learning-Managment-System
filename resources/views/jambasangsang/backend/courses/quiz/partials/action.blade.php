<div class="btn-group">
    <a href="{{ route('quiz.edit', ['course' => $row->course->slug, 'quiz' => $row->slug]) }}"
        class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        title="Edit Quiz">
        <i class="fa fa-edit"></i>
    </a>
    <a onclick="handleGeneralModal(this)"
        class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        data-link="{{ route('quiz.show', ['course' => $row->course->slug, 'quiz' => $row->slug]) }}" title="Preview Quiz">
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('submission.index', $row->slug) }}"
        class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        title="View Submissions">
        Submissions ({!! formatCount($row->submissionsCount()) !!})
    </a>

    <a href="{{ route('quiz.clone', ['quiz' => $row->slug]) }}"
        class="text-white btn btn-sm btn-primary {{ is_disabled($row->status) }}"
        title="Clone Quiz">
        <i class="fa fa-clone"></i>
    </a>

    <x-buttons.delete :action="route('quiz.destroy', ['course' => $row->course->slug, 'quiz' => $row->slug])" :index="$row->slug" title="Are you sure you want to delete this Quiz?" />
</div>
