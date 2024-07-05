@extends('layouts.frontend.master')

@section('content')
    <!--====== SEARCH BOX PART START ======-->

    <div class="search-box">
        <div class="serach-form">
            <div class="closebtn">
                <span></span>
                <span></span>
            </div>
            <form action="#">
                <input type="text" placeholder="Search by keyword">
                <button><i class="fa fa-search"></i></button>
            </form>
        </div> <!-- serach form -->
    </div>

    <!--====== SEARCH BOX PART ENDS ======-->

    <!--====== PAGE BANNER PART START ======-->

    <section id="page-banner" class="pt-105 pb-110 bg_cover" data-overlay="8"
        style="background-image: url(images/page-banner-3.jpg)">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-banner-cont">
                        <h2>@lang('Instructors')</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('Home')</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Instructors</li>
                            </ol>
                        </nav>
                    </div> <!-- page banner cont -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== PAGE BANNER PART ENDS ======-->

    <!--====== INSTRUCTORS PART START ======-->

    <section id="instructors-page" class="pt-90 pb-120 gray-bg">
        <div class="container">
            <div class="row">
                @foreach ($instructors as $instructor)
                    <div class="col-lg-3 col-sm-6">
                        <div class="single-instructors mt-30 text-center">
                            <div class="image">
                                <img src="{{ $instructor->image() }}" alt="{{ $instructor->name }}">
                            </div>
                            <div class="cont">
                                <a href="#">
                                    <h6>{{ $instructor->name }}</h6>
                                </a>
                                <span>{{ $instructor->designation }}</span>
                            </div>
                        </div> <!-- single instructor -->
                    </div>
                @endforeach


            </div> <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <nav class="courses-pagination mt-50">
                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                                <a href="#" aria-label="Previous">
                                    <i class="fa fa-angle-left"></i>
                                </a>
                            </li>
                            <li class="page-item"><a class="active" href="#">1</a></li>
                            <li class="page-item"><a href="#">2</a></li>
                            <li class="page-item"><a href="#">3</a></li>
                            <li class="page-item">
                                <a href="#" aria-label="Next">
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav> <!-- courses pagination -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== INSTRUCTORS PART ENDS ======-->
@endsection
