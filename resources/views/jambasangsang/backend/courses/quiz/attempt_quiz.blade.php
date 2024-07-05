@extends('layouts.backend.quiz_layout')
@section('content')
    <div class="m-auto d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="mx-auto col-md-10 col-lg-10">
            <div class="border-0 shadow card">
                <livewire:backend.quiz.attempt-quiz :quiz="$quiz" :batchUser="$batch_user">
            </div>
        </div>
    </div>
@endsection
