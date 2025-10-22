@extends('layouts.guest')

@section('title','Inicio')

@section('content')
    @include('components.home.searcher')
    @include('components.home.jobly')
    @include('components.home.projects')
    @include('components.home.testimonials')
    @include('components.home.invitation')
    @include('components.home.footer')
@endsection
