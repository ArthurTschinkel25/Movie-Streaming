@extends('layouts.app')

@section('title', 'StreamFlix - Início')

@section('content')
    <div class="container mx-auto px-4 pb-16">

        <section class="mb-20 mt-6">
            <div class="swiper featured-carousel rounded-xl overflow-hidden">
                <div class="swiper-wrapper">
                    @if(isset($dashboardMovies['mostPopularMovies']) && count($dashboardMovies['mostPopularMovies']) > 0)
                        @foreach($dashboardMovies['mostPopularMovies'] as $movie)
                            <div class="swiper-slide featured-slide">
                                <div class="relative aspect-[21/9] md:aspect-[2.4/1] text-white rounded-xl overflow-hidden">
                                    <img src="https://image.tmdb.org/t/p/w1280/{{ $movie['backdrop_path'] ?? $movie['poster_path'] }}"
                                         alt="Backdrop de {{ $movie['title'] }}"
                                         class="w-full h-full object-cover">

                                    <div class="absolute inset-0 bg-gradient-to-r from-dark-bg via-dark-bg/80 to-transparent"></div>

                                    <div class="absolute bottom-0 left-0 w-full gradient-overlay h-3/4"></div>

                                    <div class="absolute bottom-0 left-0 w-full p-6 md:p-8 lg:p-12">
                                        <div class="max-w-2xl">
                                            <div class="flex items-center gap-2 flex-wrap mb-4">
                                                <span class="bg-primary/20 text-primary text-xs font-semibold px-3 py-1 rounded-full">{{ \Carbon\Carbon::parse($movie['release_date'])->format('Y') }}</span>
                                                @if(isset($movie['runtime']) && $movie['runtime'] > 0)
                                                    @php
                                                        $hours = floor($movie['runtime'] / 60);
                                                        $minutes = $movie['runtime'] % 60;
                                                        $runtimeFormatted = '';
                                                        if ($hours > 0) { $runtimeFormatted .= $hours . 'h '; }
                                                        if ($minutes > 0) { $runtimeFormatted .= $minutes . 'm'; }
                                                    @endphp
                                                    <span class="bg-white/10 text-text-light text-xs font-semibold px-3 py-1 rounded-full">{{ trim($runtimeFormatted) }}</span>
                                                @endif
                                                @if(isset($movie['genres']))
                                                    @foreach(array_slice($movie['genres'], 0, 2) as $genre)
                                                        <span class="bg-white/10 text-text-light text-xs font-semibold px-3 py-1 rounded-full">{{ $genre }}</span>
                                                    @endforeach
                                                @endif
                                                <span class="bg-amber-500/20 text-amber-300 text-xs font-semibold px-3 py-1 rounded-full flex items-center gap-1.5">
                                                    <i class="fas fa-star text-amber-300 text-xs"></i>
                                                    {{ number_format($movie['vote_average'], 1) }}
                                                </span>
                                            </div>

                                            <h2 class="text-3xl md:text-5xl font-bold mb-4 drop-shadow-lg">{{ $movie['title'] }}</h2>

                                            <p class="text-text-light mb-6 line-clamp-3 max-w-xl">{{ $movie['overview'] ?? 'Descrição não disponível.' }}</p>

                                            <div class="flex items-center gap-4">
                                                <button class="open-modal-button bg-primary text-dark-bg font-bold py-3 px-8 rounded-lg flex items-center gap-3 text-lg transition-transform hover:scale-105 play-button-pulse"
                                                        data-title="{{ $movie['title'] }}"
                                                        data-backdrop="https://image.tmdb.org/t/p/w1280/{{ $movie['backdrop_path'] ?? $movie['poster_path'] }}"
                                                        data-year="{{ \Carbon\Carbon::parse($movie['release_date'])->format('Y') }}"
                                                        data-rating="{{ number_format($movie['vote_average'], 1) }}"
                                                        data-runtime="{{ $runtimeFormatted ?? '' }}"
                                                        data-genres='@json(isset($movie['genres']) ? array_slice($movie['genres'], 0, 3) : [])'
                                                        data-overview="{{ $movie['overview'] ?? 'Sinopse não disponível.' }}">
                                                    <i class="fas fa-play"></i>
                                                    <span>Assistir Agora</span>
                                                </button>

                                                <button class="bg-white/10 text-text-main font-bold py-3 px-6 rounded-lg flex items-center gap-3 text-lg transition-colors hover:bg-white/20">
                                                    <i class="fas fa-plus"></i>
                                                    <span>Minha Lista</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="swiper-slide">
                            <div class="aspect-[2.4/1] bg-secondary rounded-xl flex items-center justify-center">
                                <p class="text-text-light text-xl">Nenhum filme popular encontrado.</p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="absolute bottom-6 right-6 z-10 flex gap-3">
                    <button class="featured-prev group w-12 h-12 rounded-full bg-secondary/80 backdrop-blur-sm border border-border-color flex items-center justify-center transition-all duration-300 hover:bg-primary hover:border-primary">
                        <i class="fas fa-chevron-left text-primary text-lg transition-colors group-hover:text-dark-bg"></i>
                    </button>
                    <button class="featured-next group w-12 h-12 rounded-full bg-secondary/80 backdrop-blur-sm border border-border-color flex items-center justify-center transition-all duration-300 hover:bg-primary hover:border-primary">
                        <i class="fas fa-chevron-right text-primary text-lg transition-colors group-hover:text-dark-bg"></i>
                    </button>
                </div>

                <div class="swiper-pagination featured-pagination !bottom-4"></div>
            </div>
        </section>

        <section class="mb-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-text-main flex items-center gap-3">
                    <span class="text-primary"><i class="fas fa-rocket"></i></span>
                    Lançamentos Recentes
                </h2>
                <div class="flex gap-3">
                    <button class="recent-prev group w-10 h-10 rounded-full bg-secondary/80 backdrop-blur-sm border border-border-color flex items-center justify-center transition-all duration-300 hover:bg-primary hover:border-primary">
                        <i class="fas fa-chevron-left text-primary text-sm transition-colors group-hover:text-dark-bg"></i>
                    </button>
                    <button class="recent-next group w-10 h-10 rounded-full bg-secondary/80 backdrop-blur-sm border border-border-color flex items-center justify-center transition-all duration-300 hover:bg-primary hover:border-primary">
                        <i class="fas fa-chevron-right text-primary text-sm transition-colors group-hover:text-dark-bg"></i>
                    </button>
                </div>
            </div>

            <div class="swiper recent-movies-carousel">
                <div class="swiper-wrapper">
                    @if(isset($dashboardMovies['recentMovies']) && count($dashboardMovies['recentMovies']) > 0)
                        @foreach($dashboardMovies['recentMovies'] as $movie)
                            @php
                                $runtimeFormatted = '';
                                if (isset($movie['runtime']) && $movie['runtime'] > 0) {
                                    $hours = floor($movie['runtime'] / 60);
                                    $minutes = $movie['runtime'] % 60;
                                    if ($hours > 0) { $runtimeFormatted .= $hours . 'h '; }
                                    if ($minutes > 0) { $runtimeFormatted .= $minutes . 'm'; }
                                    $runtimeFormatted = trim($runtimeFormatted);
                                }
                            @endphp

                            <div class="swiper-slide group">
                                <div class="movie-card aspect-[2/3] bg-secondary rounded-xl overflow-hidden relative card-hover">
                                    <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}"
                                         alt="Pôster de {{ $movie['title'] }}"
                                         class="w-full h-full object-cover">

                                    <div class="absolute inset-0 bg-gradient-to-t from-dark-bg/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                                        <h3 class="text-lg font-bold mb-2 line-clamp-2">{{ $movie['title'] }}</h3>

                                        <div class="flex items-center justify-between text-sm text-text-light mb-3">
                                            <span>{{ \Carbon\Carbon::parse($movie['release_date'])->format('Y') }}</span>
                                            <div class="flex items-center gap-1">
                                                <i class="fas fa-star text-amber-400"></i>
                                                <span>{{ number_format($movie['vote_average'], 1) }}</span>
                                            </div>
                                        </div>

                                        <button class="open-modal-button w-full bg-primary text-dark-bg font-medium py-2 rounded-lg transition-transform hover:scale-[1.02]"
                                                data-title="{{ $movie['title'] }}"
                                                data-backdrop="https://image.tmdb.org/t/p/w1280/{{ $movie['backdrop_path'] ?? $movie['poster_path'] }}"
                                                data-year="{{ \Carbon\Carbon::parse($movie['release_date'])->format('Y') }}"
                                                data-rating="{{ number_format($movie['vote_average'], 1) }}"
                                                data-runtime="{{ $runtimeFormatted }}"
                                                data-genres='@json(isset($movie['genres']) ? array_slice($movie['genres'], 0, 3) : [])'
                                                data-overview="{{ $movie['overview'] ?? 'Sinopse não disponível.' }}">
                                            Ver Detalhes
                                        </button>
                                    </div>

                                    <div class="absolute top-3 right-3 bg-dark-bg/80 text-primary text-xs font-bold px-2 py-1 rounded-full">
                                        <i class="fas fa-star mr-1"></i>{{ number_format($movie['vote_average'], 1) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-span-full text-center py-12">
                            <p class="text-text-light">Nenhum lançamento recente encontrado.</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <section class="mb-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-text-main flex items-center gap-3">
                    <span class="text-primary"><i class="fas fa-crown"></i></span>
                    Melhores Avaliações
                </h2>
                <div class="flex gap-3">
                    <button class="rating-prev group w-10 h-10 rounded-full bg-secondary/80 backdrop-blur-sm border border-border-color flex items-center justify-center transition-all duration-300 hover:bg-primary hover:border-primary">
                        <i class="fas fa-chevron-left text-primary text-sm transition-colors group-hover:text-dark-bg"></i>
                    </button>
                    <button class="rating-next group w-10 h-10 rounded-full bg-secondary/80 backdrop-blur-sm border border-border-color flex items-center justify-center transition-all duration-300 hover:bg-primary hover:border-primary">
                        <i class="fas fa-chevron-right text-primary text-sm transition-colors group-hover:text-dark-bg"></i>
                    </button>
                </div>
            </div>

            <div class="swiper rating-movies-carousel">
                <div class="swiper-wrapper">
                    @if(isset($dashboardMovies['goodRatingMovies']) && count($dashboardMovies['goodRatingMovies']) > 0)
                        @foreach($dashboardMovies['goodRatingMovies'] as $movie)
                            @php
                                $runtimeFormatted = '';
                                if (isset($movie['runtime']) && $movie['runtime'] > 0) {
                                    $hours = floor($movie['runtime'] / 60);
                                    $minutes = $movie['runtime'] % 60;
                                    if ($hours > 0) { $runtimeFormatted .= $hours . 'h '; }
                                    if ($minutes > 0) { $runtimeFormatted .= $minutes . 'm'; }
                                    $runtimeFormatted = trim($runtimeFormatted);
                                }
                            @endphp

                            <div class="swiper-slide group">
                                <div class="movie-card aspect-[2/3] bg-secondary rounded-xl overflow-hidden relative card-hover">
                                    <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}"
                                         alt="Pôster de {{ $movie['title'] }}"
                                         class="w-full h-full object-cover">

                                    <div class="absolute inset-0 bg-gradient-to-t from-dark-bg/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                                        <h3 class="text-lg font-bold mb-2 line-clamp-2">{{ $movie['title'] }}</h3>

                                        <div class="flex items-center justify-between text-sm text-text-light mb-3">
                                            <span>{{ \Carbon\Carbon::parse($movie['release_date'])->format('Y') }}</span>
                                            <div class="flex items-center gap-1">
                                                <i class="fas fa-star text-amber-400"></i>
                                                <span>{{ number_format($movie['vote_average'], 1) }}</span>
                                            </div>
                                        </div>

                                        <button class="open-modal-button w-full bg-primary text-dark-bg font-medium py-2 rounded-lg transition-transform hover:scale-[1.02]"
                                                data-title="{{ $movie['title'] }}"
                                                data-backdrop="https://image.tmdb.org/t/p/w1280/{{ $movie['backdrop_path'] ?? $movie['poster_path'] }}"
                                                data-year="{{ \Carbon\Carbon::parse($movie['release_date'])->format('Y') }}"
                                                data-rating="{{ number_format($movie['vote_average'], 1) }}"
                                                data-runtime="{{ $runtimeFormatted }}"
                                                data-genres='@json(isset($movie['genres']) ? array_slice($movie['genres'], 0, 3) : [])'
                                                data-overview="{{ $movie['overview'] ?? 'Sinopse não disponível.' }}">
                                            Ver Detalhes
                                        </button>
                                    </div>

                                    <div class="absolute top-3 right-3 bg-amber-500/90 text-dark-bg text-xs font-bold px-2 py-1 rounded-full">
                                        <i class="fas fa-crown mr-1"></i>{{ number_format($movie['vote_average'], 1) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-span-full text-center py-12">
                            <p class="text-text-light">Nenhum filme bem avaliado encontrado.</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>

    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuração do carrossel de destaque
            const featuredSwiper = new Swiper(".featured-carousel", {
                loop: true,
                autoplay: {
                    delay: 6000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".featured-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".featured-next",
                    prevEl: ".featured-prev",
                },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
            });

            const swiperOptions = {
                loop: false,
                slidesPerView: 2.2,
                spaceBetween: 16,
                grabCursor: true,
                navigation: {
                    nextEl: ".recent-next",
                    prevEl: ".recent-prev",
                },
                breakpoints: {
                    640: { slidesPerView: 2.5, spaceBetween: 18 },
                    768: { slidesPerView: 3.5, spaceBetween: 20 },
                    1024: { slidesPerView: 4.5, spaceBetween: 22 },
                    1280: { slidesPerView: 5.5, spaceBetween: 24 },
                }
            };

            const recentSwiper = new Swiper(".recent-movies-carousel", {
                ...swiperOptions,
                navigation: {
                    nextEl: ".recent-next",
                    prevEl: ".recent-prev",
                },
            });

            const ratingSwiper = new Swiper(".rating-movies-carousel", {
                ...swiperOptions,
                navigation: {
                    nextEl: ".rating-next",
                    prevEl: ".rating-prev",
                },
            });

            const modal = document.getElementById('movie-modal');
            const modalBackdrop = document.getElementById('modal-backdrop');
            const openModalButtons = document.querySelectorAll('.open-modal-button');
            const closeModalButton = document.getElementById('modal-close-button');

            const modalElements = {
                backdropImage: document.getElementById('modal-backdrop-image'),
                title: document.getElementById('modal-title'),
                metaInfo: document.getElementById('modal-meta-info'),
                genres: document.getElementById('modal-genres'),
                overview: document.getElementById('modal-overview'),
            };

            const openModal = (button) => {
                const data = button.dataset;
                modalElements.backdropImage.src = data.backdrop;
                modalElements.title.textContent = data.title;
                modalElements.overview.textContent = data.overview;

                let runtimeHTML = '';
                if (data.runtime) {
                    runtimeHTML = `
                        <span class="text-text-main/60">•</span>
                        <span class="font-semibold">${data.runtime}</span>
                    `;
                }

                modalElements.metaInfo.innerHTML = `
                    <span class="text-xl font-semibold">${data.year}</span>
                    ${runtimeHTML}
                    <span class="text-text-main/60">•</span>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-star text-yellow-400 text-xl"></i>
                        <span class="text-xl font-semibold">${data.rating}</span>
                    </div>
                `;

                const genres = JSON.parse(data.genres);
                modalElements.genres.innerHTML = genres.map(genre =>
                    `<span class="bg-white/10 text-text-light text-sm font-medium px-3 py-1.5 rounded-full">${genre}</span>`
                ).join('');

                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            };

            const closeModal = () => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            };

            openModalButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.stopPropagation();
                    openModal(button);
                });
            });

            closeModalButton.addEventListener('click', closeModal);
            modalBackdrop.addEventListener('click', closeModal);
            document.addEventListener('keydown', (e) => {
                if (e.key === "Escape" && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });
    </script>
@endsection
