@extends('frontend.layouts.app')

@section('title', isset($page) ? $page->title : request()->input('slug'))

@section('content')
    <section>
        <div class="container">
            <div>
                @include('frontend.components.breadcrumbs', [
                    'crumbs' => [],
                    'current' => isset($page) ? $page->title : request()->input('slug'),
                ])
            </div>
        </div>
    </section>

    {!! resolvePageShortCodes($page->lb_content, $__data) !!}
@endsection
