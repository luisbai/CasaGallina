@extends('layouts.english.boilerplate')

@section('content')
    <div id="search-page">
        <!-- Banner -->
        <section id="search-banner">
            <img loading="lazy" src="/assets/images/casa/banner.jpg" class="img-fluid" alt="Search Casa Gallina">
        </section>

        <!-- Search Intro Section -->
        <section id="search-intro">
            <div class="container">
                <div class="section-title text-center">
                    <span>Search</span>
                </div>

                <div class="intro-text">
                    Find news, programs, and publications from our community
                </div>
            </div>
        </section>

        <!-- Search Results Component -->
        <livewire:public.search-page :query="$query" language="en" />

    </div>
@endsection