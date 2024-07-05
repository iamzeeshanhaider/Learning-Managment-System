<div>
    <div class="p-5">
        <div class="border-0 shadow card">
            <div class="p-3 bg-white border-bottom">
                <div class="flex-row d-flex justify-content-between align-items-center mcq">
                    <h4>{{ $quiz->title }}</h4>
                    <div id="timerContainer" class="{{ $countdown <= 300 ? 'counting_down' : 'text-success' }}"
                        data-countdown="{{ $countdown }}">
                        Time Remaining: <span wire:initial-data="timeRemaining">{{ $timeRemaining }}</span>
                    </div>
                    <div class="dropleft">
                        <button class="btn btn-clear dropdown-toggle" type="button" id="questionSelectDropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ $currentQuestionIndex + 1 }} of {{ count($quiz->questions) }}
                        </button>
                        <div class="bg-white border-0 shadow dropdown-menu" aria-labelledby="questionSelectDropdown">
                            @foreach ($quiz->questions as $questionIndex => $question)
                                <a class="dropdown-item" wire:click="goToQuestion({{ $questionIndex }})">Question
                                    {{ $questionIndex + 1 }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-3 bg-white border-bottom">
                <div class="d-flex align-items-center">
                    <h3 class="text-danger">Q.</h3>
                    <div class="mt-1 ml-2">
                        <h5>{{ $currentQuestion['question'] }}</h5>
                        @if ($currentQuestion['instruction'])
                            <p><small>Instruction: {{ $currentQuestion['instruction'] }}</small></p>
                        @endif
                    </div>
                </div>
                <div class="m-3">
                    @foreach ($currentQuestion['options'] as $optionIndex => $option)
                        <ol>
                            <label>
                                <input type="radio" wire:model="answers.{{ $currentQuestionIndex }}"
                                    value="{{ json_encode($option) }}"
                                    id="{{ $currentQuestion['id'] }}-{{ $option['id'] }}">
                                <span>{{ $option['option'] }}</span>
                            </label>
                        </ol>
                    @endforeach
                </div>
            </div>
            <div class="flex-row p-3 bg-white d-flex justify-content-between align-items-center">
                <div class="btn-group" role="group" aria-label="Basic example">
                    @if ($currentQuestionIndex > 0)
                        <button class="btn btn-primary d-flex align-items-center" type="button"
                            wire:click="previousQuestion">
                            <i class="mr-1 fa fa-angle-left"></i>&nbsp;Previous
                        </button>
                    @endif
                    @if ($currentQuestionIndex < count($quiz->questions) - 1)
                        <button class="btn btn-primary d-flex align-items-center" type="button"
                            wire:click="nextQuestion">
                            Next<i class="ml-2 fa fa-angle-right"></i>
                        </button>
                    @endif
                </div>

                @if ($currentQuestionIndex == count($quiz->questions) - 1)
                    <button wire:click="toggleConfirmation"
                        class="btn {{ $submission_confirmation ? 'btn-warning text-white' : 'btn-success' }} d-flex align-items-center"
                        type="button"><i class="fa fa-{{ $submission_confirmation ? 'warning' : 'check' }} mr-2"></i>
                        {{ $submission_confirmation ? 'Review Answers' : 'Submit' }}</button>
                @endif
            </div>
            <div class="{{ $submission_confirmation ? 'd-block' : 'd-none' }}">
                <div class="p-5 text-center bg-white border-top">
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam sint atque quaerat odio
                        voluptatum cupiditate, eaque porro similique voluptas natus, quia voluptates, ut tenetur vitae
                        tempore pariatur omnis! Eaque, dolorem?
                    </p>
                    <div class="d-flex justify-content-center">
                        <button wire:click="submitQuiz" class="m-1 btn btn-success d-flex align-items-center"
                            type="button"><i class="mr-2 fa fa-check"></i> Yes, Proceed</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .counting_down {
            color: rgb(255, 0, 0);
            animation: animate 1.5s linear infinite;
        }

        @keyframes animate {
            0% {
                opacity: 0;
            }

            50% {
                opacity: 0.8;
            }

            100% {
                opacity: 0;
            }
        }
    </style>

    @push('scripts')
        <script>
            function startCountdown() {

                var countdownTime = $('#timerContainer').data('countdown');

                var timerInterval = setInterval(function() {

                    @this.updateCountdownProperty();

                    if (countdownTime <= 0) {
                        clearInterval(timerInterval);
                        @this.submitQuiz();
                    }
                }, 1000);
            }

            document.addEventListener('livewire:load', function() {
                startCountdown();

                window.onbeforeunload = function(e) {
                    e.preventDefault();

                    if (!@this.submitted) {
                        e.returnValue =
                        'Are you sure?'; // Modern browsers require a non-empty string as the return value

                        console.log(@this.submitted, 'submitted');
                        @this.submitQuiz();
                    }

                };

            });
        </script>
    @endpush
</div>
