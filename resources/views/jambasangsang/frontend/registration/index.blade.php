@extends('layouts.frontend.master')

@section('content')
<div class="container my-5">
    <livewire:registration.registration-stepper
        wire:key="registration_stepper"
    />
</div>
@endsection
