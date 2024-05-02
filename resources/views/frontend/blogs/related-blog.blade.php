@php $relatedBlogs = getRelatedBlogs($blog->meta_keyword, $blog->id); @endphp
@if (count($relatedBlogs))
    <div class="col-sm-12 col-md-4 mt-5 mt-md-0">
        <h5 class="mb-4">Related Posts</h5>
        @foreach ($relatedBlogs as $relatedBlog)
            <div class="blog-box-content mb-3">
                <div class="blog-img"><a href="{{ url('/blogs/' . $relatedBlog->slug) }}">
                        <img @if ($relatedBlog->featured_image && isFileExist($relatedBlog->featured_image)) src="{{asset( $relatedBlog->featured_image) }}"  @else src="{{ asset('frontend/images/posts/post-featured.jpg') }}" @endif
                            alt="" class="img-fluid-size">
                    </a></div>
                <h5 class="blog-title"><a href="{{ url('/blogs/' . $relatedBlog->slug) }}">{{ $relatedBlog->title }}</a></h5>
                <label class="meta-date mb-3"><i class="fas fa-calendar-alt me-2"></i> {{ Carbon\Carbon::parse($relatedBlog->publish_date)->isoFormat('Do MMMM YYYY') }}
                </label>
                {!! removeAllTags($relatedBlog->lb_content, 200) !!}
            </div>
        @endforeach
    </div>
@endif
