@extends('layouts.app')

@section('title', 'Catálogo de Filmes')

@section('content')
    <style>
        .swiper-wrapper {
            width: 100%;
            height: max-content !important;
            padding-bottom: 64px !important;
            -webkit-transition-timing-function: linear !important;
            transition-timing-function: linear !important;
            position: relative;
        }
        .swiper-pagination-bullet {
            background: #4f46e5;
        }

        .multiple-slide-carousel .swiper-slide {
            height: auto;
        }
    </style>


        <div class="w-full relative mt-12">
            <div class="swiper multiple-slide-carousel">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="bg-indigo-50 rounded-2xl h-96 flex justify-center items-center">
                            <span class="text-2xl font-semibold text-indigo-600">Slide 1</span>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="bg-indigo-50 rounded-2xl h-96 flex justify-center items-center">
                            <span class="text-2xl font-semibold text-indigo-600">Slide 2</span>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="bg-indigo-50 rounded-2xl h-96 flex justify-center items-center">
                            <span class="text-2xl font-semibold text-indigo-600">Slide 3</span>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="bg-indigo-50 rounded-2xl h-96 flex justify-center items-center">
                            <span class="text-2xl font-semibold text-indigo-600">Slide 4</span>
                        </div>
                    </div>
                </div>
                <div class="absolute flex justify-center items-center m-auto left-0 right-0 w-fit bottom-0 z-10">
                    <button class="multiple-slide-carousel-prev group !p-2 flex justify-center items-center border border-solid border-indigo-600 !w-12 !h-12 transition-all duration-500 rounded-full hover:bg-indigo-600 !-translate-x-16">
                        <svg class="h-5 w-5 text-indigo-600 group-hover:text-white" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M10.0002 11.9999L6 7.99971L10.0025 3.99719" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button class="multiple-slide-carousel-next group !p-2 flex justify-center items-center border border-solid border-indigo-600 !w-12 !h-12 transition-all duration-500 rounded-full hover:bg-indigo-600 !translate-x-16">
                        <svg class="h-5 w-5 text-indigo-600 group-hover:text-white" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M5.99984 4.00012L10 8.00029L5.99748 12.0028" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var swiper = new Swiper(".multiple-slide-carousel", {
                loop: true,
                slidesPerView: 3,
                spaceBetween: 20,
                navigation: {
                    nextEl: ".multiple-slide-carousel-next",
                    prevEl: ".multiple-slide-carousel-prev",
                },
                breakpoints: {
                    1920: {
                        slidesPerView: 3,
                        spaceBetween: 30
                    },
                    1028: {
                        slidesPerView: 2,
                        spaceBetween: 30
                    },
                    640: {
                        slidesPerView: 1,
                        spaceBetween: 20
                    },
                    320: {
                        slidesPerView: 1,
                        spaceBetween: 10
                    }
                }
            });
        });
    </script>
@endsection
