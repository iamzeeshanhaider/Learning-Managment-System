<div class="curriculam-cont">

    @if (!$certificate['is_revoked'])
        <iframe class="embed-responsive-item" src="{{ getFilePath($certificate['path']) . '#toolbar=0&navpanes=0' }}"
            loading="lazy" name="{{ $certificate['name'] }}" width="100%" height="750">
            This browser does not support PDFs. Please download here:
            <a class="btn btn-sm btn-primary text-white" href="{{ route('certificate.download', $certificate['id']) }}"
                title="Download Certificate">
                <i class="fa fa-download"></i> Download PDF
            </a>
        </iframe>
    @else
        <div class="p-5 text-center card shadow border-0">
            <h4>
                This Certificate has been placed on hold. Please contact your instructor to get further clarifications
            </h4>
        </div>
    @endif

    <div class="text-right my-3">
        <div class="btn-group" role="group" aria-label="Basic example">

            @if (!$certificate['is_revoked'])
                @if (!request()->routeIs('settings.index'))
                    <a onclick="handleGeneralModal(this)"
                        data-link="{{ route('certificate.send', ['certificate' => $certificate['id'], 'user' => $user->slug ?? null]) }}"
                        title="Send to Mail" type="button" class="text-white btn btn-sm btn-success"><i
                            class="fa fa-envelope"></i></a>
                @endif
                <a class="btn btn-sm btn-warning text-white"
                    href="{{ request()->fullUrlWithQuery(['refresh' => 'true']) }}" title="Re-Generate Certificate">
                    <i class="fa fa-refresh"></i>
                </a>

                <a class="btn btn-sm btn-primary text-white"
                    href="{{ route('certificate.download', $certificate['id']) }}" title="Download Certificate">
                    <i class="fa fa-download"></i>
                </a>
            @endif

            @if (!auth()->user()->isStudent())
                <a class="btn btn-sm {{ !$certificate['is_revoked'] ? 'btn-success' : 'btn-danger' }} text-white"
                    href="{{ route('certificate.revoke', $certificate['id']) }}"
                    title="{{ !$certificate['is_revoked'] ? 'Activate Certificate' : 'Revoke Certificate' }}">
                    <i class="fa fa-{{ !$certificate['is_revoked'] ? 'play' : 'pause' }}"></i>
                </a>
            @endif
        </div>
    </div>

</div>
