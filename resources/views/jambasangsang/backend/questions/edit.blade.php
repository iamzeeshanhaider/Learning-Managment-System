@extends('layouts.backend.master')

@section('breadcrumbs')
<x-bread-crumb pageTitle='Edit Question' previous="" previousLink="" current="Edit Questions" />

@endsection
@section('content')
    @include('jambasangsang.backend.questions.fields')
@endsection
