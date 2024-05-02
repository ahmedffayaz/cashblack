@extends('frontend.layouts.app')

@section('title', isset($page) ? $page->title : request()->input('slug'))

@section('content')
    <section>
        <div class="container">
            <div>
                @include('frontend.components.breadcrumbs', [
                    'crumbs' => [
                        [
                            'url' => route('blogs.index'),
                            'title' => 'Blogs',
                        ],
                    ],
                    'current' => $blog->title,
                ])
            </div>
        </div>
    </section>
    <section>
        <div class="container mb-5">
            <div class="blog-detail-page">
                <div class="row">
                    <div class="col-sm-12 col-md-8 blog-content">

                        <div class="mb-4">
                            <img src="{{ $blog->featured_image && isFileExist($blog->featured_image) ? asset($blog->featured_image) : asset('frontend/images/posts/post-featured.jpg') }}" alt="" class="img-fluid">
                        </div>
                        <h1 class="blog-post-title">{{ $blog->title }}</h1>
                        <div class="meta-info">
                            <label class="meta-date"><i class="fas fa-calendar-alt me-2"></i> {{ Carbon\Carbon::parse($blog->publish_date)->isoFormat('Do MMMM YYYY') }} </label>
                        </div>

                        <div class="detail-desc">
                            {!! $blog->lb_content !!}
                        </div>

                        @include('frontend.components.share-this-blog')

                    </div>

                    @include('frontend.blogs.related-blog')

                </div>
            </div>
        </div>
    </section>
@endsection
