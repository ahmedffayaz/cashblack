<section class="static">
    <div class="container">
        <div class="blog-page">
            <div class="row">
                @foreach ($blogs as $blog)
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <div class="blog-box-content">
                            <div class="blog-img">
                                <a href="{{ url('/blogs/' . $blog->slug) }}">
                                    <img @if ($blog->featured_image && isFileExist($blog->featured_image)) src="{{ asset($blog->featured_image)}}"  @else src="{{ asset('frontend/images/posts/post-featured.jpg') }}" @endif
                                        alt="" class="img-adjust">
                                </a>
                            </div>
                            <h5 class="blog-title"><a href="{{ url('/blogs/' . $blog->slug) }}">{{ $blog->title }}</a></h5>
                            <label class="meta-date mb-3"><i class="fas fa-calendar-alt me-2 "></i> {{ Carbon\Carbon::parse($blog->publish_date)->isoFormat('Do MMMM YYYY') }}
                            </label>
                            {!! removeAllTags($blog->lb_content, 200) !!}
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</section>
<section class="static">
    <div class="container">
        <div class="page-bottom-actions position-relative mt-3 mb-5">
            {!! $blogs->links() !!}
        </div>
    </div>
</section>
