@extends('layouts.backend.master')

@section('breadcrumbs')
<x-bread-crumb pageTitle='Create Question' previous="" previousLink="" current="Create Questions" />
@endsection
@section('content')
    @include('jambasangsang.backend.questions.fields')
@endsection
