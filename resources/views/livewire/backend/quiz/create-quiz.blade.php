<div>
    <form wire:submit.prevent="goToNextStep" class="card p-5 border-0">
        @switch($currentStep)
            @case(1)
                <div class="card-header bg-light mb-3"><b>Create Quiz</b></div>
                <div class="row py-3">

                    <div class="col-md-6">
                        <div class="form-group">
                            <x-select.batch :selected="$batch_id" :isWire='true' />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <x-select.course :selected="$course_id" :isWire='true' />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mb-1" for="title">@lang('Quiz Title'):</label>
                            <input class="form-control" id="title" type="text" wire:model.lazy="title"
                                placeholder="First Assessment" required>
                            @error('title')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Attempts --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mb-1" for="attempts">@lang('Attempts'):</label>
                            <input class="form-control" id="attempts" type="number" min="1" max="5"
                                wire:model="attempts" required>
                            @if ($attempts > 1)
                                <div class="d-flex justify-content-between small mt-2">
                                    <span>Final Score:</span>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" wire:model="is_average"
                                            id="finalIsAverage" value="1" {{ $is_average === 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="finalIsAverage">
                                            Use Average
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" wire:model="is_average"
                                            id="finalIsLatest" value="0" {{ $is_average === 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="finalIsLatest">
                                            Use Latest Attempt
                                        </label>
                                    </div>
                                </div>
                            @endif
                            @error('attempts')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- Duration --}}

                    {{-- Obtainable Score --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mb-1" for="obtainable_points">@lang('Obtainable Score'):</label>
                            <input class="form-control" id="obtainable_points" type="number" min="0"
                                wire:model.lazy="obtainable_points" required>
                            @error('obtainable_points')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- Duration --}}

                    {{-- Duration --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mb-1" for="duration">
                                @lang('Time Allowed'): <small>(e.g 120 for 2 minutes; 60 for 1 minute)</small>
                            </label>
                            <input class="form-control" id="duration" type="number" min="60" wire:model.lazy="duration"
                                required>
                            @error('duration')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- Duration --}}

                    {{-- Start Date --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mb-1" for="start_time">@lang('Start Date/Time'):</label>
                            <input class="form-control" id="start_time" type="datetime-local" wire:model.lazy="start_time"
                                min="{{ $start_time ?? date('Y-m-d H:i') }}" required>
                            @error('start_time')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- Start Date --}}

                    {{-- End Date --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mb-1" for="end_time">@lang('End Date/Time'):</label>
                            <input class="form-control" id="end_time" type="datetime-local" wire:model.lazy="end_time"
                                min="{{ $start_time ? $start_time : date('Y-m-d H:i') }}">
                            @error('end_time')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- End Date --}}

                    {{-- Pubish now --}}
                    <div class="col-md-12 text-right">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model.lazy='status'
                                {{ $status == \App\Enums\GeneralStatus::Enabled ? 'checked' : '' }} id="publishCheck">
                            <label class="form-check-label" for="publishCheck">
                                Publish Now
                            </label>
                            @error('status')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- Pubish now --}}

                </div>
            @break

            @case(2)
                <div class="card-header bg-light mb-3"><b>Create Questions</b></div>
                <div class="row p-2">
                    @foreach ($questions as $index => $question)
                        <div class="card shadow p-3 border-0">
                            <fieldset>
                                <legend>
                                    <div class="d-flex justify-content-between">
                                        <span>Question - {{ $index + 1 }}</span>
                                        <div>
                                            @if ($index > 0)
                                                <small>
                                                    <button type="button"
                                                        wire:click.prevent="removeQuestion({{ $index }})"
                                                        class="btn btn-danger btn-sm">
                                                        Remove Question
                                                    </button>
                                                </small>
                                            @endif
                                            <button type="button" wire:click="setActiveQuestionIndex({{ $index }})"
                                                class="btn btn-primary btn-sm">
                                                <small
                                                    class="{{ in_array($index, $activeQuestionIndex) ? 'ti-arrow-circle-down' : 'ti-arrow-circle-up' }}"></small>
                                            </button>
                                        </div>
                                    </div>
                                </legend>
                                <div class="row collapse fade {{ in_array($index, $activeQuestionIndex) ? 'show' : '' }}">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="mb-1"
                                                for="question-{{ $index }}">@lang('Question'):</label>
                                            <input class="form-control" id="question-{{ $index }}" type="text"
                                                wire:model.lazy="questions.{{ $index }}.question" required>
                                            @error('questions.' . $index . '.question')
                                                <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="mb-1"
                                                for="instruction-{{ $index }}">@lang('Instruction'):</label>
                                            <textarea wire:model.laxy="questions.{{ $index }}.instruction" rows="3"
                                                id="instruction-{{ $index }}" class="form-control"></textarea>

                                            @error('questions.' . $index . '.instruction')
                                                <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @foreach ($question['options'] as $optionIndex => $option)
                                            <div class="mb-3">
                                                <div class="form-group mb-0 pb-0">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <label for="option-value-{{ $index }}-{{ $optionIndex }}">
                                                            @lang('Option') - {{ $optionIndex + 1 }}:
                                                        </label>
                                                        @if ($optionIndex > 1)
                                                            <button
                                                                wire:click.prevent="removeOption({{ $index }}, {{ $optionIndex }})"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="ti-minus"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                    <input id="option-value-{{ $index }}-{{ $optionIndex }}"
                                                        class="form-control" type="text"
                                                        wire:model.lazy="questions.{{ $index }}.options.{{ $optionIndex }}.option"
                                                        required>
                                                    @error('questions.' . $index . '.options.' . $optionIndex . '.options')
                                                        <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-check form-switch mt-1 pt-0">
                                                    <input class="form-check-input" type="radio"
                                                        id="option-is_correct-{{ $index }}-{{ $optionIndex }}"
                                                        wire:model.lazy="questions.{{ $index }}.correctOption"
                                                        value="{{ $optionIndex }}">
                                                    <label class="form-check-label"
                                                        for="option-is_correct-{{ $index }}-{{ $optionIndex }}">Is
                                                        Correct Answer</label>
                                                    @error('questions.' . $index . '.options.' . $optionIndex . '.is_correct')
                                                        <span class="text-danger small">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endforeach
                                        @if (count($question['options']) < 4)
                                            <div class="text-right mt-3">
                                                <button wire:click.prevent="addOption({{ $index }})"
                                                    class="btn btn-sm btn-primary">
                                                    Add Option <i class="ti-plus"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    @endforeach
                </div>

                @if (count($questions) < 20)
                    <div class="row p-2">
                        <div class="text-right">
                            <div class="d-flex justify-content-end">
                                <button type="button" wire:click.prevent="toggleAllQuestions"
                                    class="btn btn-sm btn-warning m-1">Toggle All</button>
                                <button type="button" wire:click.prevent="addQuestion"
                                    class="btn btn-sm btn-primary m-1">Add Question</button>
                            </div>
                        </div>
                    </div>
                @endif
            @break

        @endswitch

        {{-- Buttons --}}
        <div class="btn-group p-2 mt-3" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-primary text-white" wire:click="goToPreviousStep"
                {{ !$previousStep || $disable_button ? 'disabled' : '' }}>Previous</button>
            <button type="submit" class="btn btn-primary">{{ $currentStep === 2 ? 'Finish' : 'Next' }}</button>
        </div>
        {{-- Buttons --}}
    </form>

</div>
