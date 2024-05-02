@php $slider = getHomeSliders(); @endphp
@if (count($slider->slides) && !empty(auth()->user()))
    <section id="hero" class="mb-3">
        <div class="container">
            <div id="Slider" class="carousel slide custom-height" data-bs-ride="carousel">

                <div class="carousel-inner">
                    @if (count($slider->slides) > 1)
                        <div class="carousel-indicators">
                            @foreach($slider->slides as $j => $slide)
                                @if($loop->index == 0)
                                    <button type="button" data-bs-target="#Slider" data-bs-slide-to="0" class="" aria-label="Slide 1"></button>
                                @else
                                    <button type="button" data-bs-target="#Slider" data-bs-slide-to="{{ $loop->index }}" class="active" aria-current="true" aria-label="Slide {{ $loop->index}}"></button>
                                @endif
                            @endforeach
                        </div>
                    @endif
                    @foreach ($slider->slides as $i => $slide)
                        <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                            <a
                                href="{{ !empty($slide->link) && !isset($slide->store) ? $slide->link : (isset($slide->store->cashback) ? route('stores.show', $slide->store->slug) : '/') }}">
                                <img class="img-fluid carousel-image" src="{{ asset($slide->banner) }}" alt="" onerror=_logo(this)>
                            </a>
                        </div>
                    @endforeach
                </div>
                @if (count($slider->slides) > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#Slider" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#Slider" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                @endif
            </div>
        </div>
    </section>
@endif
