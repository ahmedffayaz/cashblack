@extends('frontend.layouts.app')

@section('title', 'Offers')

@section('content')
    <section>
        <div class="container">
            @include('frontend.components.breadcrumbs', [
                'crumbs' => [],
                'current' => 'Offers',
            ])
        </div>
    </section>

    <section class="static">
        <div class="container">
        </div>
    </section>
@endsection
