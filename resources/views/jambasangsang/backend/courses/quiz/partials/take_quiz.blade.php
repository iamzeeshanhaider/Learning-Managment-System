<div>
    <section class="quiz_card">
        <article class="postcard light blue">
            <a class="postcard__img_link" href="#">
                <img class="postcard__img" src="{{ asset('jambasangsang/backend/images/quiz.png') }}" alt="Image Title" />
            </a>
            <div class="postcard__text t-dark">
                <h1 class="postcard__title blue">
                    <p><b>{{ __('Question:') }}</b></p>
                    {!! $quiz->question !!}
                </h1>
                <div class="postcard__subtitle small">
                    @if ($quiz->end_time)
                        <b>Deadline:</b>
                        <time datetime="{{ $quiz->end_time }}">
                            <i
                                class="ml-2 fas fa-calendar-alt"></i>{{ $quiz->end_time->format('D, jS F Y \| h:i:s A') }}
                        </time>
                    @endif
                </div>
                <div class="postcard__bar"></div>
                @if ($quiz->instruction)
                    <div class="postcard__preview-txt">
                        <p><b>{{ __('Instructions') }}</b></p>
                        {!! $quiz->instruction !!}
                    </div>
                @endif

            </div>
        </article>
    </section>

    {{-- Submission --}}

    @if ($submission)
        <div class="p-5 my-3 border-0 card bg-light">
            <p><b>{{ __('Submitted:') }}</b> {{ $submission->created_at->diffForHumans() }}</p>
            <p><b>{{ __('Obtainable Score:') }}</b> {{ $submission->quiz->obtainable_score }}</p>
            <p><b>{{ __('Obtained Score:') }}</b> {{ $submission->grade ?? 'Not Graded' }}</p>
            <p><b>{{ __('Feedback:') }}</b> {{ $submission->feedback ?? '' }}</p>

        </div>
    @else
        <div class="row">
            <div class="p-2 mx-auto col-md-8 ">
                <form action="{{ route('submission.store', ['quiz' => $quiz->slug]) }}" method="POST"
                    enctype="multipart/form-data" onsubmit="$('#take_quiz-button').attr('disabled', true)">
                    @csrf

                    <input type="hidden" name="batch_user_id" value="{{ $batch_user->id }}">

                    @switch($quiz->type)
                        @case(\App\Enums\QuizTypes::Text)
                            <div class="form-group">
                                <label for="take_quiz_submission">Submission</label>
                                <textarea class="form-control" id="take_quiz_submission" name="value" rows="5"></textarea>
                            </div>
                        @break

                        @case(\App\Enums\QuizTypes::FileUpload)
                            <fieldset class="p-4 text-center upload_dropZone" ondrop="handleDrop(event)"
                                ondragover="handleDragOver(event)">
                                <i class="ti-image" style="width: 60px; height: 60px;"></i>
                                <p class="my-2 small">Drag &amp; Drop background image(s) inside dashed region<br><i>or</i></p>

                                <input id="fileInput" class="invisible position-absolute" type="file"
                                    accept=".mp4, .mov, .doc, .docx, .pdf, .ppt, .pptx, .jpg, .jpeg, .png" name="file"
                                    onchange="displayFileName()" />

                                <label class="mb-3 btn btn-primary" for="fileInput">Choose file(s)</label>

                                <div>
                                    <ul id="filePreview" class="my-3">
                                        <li><span id="fileName"></span> <i class="cursor-pointer fa fa-times text-danger"
                                                onclick="removeFile()"></i></li>
                                    </ul>
                                </div>
                            </fieldset>
                        @break
                    @endswitch

                    <button class="mt-3 btn btn-lg btn-primary btn-block" id="take_quiz-button">Submit</button>
                </form>
            </div>
        </div>
    @endif

</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"
    integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script>
    function handleDrop(event) {
        event.preventDefault();
        const files = event.dataTransfer.files;
        handleFiles(files[0]);
    }

    function handleDragOver(event) {
        event.preventDefault();
    }

    let filePreview = $('#filePreview');
    filePreview.hide();

    function displayFileName() {
        const fileInput = document.getElementById('fileInput');
        handleFiles(fileInput.files[0]);
    }

    function handleFiles(file) {
        const fileName = file.name;
        filePreview.show(200); // show the preview
        document.getElementById('fileName').textContent = fileName;
    }

    function removeFile() {
        document.getElementById('fileInput').value = null;
        document.getElementById('fileName').textContent = '';
        filePreview.hide(200); // hide the preview
    }
</script>


<style>
    .quiz_card .light {
        background: #f3f5f7;
    }

    .quiz_card .title {
        margin: 2rem 0;
        text-transform: uppercase;
        text-align: center;
        font-size: 2.5rem;
    }

    /* Cards */
    .postcard {
        flex-wrap: wrap;
        display: flex;
        box-shadow: 0 4px 21px -12px rgba(0, 0, 0, 0.66);
        border-radius: 10px;
        margin: 0 0 2rem 0;
        overflow: hidden;
        position: relative;
        color: #fff;
    }

    .postcard.light {
        background-color: #e1e5ea;
    }

    .postcard .t-dark {
        color: #18151f;
    }

    .postcard a {
        color: inherit;
    }

    .postcard h1,
    .postcard .h1 {
        margin-bottom: 0.5rem;
        font-weight: 500;
        line-height: 1.2;
    }

    .postcard .small {
        font-size: 80%;
    }

    .postcard .postcard__title {
        font-size: 1.75rem;
    }

    .postcard .postcard__img {
        max-height: 180px;
        width: 100%;
        object-fit: cover;
        position: relative;
    }

    .postcard .postcard__img_link {
        display: contents;
    }

    .postcard .postcard__bar {
        width: 50px;
        height: 10px;
        margin: 10px 0;
        border-radius: 5px;
        background-color: #424242;
        transition: width 0.2s ease;
    }

    .postcard .postcard__text {
        padding: 1.5rem;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .postcard .postcard__preview-txt {
        overflow: hidden;
        text-overflow: ellipsis;
        text-align: justify;
        height: 100%;
    }

    .postcard:before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-image: linear-gradient(-70deg, #424242, transparent 50%);
        opacity: 1;
        border-radius: 10px;
    }

    .postcard:hover .postcard__bar {
        width: 100px;
    }

    @media screen and (min-width: 769px) {
        .postcard {
            flex-wrap: inherit;
        }

        .postcard .postcard__title {
            font-size: 2rem;
        }

        .postcard .postcard__img {
            max-width: 300px;
            max-height: 100%;
            transition: transform 0.3s ease;
        }

        .postcard .postcard__text {
            padding: 3rem;
            width: 100%;
        }

        /* .postcard .media.postcard__text:before {
            content: "";
            position: absolute;
            display: block;
            background: #18151f;
            top: -20%;
            height: 130%;
            width: 55px;
        } */

        .postcard:hover .postcard__img {
            transform: scale(1.1);
        }

        .postcard:nth-child(2n + 1) {
            flex-direction: row;
        }

        .postcard:nth-child(2n + 0) {
            flex-direction: row-reverse;
        }

        .postcard:nth-child(2n + 1) .postcard__text::before {
            left: -12px !important;
            transform: rotate(4deg);
        }

        .postcard:nth-child(2n + 0) .postcard__text::before {
            right: -12px !important;
            transform: rotate(-4deg);
        }
    }

    @media screen and (min-width: 1024px) {
        .postcard__text {
            padding: 2rem 3.5rem;
        }

        /* .postcard__text:before {
            content: "";
            position: absolute;
            display: block;
            top: -20%;
            height: 130%;
            width: 15px;
        }

        .postcard.dark .postcard__text:before {
            background: #18151f;
        }

        .postcard.light .postcard__text:before {
            background: #e1e5ea;
        } */
    }


    .blue .postcard__bar {
        background-color: #0076bd;
    }

    .blue::before {
        background-image: linear-gradient(-30deg, rgba(0, 118, 189, 0.1), transparent 50%);
    }

    .blue:nth-child(2n)::before {
        background-image: linear-gradient(30deg, rgba(0, 118, 189, 0.1), transparent 50%);
    }

    @media screen and (min-width: 769px) {

        .blue::before {
            background-image: linear-gradient(-80deg, rgba(0, 118, 189, 0.1), transparent 50%);
        }

        .blue:nth-child(2n)::before {
            background-image: linear-gradient(80deg, rgba(0, 118, 189, 0.1), transparent 50%);
        }
    }


    .upload_dropZone {
        color: #0f3c4b;
        outline: 2px dashed rgba(7, 41, 77, 0.4);
        outline-offset: -12px;
        transition:
            outline-offset 0.2s ease-out,
            outline-color 0.3s ease-in-out,
            background-color 0.2s ease-out;
    }

    .upload_dropZone:hover {
        outline-offset: -4px;
        outline-color: rgba(7, 41, 77, 0.8);
        background-color: #c8dadf;
    }

    .upload_img {
        width: calc(33.333% - (2rem / 3));
        object-fit: contain;
    }
</style>
