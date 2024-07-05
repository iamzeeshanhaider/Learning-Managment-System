<div>
    @if(isset($option))
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h1 class="mb-4">Your request has been submitted!</h1>
                    <p class="lead">We'll review your request and assign a relevant instructor soon. You'll receive an email notification once your request has been processed.</p>
                    <a href="/" class="btn btn-primary mt-3">Back to Home</a>
                </div>
            </div>
        </div>
    @else
        <form wire:submit.prevent="submitForm">
            <div class="row">
                <div class="col-md-2 mt-5">
                    <ul class="list-unstyled stepper">
                        @foreach ($steps as $index => $step)
                            <li class="{{ $index + 1 === $currentStep ? 'active' : '' }}">
                                <a href="#">{{ $step->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-body">
                            @foreach ($steps as $step)
                                @if ($step->id === $currentStep)
                                    <!-- Render form fields dynamically based on the current step -->
                                    <h1>{{ $step->name }}</h1>
                                    <input name="layer_id" type="hidden" wire:model="formData.{{ $step->id }}" />
                                    @foreach ($step->questions as $field)
                                        <div class="form-group">
                                            <label for="{{ $field->id }}">{{ $field->question }}</label>
                                            <select required name="{{ $field->id }}" id="{{ $field->id }}" class="form-control" wire:model="formData.{{ $field->id }}">
                                                <option value="">@lang('Select an Option')</option>
                                                @foreach ($field->options as $option)
                                                    <option value="{{ $option->id }}">{{ $option->option }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error("formData.{$field->id}") <span class="text-danger">{{ $message }}</span> @enderror
                                    @endforeach

                                    @if(count($steps) === $currentStep)
                                        <div class="form-group">
                                            <label for="issueTextArea">@lang("Seeking Clarity: Can You Help Me Understand the Issue?")</label>
                                            <textarea class="form-control" id="issueTextarea" wire:model="issue"></textarea>
                                        </div>
                                    @endif
                                    <button type="submit" class="btn btn-primary">@if(count($steps) > $currentStep) Next @else Finish @endif</button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif
</div>


<style>
    .stepper {
        list-style: none;
        padding: 0;
    }

    .stepper li {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .stepper li.active a {
        font-weight: bold;
        color: #007bff;
    }

    .stepper li a {
        flex: 1;
        text-decoration: none;
        color: #6c757d;
    }

    .stepper li::before {
        content: '';
        flex: 0 0 20px;
        height: 20px;
        width: 20px;
        background-color: #6c757d;
        border-radius: 50%;
        margin-right: 10px;
    }

    .stepper li.active::before {
        background-color: #007bff;
    }

    .card {
        margin-top: 20px;
    }

</style>
