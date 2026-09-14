@extends('temple.layouts.app')

@section('title', 'Premium Dashboard')

@section('content')

<div class="page-header">
    <div class="page-header-left">
        <div class="page-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2 9 6h6z"/>
                <path d="M7 6h10l1.2 3H5.8z"/>
                <path d="M5 9h14v2H5z"/>
                <path d="M6 11h12v9H6z"/>
                <path d="M10 20v-4h4v4"/>
            </svg>
        </div>
        <div>
           <h1 class="page-title">
    {{ $temple->temple_name ?? 'Temple' }} — Dashboard
</h1>

            <p class="page-subtitle">
                Namaskaram, {{ Auth::user()->name ?? 'Priest/Staff' }}.
                Here's the overall temple activity summary.
            </p>
        </div>
    </div>

    <div class="page-header-actions">

        <a href="#" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            New Vazhipad
        </a>
    </div>
</div>



<!-- Temple Photo Gallery — full-bleed, no card padding -->
<div class="gallery-panel">
    @php
        $galleryImages = [];
        $usingLogoFallback = false;

        // 1. Try gallery images first
        if ($templeImages) {
            foreach (['image1', 'image2', 'image3'] as $field) {
                if (!empty($templeImages->{$field})) {
                    $galleryImages[] = [
                        'path'    => $templeImages->{$field},
                        'caption' => 'Temple View',
                    ];
                }
            }
        }

        // 2. Fallback to temple logo if no gallery images
        if (empty($galleryImages) && !empty($temple->logo)) {
            $galleryImages[] = [
                'path'    => $temple->logo,
                'caption' => $temple->temple_name ?? $temple->name ?? 'Temple',
            ];
            $usingLogoFallback = true;
        }

        // 3. Final fallback — placeholder so swiper always renders
        if (empty($galleryImages)) {
            $galleryImages[] = [
                'path'    => null,
                'caption' => $temple->temple_name ?? $temple->name ?? 'Temple',
            ];
        }
    @endphp


    @if(count($galleryImages) > 0)

        <div class="swiper temple-swiper">

            <div class="swiper-wrapper">

                @foreach($galleryImages as $image)

                    <div class="swiper-slide">

                        @php
                            $imageUrl = !empty($image['path'])
                                ? Storage::disk('public')->url($image['path'])
                                : asset('images/temple-placeholder.jpg');
                        @endphp

                        <img
                            src="{{ $imageUrl }}"
                            alt="{{ $image['caption'] }}"
                            onerror="this.onerror=null;this.src='{{ asset('images/temple-placeholder.jpg') }}';"
                        >

                        @if($usingLogoFallback && count($galleryImages) === 1)
                            <div class="logo-badge">Logo</div>
                        @endif

                        <div class="slide-caption">
                            {{ $image['caption'] }}
                        </div>

                    </div>

                @endforeach

            </div>

            @if(count($galleryImages) > 1)

                <!-- Pagination -->
                <div class="swiper-pagination"></div>

                <!-- Navigation -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>

            @endif

        </div>

    @endif

</div>





@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
    /* ----- GALLERY PANEL — full bleed, no card, no padding, no header ----- */
    .gallery-panel {
        width: 100%;
        margin: 0;
        padding: 0;
        border: none;
        border-radius: 0;
        box-shadow: none;
        background: transparent;
        overflow: visible;
    }

    /* Remove any default panel-header styles inside this panel */
    .gallery-panel .panel-header {
        display: none;
    }

    /* Swiper container — full width, tall, no card */
    .temple-swiper {
        width: 100%;
        height: 480px;       /* taller for a big, immersive look */
        margin: 0;
        padding: 0;
        border-radius: 0;
        overflow: hidden;
    }

    .temple-swiper .swiper-slide {
        position: relative;
        overflow: hidden;
        background: #111;    /* dark fallback while image loads */
    }

    .temple-swiper .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        /* no extra border-radius — edge-to-edge */
    }

    .temple-swiper .slide-caption {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        padding: 14px 20px;
        background: linear-gradient(to top, rgba(0,0,0,0.65), rgba(0,0,0,0));
        color: #fff;
        font-size: 15px;
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    /* Small "Logo" badge shown when only the logo is available */
    .logo-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: rgba(0, 0, 0, 0.55);
        color: #fff;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 20px;
        backdrop-filter: blur(4px);
    }

    .temple-swiper .swiper-button-prev,
    .temple-swiper .swiper-button-next {
        color: #fff;
        text-shadow: 0 1px 4px rgba(0,0,0,0.6);
        width: 44px;
        height: 44px;
    }

    .temple-swiper .swiper-button-prev::after,
    .temple-swiper .swiper-button-next::after {
        font-size: 24px;
        font-weight: 700;
    }

    .temple-swiper .swiper-pagination {
        bottom: 14px;
    }

    .temple-swiper .swiper-pagination-bullet {
        background: #fff;
        opacity: 0.6;
        width: 10px;
        height: 10px;
    }

    .temple-swiper .swiper-pagination-bullet-active {
        opacity: 1;
        background: #d4a437;
        width: 26px;
        border-radius: 6px;
    }

    /* Responsive heights */
    @media (max-width: 900px) {
        .temple-swiper {
            height: 380px;
        }
    }

    @media (max-width: 640px) {
        .temple-swiper {
            height: 260px;
        }
        .temple-swiper .slide-caption {
            font-size: 13px;
            padding: 10px 14px;
        }
        .temple-swiper .swiper-button-prev,
        .temple-swiper .swiper-button-next {
            width: 34px;
            height: 34px;
        }
        .temple-swiper .swiper-button-prev::after,
        .temple-swiper .swiper-button-next::after {
            font-size: 18px;
        }
        .logo-badge {
            top: 10px;
            left: 10px;
            font-size: 10px;
            padding: 3px 8px;
        }
    }
</style>
@endpush

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>

<script>
    // Temple gallery swiper — full-bleed, swipe/drag, auto-advance,
    // prev/next arrows, pagination dots.
    // Only initialize if the swiper markup exists on the page.
    if (document.querySelector('.temple-swiper')) {
        new Swiper('.temple-swiper', {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            speed: 500,
            grabCursor: true,
            pagination: {
                el: '.temple-swiper .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.temple-swiper .swiper-button-next',
                prevEl: '.temple-swiper .swiper-button-prev',
            },
        });
    }

    const ctx = document.getElementById('hundiTrendChart');

    if (ctx) {
        const chartLabels = {!! json_encode($chartLabels ?? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']) !!};
        const chartValues = {!! json_encode($chartValues ?? [18500, 22400, 19800, 26700, 31200, 42500, 24850]) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Hundi Collection',
                    data: chartValues,
                    borderColor: '#63151f',
                    backgroundColor: 'rgba(99, 21, 31, 0.08)',
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#63151f',
                    pointRadius: window.innerWidth < 640 ? 2 : 3,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            callback: function (v) {
                                return '₹' + (v / 1000) + 'k';
                            }
                        },
                        grid: {
                            color: '#ecdfc4'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 0,
                            autoSkip: true
                        }
                    }
                }
            }
        });
    }
</script>

@endpush