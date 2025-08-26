@extends('layouts.app')

@section('title', 'Catálogo de Filmes')

@section('content')
    <style>
        /* Estilos gerais para os carrosséis */
        .swiper-wrapper {
            padding-top: 24px;
            padding-bottom: 48px;
        }

        /* CARD PADRÃO (Lançamentos e Bem Avaliados) */
        .movie-card {
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        .movie-card .poster-image {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover; transition: opacity 0.4s ease-in-out; z-index: 1;
        }
        .movie-card .backdrop-image {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover; opacity: 0; transition: opacity 0.4s ease-in-out; z-index: 2;
            filter: brightness(0.8);
        }
        .swiper-slide:hover .movie-card {
            transform: scale(1.05);
            z-index: 10;
            box-shadow: 0 25px 50px -12px rgba(0, 255, 156, 0.2);
        }
        .swiper-slide:hover .movie-card .poster-image { opacity: 0; }
        .swiper-slide:hover .movie-card .backdrop-image { opacity: 1; }
        .movie-card .info-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.95) 20%, rgba(0,0,0,0.5) 60%, transparent 100%);
            opacity: 0; transition: opacity 0.4s ease-in-out; z-index: 3;
        }
        .swiper-slide:hover .movie-card .info-overlay { opacity: 1; }


        /* === NOVOS ESTILOS PARA O CARROSSEL DE DESTAQUE (Filmes Populares) === */
        .featured-carousel .swiper-wrapper {
            align-items: center; /* Centraliza os slides verticalmente */
        }

        .featured-movie-card {
            position: relative;
            overflow: hidden;
            border-radius: 0.75rem; /* 12px */
            transition: transform 0.5s ease, box-shadow 0.5s ease;
            transform: scale(0.9); /* Slides inativos são menores */
            opacity: 0.6;
        }

        .swiper-slide-active .featured-movie-card {
            transform: scale(1); /* Slide ativo é maior */
            opacity: 1;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .featured-movie-card .backdrop {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.85);
        }

        .featured-movie-card .content-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1.5rem; /* 24px */
            background: linear-gradient(90deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.5) 35%, transparent 100%);
        }

        .featured-movie-card .tags span {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            padding: 0.25rem 0.75rem; /* 4px 12px */
            border-radius: 9999px; /* rounded-full */
            font-size: 0.75rem; /* 12px */
            font-weight: 500;
        }

        .featured-movie-card .play-button {
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.8);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .featured-movie-card .play-button:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }

        .featured-movie-card .like-button {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }
        .featured-movie-card .like-button:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        /* Ajuste nos botões de navegação do carrossel de destaque */
        .featured-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 1rem;
            right: 1rem;
            z-index: 10;
        }

        #movie-modal.hidden {
            display: none;
        }

    </style>

    <div class="space-y-20">

        <section>
            <h2 class="text-3xl md:text-4xl font-bold text-text-main mb-6 flex items-center gap-4">
                <span class="text-primary">🔥</span> Filmes Populares em Destaque
            </h2>
            <div class="swiper featured-carousel relative">
                <div class="swiper-wrapper">
                    @if(isset($dashboardMovies['mostPopularMovies']) && count($dashboardMovies['mostPopularMovies']) > 0)
                        @foreach($dashboardMovies['mostPopularMovies'] as $movie)
                            <div class="swiper-slide">
                                <div class="featured-movie-card aspect-[2.4/1] text-white">
                                    <img src="https://image.tmdb.org/t/p/w1280/{{ $movie['backdrop_path'] ?? $movie['poster_path'] }}"
                                         alt="Backdrop de {{ $movie['title'] }}"
                                         class="backdrop">

                                    <div class="content-overlay">
                                        <div class="tags flex items-center gap-2 flex-wrap">
                                            <span>{{ \Carbon\Carbon::parse($movie['release_date'])->format('Y') }}</span>
                                            {{-- NOVO: Bloco para exibir a duração do filme --}}
                                            @if(isset($movie['runtime']) && $movie['runtime'] > 0)
                                                @php
                                                    $hours = floor($movie['runtime'] / 60);
                                                    $minutes = $movie['runtime'] % 60;
                                                    $runtimeFormatted = '';
                                                    if ($hours > 0) { $runtimeFormatted .= $hours . 'h '; }
                                                    if ($minutes > 0) { $runtimeFormatted .= $minutes . 'm'; }
                                                @endphp
                                                <span>{{ trim($runtimeFormatted) }}</span>
                                            @endif
                                            @if(isset($movie['genres']))
                                                @foreach(array_slice($movie['genres'], 0, 2) as $genre)
                                                    <span>{{ $genre }}</span>
                                                @endforeach
                                            @endif
                                            <span class="flex items-center gap-1.5">
                                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                                                {{ number_format($movie['vote_average'], 1) }}
                                            </span>
                                        </div>

                                        <div class="flex items-end justify-between">
                                            <div class="space-y-2">
                                                <h3 class="text-3xl md:text-4xl font-bold drop-shadow-lg max-w-lg">{{ $movie['title'] }}</h3>
                                                <button class="play-button">
                                                    <i class="fas fa-play text-xl ml-1"></i>
                                                </button>
                                            </div>
                                            <button class="like-button">
                                                <i class="far fa-heart text-xl"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-span-full text-center py-12">
                            <p class="text-text-light">Nenhum filme popular encontrado.</p>
                        </div>
                    @endif
                </div>
                <div class="featured-nav flex justify-between pointer-events-none">
                    <button class="popular-movies-prev group w-12 h-12 rounded-full bg-secondary/50 backdrop-blur-sm border border-neutral-700 flex items-center justify-center transition-all duration-300 hover:bg-primary hover:border-primary pointer-events-auto disabled:opacity-0">
                        <i class="fas fa-chevron-left text-primary text-lg transition-colors group-hover:text-dark-bg"></i>
                    </button>
                    <button class="popular-movies-next group w-12 h-12 rounded-full bg-secondary/50 backdrop-blur-sm border border-neutral-700 flex items-center justify-center transition-all duration-300 hover:bg-primary hover:border-primary pointer-events-auto disabled:opacity-0">
                        <i class="fas fa-chevron-right text-primary text-lg transition-colors group-hover:text-dark-bg"></i>
                    </button>
                </div>
            </div>
        </section>


        <section>
            <h2 class="text-3xl md:text-4xl font-bold text-text-main mb-6 flex items-center gap-4">
                <span class="text-primary">🎬</span> Lançamentos Recentes
            </h2>
            <div class="swiper recent-movies-carousel relative">
                <div class="swiper-wrapper">
                    @if(isset($dashboardMovies['recentMovies']) && count($dashboardMovies['recentMovies']) > 0)
                        @foreach($dashboardMovies['recentMovies'] as $movie)
                            <div class="swiper-slide group">
                                <div class="movie-card aspect-[2/3] bg-secondary rounded-lg relative">
                                    <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}"
                                         alt="Pôster de {{ $movie['title'] }}"
                                         class="poster-image">

                                    <img src="https://image.tmdb.org/t/p/w780/{{ $movie['poster_path']}}"
                                         alt="Backdrop de {{ $movie['title'] }}"
                                         class="backdrop-image">

                                    <div class="info-overlay absolute inset-0 flex flex-col justify-end p-5 text-white">
                                        <h3 class="text-xl font-bold drop-shadow-md">{{ $movie['title'] }}</h3>
                                        <div class="flex items-center gap-4 mt-2 text-text-light text-sm">
                                            <span>{{ \Carbon\Carbon::parse($movie['release_date'])->format('Y') }}</span>
                                            {{-- NOVO: Bloco para exibir a duração do filme --}}
                                            @if(isset($movie['runtime']) && $movie['runtime'] > 0)
                                                @php
                                                    $hours = floor($movie['runtime'] / 60);
                                                    $minutes = $movie['runtime'] % 60;
                                                    $runtimeFormatted = '';
                                                    if ($hours > 0) { $runtimeFormatted .= $hours . 'h '; }
                                                    if ($minutes > 0) { $runtimeFormatted .= $minutes . 'm'; }
                                                @endphp
                                                <span class="text-text-main/60">•</span>
                                                <span>{{ trim($runtimeFormatted) }}</span>
                                            @endif
                                            <div class="flex items-center gap-1.5">
                                                <i class="fas fa-star text-yellow-400"></i>
                                                <span>{{ number_format($movie['vote_average'], 1) }}</span>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap gap-2 mt-3">
                                            @if(isset($movie['genres']))
                                                @foreach($movie['genres'] as $genre)
                                                    <span class="bg-white/10 text-text-light text-xs font-medium px-2.5 py-1 rounded-full">
                                                        {{ $genre }}
                                                    </span>
                                                @endforeach
                                            @endif
                                        </div>
                                        {{-- NOVO: Bloco para formatar a duração para o modal --}}
                                        @php
                                            $runtimeFormattedForModal = '';
                                            if (isset($movie['runtime']) && $movie['runtime'] > 0) {
                                                $hours = floor($movie['runtime'] / 60);
                                                $minutes = $movie['runtime'] % 60;
                                                if ($hours > 0) { $runtimeFormattedForModal .= $hours . 'h '; }
                                                if ($minutes > 0) { $runtimeFormattedForModal .= $minutes . 'm'; }
                                                $runtimeFormattedForModal = trim($runtimeFormattedForModal);
                                            }
                                        @endphp
                                        <button
                                            class="open-modal-button mt-4 w-full bg-primary text-dark-bg font-bold py-2 rounded-lg text-sm transition-transform hover:scale-105"
                                            data-title="{{ $movie['title'] }}"
                                            data-backdrop="https://image.tmdb.org/t/p/w1280/{{ $movie['backdrop_path'] ?? $movie['poster_path'] }}"
                                            data-year="{{ \Carbon\Carbon::parse($movie['release_date'])->format('Y') }}"
                                            data-rating="{{ number_format($movie['vote_average'], 1) }}"
                                            data-runtime="{{ $runtimeFormattedForModal }}" {{-- NOVO: Atributo data-runtime --}}
                                            data-genres='@json(isset($movie['genres']) ? array_slice($movie['genres'], 0, 3) : [])'
                                            data-overview="{{ $movie['overview'] ?? 'Sinopse não disponível.' }}"
                                        >
                                            Ver Mais
                                        </button>
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
                <div class="absolute top-1/2 -translate-y-1/2 w-full flex justify-between z-20 px-2 pointer-events-none">
                    <button class="recent-movies-prev group w-12 h-12 rounded-full bg-secondary/50 backdrop-blur-sm border border-neutral-700 flex items-center justify-center transition-all duration-300 hover:bg-primary hover:border-primary pointer-events-auto disabled:opacity-0">
                        <i class="fas fa-chevron-left text-primary text-lg transition-colors group-hover:text-dark-bg"></i>
                    </button>
                    <button class="recent-movies-next group w-12 h-12 rounded-full bg-secondary/50 backdrop-blur-sm border border-neutral-700 flex items-center justify-center transition-all duration-300 hover:bg-primary hover:border-primary pointer-events-auto disabled:opacity-0">
                        <i class="fas fa-chevron-right text-primary text-lg transition-colors group-hover:text-dark-bg"></i>
                    </button>
                </div>
            </div>
        </section>

        <section>
            <h2 class="text-3xl md:text-4xl font-bold text-text-main mb-6 flex items-center gap-4">
                <span class="text-primary">⭐</span> Filmes Bem Avaliados
            </h2>
            <div class="swiper good-rating-carousel relative">
                <div class="swiper-wrapper">
                    @if(isset($dashboardMovies['goodRatingMovies']) && count($dashboardMovies['goodRatingMovies']) > 0)
                        @foreach($dashboardMovies['goodRatingMovies'] as $movie)
                            <div class="swiper-slide group">
                                <div class="movie-card aspect-[2/3] bg-secondary rounded-lg relative">
                                    <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] }}"
                                         alt="Pôster de {{ $movie['title'] }}"
                                         class="poster-image">

                                    <img src="https://image.tmdb.org/t/p/w780/{{ $movie['poster_path'] }}"
                                         alt="Backdrop de {{ $movie['title'] }}"
                                         class="backdrop-image">

                                    <div class="info-overlay absolute inset-0 flex flex-col justify-end p-5 text-white">
                                        <h3 class="text-xl font-bold drop-shadow-md">{{ $movie['title'] }}</h3>
                                        <div class="flex items-center gap-4 mt-2 text-text-light text-sm">
                                            <span>{{ \Carbon\Carbon::parse($movie['release_date'])->format('Y') }}</span>
                                            {{-- NOVO: Bloco para exibir a duração do filme --}}
                                            @if(isset($movie['runtime']) && $movie['runtime'] > 0)
                                                @php
                                                    $hours = floor($movie['runtime'] / 60);
                                                    $minutes = $movie['runtime'] % 60;
                                                    $runtimeFormatted = '';
                                                    if ($hours > 0) { $runtimeFormatted .= $hours . 'h '; }
                                                    if ($minutes > 0) { $runtimeFormatted .= $minutes . 'm'; }
                                                @endphp
                                                <span class="text-text-main/60">•</span>
                                                <span>{{ trim($runtimeFormatted) }}</span>
                                            @endif
                                            <div class="flex items-center gap-1.5">
                                                <i class="fas fa-star text-yellow-400"></i>
                                                <span>{{ number_format($movie['vote_average'], 1) }}</span>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap gap-2 mt-3">
                                            @if(isset($movie['genres']))
                                                @foreach(array_slice($movie['genres'], 0, 2) as $genre)
                                                    <span class="bg-white/10 text-text-light text-xs font-medium px-2.5 py-1 rounded-full">
                                                        {{ $genre }}
                                                    </span>
                                                @endforeach
                                            @endif
                                        </div>
                                        {{-- NOVO: Bloco para formatar a duração para o modal --}}
                                        @php
                                            $runtimeFormattedForModal = '';
                                            if (isset($movie['runtime']) && $movie['runtime'] > 0) {
                                                $hours = floor($movie['runtime'] / 60);
                                                $minutes = $movie['runtime'] % 60;
                                                if ($hours > 0) { $runtimeFormattedForModal .= $hours . 'h '; }
                                                if ($minutes > 0) { $runtimeFormattedForModal .= $minutes . 'm'; }
                                                $runtimeFormattedForModal = trim($runtimeFormattedForModal);
                                            }
                                        @endphp
                                        <button
                                            class="open-modal-button mt-4 w-full bg-primary text-dark-bg font-bold py-2 rounded-lg text-sm transition-transform hover:scale-105"
                                            data-title="{{ $movie['title'] }}"
                                            data-backdrop="https://image.tmdb.org/t/p/w1280/{{ $movie['backdrop_path'] ?? $movie['poster_path'] }}"
                                            data-year="{{ \Carbon\Carbon::parse($movie['release_date'])->format('Y') }}"
                                            data-rating="{{ number_format($movie['vote_average'], 1) }}"
                                            data-runtime="{{ $runtimeFormattedForModal }}" {{-- NOVO: Atributo data-runtime --}}
                                            data-genres='@json(isset($movie['genres']) ? array_slice($movie['genres'], 0, 3) : [])'
                                            data-overview="{{ $movie['overview'] ?? 'Sinopse não disponível.' }}"
                                        >
                                            Ver Detalhes
                                        </button>
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
                <div class="absolute top-1/2 -translate-y-1/2 w-full flex justify-between z-20 px-2 pointer-events-none">
                    <button class="good-rating-prev group w-12 h-12 rounded-full bg-secondary/50 backdrop-blur-sm border border-neutral-700 flex items-center justify-center transition-all duration-300 hover:bg-primary hover:border-primary pointer-events-auto disabled:opacity-0">
                        <i class="fas fa-chevron-left text-primary text-lg transition-colors group-hover:text-dark-bg"></i>
                    </button>
                    <button class="good-rating-next group w-12 h-12 rounded-full bg-secondary/50 backdrop-blur-sm border border-neutral-700 flex items-center justify-center transition-all duration-300 hover:bg-primary hover:border-primary pointer-events-auto disabled:opacity-0">
                        <i class="fas fa-chevron-right text-primary text-lg transition-colors group-hover:text-dark-bg"></i>
                    </button>
                </div>
            </div>
        </section>

    </div>

    <div id="movie-modal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div id="modal-backdrop" class="absolute inset-0"></div>
        <div id="modal-panel" class="relative w-full max-w-4xl bg-secondary rounded-xl overflow-hidden shadow-2xl shadow-primary/20">
            <div class="relative h-60 md:h-80 w-full">
                <img id="modal-backdrop-image" src="" alt="Backdrop do filme" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-secondary via-secondary/70 to-transparent"></div>
            </div>
            <button id="modal-close-button" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-black/50 flex items-center justify-center text-white hover:bg-primary hover:text-dark-bg transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
            <div class="p-6 md:p-8 -mt-20 relative z-10">
                <h2 id="modal-title" class="text-3xl md:text-5xl font-bold text-text-main drop-shadow-lg">Título do Filme</h2>
                <div id="modal-meta-info" class="flex items-center flex-wrap gap-x-4 gap-y-2 mt-4 text-text-light"></div>
                <div id="modal-genres" class="flex flex-wrap gap-2 mt-5"></div>
                <p id="modal-overview" class="mt-6 text-text-light leading-relaxed max-w-3xl">Sinopse do filme...</p>
                <div class="mt-8">
                    <button class="bg-primary text-dark-bg font-bold py-3 px-6 rounded-lg flex items-center gap-3 text-lg transition-transform hover:scale-105">
                        <i class="fas fa-play"></i>
                        <span>Assistir Trailer</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiperOptions = {
                loop: false,
                slidesPerView: 1.5,
                spaceBetween: 20,
                grabCursor: true,
                breakpoints: {
                    640: { slidesPerView: 2.5, spaceBetween: 24 },
                    768: { slidesPerView: 3.5, spaceBetween: 28 },
                    1024: { slidesPerView: 4.5, spaceBetween: 32 },
                    1280: { slidesPerView: 5.5, spaceBetween: 32 },
                }
            };

            new Swiper(".recent-movies-carousel", {
                ...swiperOptions,
                navigation: {
                    nextEl: ".recent-movies-next",
                    prevEl: ".recent-movies-prev",
                },
            });

            new Swiper(".good-rating-carousel", {
                ...swiperOptions,
                navigation: {
                    nextEl: ".good-rating-next",
                    prevEl: ".good-rating-prev",
                },
            });

            new Swiper(".featured-carousel", {
                loop: true,
                effect: 'coverflow',
                grabCursor: true,
                centeredSlides: true,
                slidesPerView: 'auto',
                coverflowEffect: {
                    rotate: 0,
                    stretch: 0,      // AJUSTADO: De 50 para 0 para diminuir o espaçamento e o tamanho percebido
                    depth: 120,
                    modifier: 1,
                    slideShadows: false,
                },
                navigation: {
                    nextEl: ".popular-movies-next",
                    prevEl: ".popular-movies-prev",
                },
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
            });


            // Lógica do Modal
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

                // ATUALIZADO: Lógica para incluir a duração (runtime) no modal
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
