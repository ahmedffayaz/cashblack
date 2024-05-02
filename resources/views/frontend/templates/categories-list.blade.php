@if (isset($categories) && !empty($categories))
    <section class="static">
        <div class="container">
            <div class="row all-categories-listing">
                @foreach ($categories as $category)
                    @if ($category->status === 1)
                        <div class="col-12 col-sm-4">
                            <div class="panel rounded-border">
                                <a href="{{ route('categories.show', $category->slug) }}">
                                    <h5 class="cat-title">{{ $category->name }}</h5>
                                </a>
                                @if (count($category->childs))
                                    <ul class="category-items">
                                        @foreach ($category->childs as $item)
                                            @if ($item->status === 1)
                                                <li>
                                                    <a href="{{ route('categories.show', $item->slug) }}">{{ $item->name }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endif
