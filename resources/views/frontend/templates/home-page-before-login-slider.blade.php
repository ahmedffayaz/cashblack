@php $slider = getHomeSliders(); @endphp
@if (count($slider->slides) && empty(auth()->user()))
    <section id="hero" class="hero mb-3">
        <div class="container">
            <div id="Slider" class="carousel slide" data-bs-ride="carousel">

                <div class="carousel-inner">
                    @if (count($slider->slides) > 1)
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#Slider" data-bs-slide-to="0" class="" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#Slider" data-bs-slide-to="1" class="active" aria-current="true" aria-label="Slide 2"></button>
                        </div>
                    @endif
                    @foreach ($slider->slides as $i => $slide)
                        <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                            <a
                                href="{{ !empty($slide->link) && !isset($slide->store) ? $slide->link : (isset($slide->store->cashback) ? route('stores.show', $slide->store->slug) : '/') }}">
                                <img class="img-fluid" src="{{ asset($slide->banner) }}" alt="" style="min-width: 100%;">
                            </a>
                        </div>
                    @endforeach
                    @if (count($slider->slides) > 1)
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>

                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    @endif
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
