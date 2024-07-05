<div>
    <div class="position-relative">
        <div class="chat-messages p-4 pb-5 mb-2">
            @foreach ($comments as $date => $commentsOnDate)
                <div class="comments-group">
                    <div class="mb-3 text-center">
                        @if ($date === now()->format('Y-m-d'))
                            Today
                        @elseif (
                            $date ===
                                now()->subDay()->format('Y-m-d'))
                            Yesterday
                        @else
                            {{ \Carbon\Carbon::parse($date)->format('j F, Y') }}
                        @endif
                    </div>

                    <div class="chat-message-container" id="conversation">
                        @foreach ($commentsOnDate as $data)
                            <div class="chat-message-{{ $data['user_id'] === auth()->id() ? 'right' : 'left' }} pb-4">

                                <div class="rounded-circle bg-secondary"
                                    style="height: 40px; width: 40px; vertical-align: middle; background-image: url('{{ $data['user']['avatar'] }}'); background-position: center;  background-repeat: no-repeat; background-size: cover;">
                                </div>
                                <div
                                    class="flex-shrink-1 bg-light shadow rounded p-3 {{ $data['user_id'] === auth()->id() ? 'mr-2' : 'ml-2' }}">
                                    <div class="font-weight-bold mb-1 font-italic">
                                        @if ($data['user_id'] === auth()->id())
                                            You
                                        @else
                                            {{ $data['user']['name'] }}
                                        @endif
                                        <small
                                            class="text-muted small text-nowrap mt-2">{{ \Carbon\Carbon::parse($data['created_at'])->format('H:i A') }}</small>

                                        <em class="text-muted small">
                                            {{ !auth()->user()->isStudent()? ucwords($data['user']['roles'][0]['name']): '' }}
                                        </em>
                                    </div>

                                    {!! $data['comment'] !!}

                                    <div class="border-t">
                                        @if ($data['attachment'])
                                            <a href="{{ getFilePath($data['attachment']['image']) }}" target="_blank"
                                                rel="noopener noreferrer">
                                                <img src="{{ getFilePath($data['attachment']['image']) }}"
                                                    width="250" height="250" alt="Attachment">
                                            </a>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @can('comment', $ticket)
        <div class="flex-grow-0 py-3 px-4 border-top">
            <form wire:submit.prevent="addComment">

                <div class="form-group">
                    <x-editor :hasLabel='false' :isWire='true' :required='true' id="comment_content" fieldName="content"
                        value="{{ $content }}" placeholder="Type your message..." />
                </div>
                @error('content')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <div class="d-flex justify-content-between align-items-center">

                    <div class="">
                        <label for="comment_attachment" class="comment_attachment_container">
                            <input type="file" id="comment_attachment" wire:model="image" class="d-none"
                                accept="image/*">
                            <i class="ti-clip"></i>
                        </label>
                        @error('image')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <button class="btn btn-primary btn-sm" type="submit" wire:loading.attr="disabled">
                        <span> Send</span>
                    </button>
                </div>

                <div>
                    @if ($image)
                        <div class="text-center mx-auto" style="width: 250px">
                            <span>Attachment Preview:</span>
                            <img src="{{ $image->temporaryUrl() }}" height="200">
                            <div>
                                <small class="text-danger cursor-pointer" wire:click="clearImage"><i class="ti-close"></i>
                                    Remove Attachement</small>
                            </div>
                        </div>
                    @endif
                </div>

            </form>
        </div>
    @endcan

    <script>
        document.addEventListener('livewire:load', function() {
            CKEDITOR.instances['comment_content'].on('change', function () {
                var content = CKEDITOR.instances['comment_content'].getData();
                @this.set('content', content);
            });

            Livewire.on('clearCKEditor', function() {
                CKEDITOR.instances['comment_content'].setData('');
            });
        });
    </script>
</div>
