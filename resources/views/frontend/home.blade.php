@extends('frontend.layouts.app')
@section('title', 'Home')
@section('content')
    {!! resolvePageShortCodes($page->lb_content, $__data) !!}
@endsection
@push('scripts')
    {!! NoCaptcha::renderJs() !!}
@endpush
