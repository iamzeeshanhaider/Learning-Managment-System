@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
    <x-bread-crumb pageTitle="Meet Sessions" previous="" previousLink="" current="Sessions" />
@endsection
<livewire:backend.google.event student="null" batch="null" />
@endsection
