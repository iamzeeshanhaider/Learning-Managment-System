<div>
    <form action="{{ route('certificate.send-to-mail', $certificate['id']) }}" method="POST" enctype="multipart/form-data"
        onsubmit="$('#certificate-button').attr('disabled', true)">
        @csrf

        <div class="form-group mb-3">
            <x-select.users
                :label="isset($student) ? 'Send to Me' : 'Send to Student'"
                :selected="isset($student) ? $student->id : ''"
                required="{{ false }}"
                readonly="{{ isset($student) ? true : false }}"
            />
        </div>

        <div class="form-group mb-3">
            <label for="external_email">Send to External Email</label>
            <input type="email" class="form-control" id="external_email" name="external_email" placeholder="Enter email">
        </div>

        <div class="text-right">
            <button id="certificate-button" type="submit" class="btn btn-sm btn-primary">
                <i class="fa fa-arrow-right fa-sm"></i> Send
            </button>
        </div>
    </form>
</div>
