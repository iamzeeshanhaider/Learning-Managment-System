@extends('layouts.backend.master')

@section('content')

@section('breadcrumbs')
    <!-- Breadcrumbs code here -->
@endsection

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="text-success"><i class="fas fa-check-circle"></i></h1>
                    <h2 class="card-title">Success!</h2>
                    <p class="card-text">Your live chat has been successfully submitted.</p>
                    <p class="card-text">Thank you for your submission. Your request has been received and will be processed shortly.</p>
                    <hr>
                    <!-- Display submitted data or relevant information here -->
                    <!-- Add other links or buttons for further action here -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
