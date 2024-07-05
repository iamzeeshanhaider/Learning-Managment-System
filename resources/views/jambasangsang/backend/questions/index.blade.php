@extends('layouts.backend.master')
@section('content')

@section('breadcrumbs')
<x-bread-crumb pageTitle='Question List' previous="" previousLink="" current="Questions" />

@endsection

@include('jambasangsang.backend.questions.table')

@endsection
