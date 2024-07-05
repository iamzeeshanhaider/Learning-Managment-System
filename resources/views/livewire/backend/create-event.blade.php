    <div wire:submit.prevent="persistEvent" class="card border-0">
        <div class="row">
            <div class="col-md-6">

                <div class="form-group">
                    <label class="mb-1" for="title">@lang('Title'):</label>
                    <input class="form-control" id="title" type="text" wire:model.lazy="title"
                        placeholder="Lorem Ipsum Event" maxlength="150">
                    @error('title')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="mb-1" for="content">@lang('Event Details'):</label>
                    <textarea wire:model.lazy="content" class="form-control" rows="10" id="content" class="">{{ $content }}</textarea>
                    @error('content')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="mb-1" for="status">@lang('Status'):</label>
                    <select wire:model.lazy="status" id="status" class="form-control">
                        <option value="{{ \App\Enums\GeneralStatus::Enabled() }}"
                            {{ $status === \App\Enums\GeneralStatus::Enabled() ? 'selected' : '' }}>
                            {{ __('Publish Now') }}</option>
                        <option value="{{ \App\Enums\GeneralStatus::Disabled() }}"
                            {{ $status === \App\Enums\GeneralStatus::Disabled() ? 'selected' : '' }}>
                            {{ __('Draft') }}</option>
                    </select>
                    @error('status')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group">
                    <label class="mb-1" for="date">@lang('Date'):</label>
                    <input class="form-control" id="date" type="datetime-local" wire:model.lazy="date">
                    @error('date')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    {{-- TODO: update group and display batch when group is updated --}}
                    <label class="mb-1" for="group">@lang('Group'):</label>
                    <select wire:model="group" id="group" class="form-control" wire:change="setBatch"
                        wire:ignore.self>
                        @foreach (\App\Enums\EventGroup::getInstances() as $event_group)
                            <option value="{{ $event_group }}" {{ $event_group === $group ? 'selected' : '' }}>
                                {{ $event_group }}</option>
                        @endforeach
                    </select>
                    <div class="text-right small">
                        <div class="form-check mb-0">
                            <input class="form-check-input" type="checkbox" wire:model='notify_group'
                                {{ $notify_group ? 'checked' : '' }} id="notifyGroupCheck">
                            <label class="form-check-label" for="notifyGroupCheck">
                                Notify Group Immediately
                            </label>
                            @error('notify_group')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @error('group')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group fade show">
                    <x-select.batch :selected="$batch_id" :isWire='true'
                        readonly="{{ $group == \App\Enums\EventGroup::ByBatch() ? 0 : 1 }}"
                        required="{{ $group == \App\Enums\EventGroup::ByBatch() ? 1 : 0 }}"
                        multiple={{ 1 }} />
                </div>

                <div class="row">
                    <div class="form-group {{ $event && $event->banner ? 'col-md-8' : 'col-md-12' }}">
                        <label for="banner" class="control-label mb-1">@lang('Banner')</label>
                        <div class="form-group">
                            <input type="file" wire:model="banner" id="banner" accept="image/*"
                                class="form-control">
                        </div>
                        @error('banner')
                            <div class="help-block field-validation-valid alert alert-danger">
                                {{ $message }}</div>
                        @enderror
                    </div>
                    @if ($event && $event->banner)
                        <div class="col-md-4">
                            <div
                                style="background-image: url('{{ $event->image() }}'); background-repeat:no-repeat; background-position: center; background-size: cover; width: 100%; height: 80px;">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="btn-group p-2 mt-3" role="group" aria-label="Basic example">
            <button type="submit" wire:click.prevent="persistEvent" class="btn btn-primary"
                wire:loading.attr="disabled">
                Save
                <div wire:loading class="spinner-grow spinner-grow-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </button>
        </div>
        {{-- Buttons --}}
    </div>
