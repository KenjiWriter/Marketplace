<!DOCTYPE html>
<html lang="en" class="h-100" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Marketplace - Buy and sell products easily">
    <meta name="theme-color" content="#4f46e5">

    <title>{{ config('app.name', 'Marketplace') }} - Modern Trading Platform</title>

    <!-- Preload critical assets -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Modern CSS framework with utility classes -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Modern icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.34.0/tabler-icons.min.css">

    <!-- Modern fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/marketplace-2025.css') }}">

    <!-- Add PWA support -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/icons/icon-192x192.png') }}">

    @livewireStyles

    <!-- Structured data for SEO -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "{{ config('app.name', 'Marketplace') }}",
        "url": "{{ url('/') }}",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "{{ url('/') }}?search={search_term}",
            "query-input": "required name=search_term"
        }
    }
    </script>
</head>

<body class="d-flex flex-column h-100 bg-body">
    <!-- Accessibility skip link -->
    <a href="#main-content" class="visually-hidden-focusable">Skip to content</a>

    <!-- Theme toggle (header) -->
    <div class="position-fixed end-0 top-0 p-3" style="z-index:1050;">
        <button id="theme-toggle" class="btn btn-sm btn-icon rounded-circle shadow-sm" aria-label="Toggle theme">
            <i class="ti ti-sun"></i>
        </button>
    </div>

    <!-- Modern Navbar -->
    <header class="navbar navbar-expand-lg sticky-top border-bottom">
        <nav class="container-fluid container-xxl">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('index') }}">
                <span class="brand-logo">
                    <i class="ti ti-shopping-cart fs-3 text-primary"></i>
                </span>
                <span class="ms-2 fw-semibold">
                    <span class="text-primary">Wenzzi</span> Marketplace
                </span>
            </a>

            <button class="navbar-toggler border-0 p-2" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#navbarOffcanvas" aria-controls="navbarOffcanvas" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="ti ti-menu-2 fs-1"></i>
            </button>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="navbarOffcanvas">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title d-flex align-items-center">
                        <i class="ti ti-shopping-cart fs-3 text-primary"></i>
                        <span class="ms-2">Marketplace</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @if (!Auth::guest())
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" href="{{ route('post.add') }}">
                                    <i class="ti ti-plus me-2"></i> New Listing
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center"
                                    href="{{ route('profile', auth()->user()->id) }}">
                                    <i class="ti ti-user me-2"></i> Profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" href="{{ route('messages') }}">
                                    <i class="ti ti-messages me-2"></i> Messages
                                </a>
                            </li>
                        @endif
                    </ul>

                    <div class="d-flex mt-3 mt-lg-0">
                        @if (!Auth::guest())
                            <a href="{{ route('balance') }}"
                                class="btn btn-outline-primary me-3 d-flex align-items-center">
                                <i class="ti ti-wallet me-2"></i>${{ auth()->user()->balance }}
                            </a>
                            <form action="{{ route('auth.logout') }}" method="POST">
                                @csrf
                                <button class="btn btn-danger d-flex align-items-center" type="submit">
                                    <i class="ti ti-logout me-2"></i>Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('auth') }}" class="btn btn-primary d-flex align-items-center">
                                <i class="ti ti-login me-2"></i>Login / Register
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Alert Messages -->
    <div class="container-xxl my-3">
        @if (session()->has('global_error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="ti ti-alert-circle me-2"></i>{{ session('global_error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('global_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti ti-check me-2"></i>{{ session('global_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main id="main-content" class="flex-shrink-0 py-4">
        @yield('content')
    </main>

    <!-- Modern Footer -->
    <footer class="footer mt-auto py-5 bg-dark text-white">
        <div class="container-xxl">
            <div class="row g-5">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="ti ti-shopping-cart fs-3 text-primary"></i>
                        <h5 class="ms-2 mb-0 text-primary">Wenzzi Marketplace</h5>
                    </div>
                    <p class="mb-4">A modern platform for buying and selling products with ease and security.</p>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary-subtle text-primary me-2">
                            <i class="ti ti-brand-php"></i> Laravel
                        </span>
                        <span class="badge bg-primary-subtle text-primary me-2">
                            <i class="ti ti-bolt"></i> Livewire
                        </span>
                        <span class="badge bg-primary-subtle text-primary">
                            <i class="ti ti-brand-bootstrap"></i> Bootstrap
                        </span>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('index') }}"
                                class="text-decoration-none text-white-50 hover-text-white d-flex align-items-center">
                                <i class="ti ti-home me-2"></i> Home
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#"
                                class="text-decoration-none text-white-50 hover-text-white d-flex align-items-center">
                                <i class="ti ti-info-circle me-2"></i> About Us
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#"
                                class="text-decoration-none text-white-50 hover-text-white d-flex align-items-center">
                                <i class="ti ti-help-circle me-2"></i> FAQ
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-decoration-none text-white-50 hover-text-white d-flex align-items-center">
                                <i class="ti ti-mail me-2"></i> Contact
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <h5 class="mb-3">Connect With Us</h5>
                    <div class="d-flex gap-3 mb-4">
                        <a href="#" class="social-icon">
                            <i class="ti ti-brand-facebook"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="ti ti-brand-twitter"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="ti ti-brand-instagram"></i>
                        </a>
                        <a href="https://github.com/KenjiWriter" class="social-icon">
                            <i class="ti ti-brand-github"></i>
                        </a>
                    </div>

                    <h5 class="mb-3">Newsletter</h5>
                    <form class="d-flex">
                        <input type="email" class="form-control me-2" placeholder="Your email">
                        <button class="btn btn-primary" type="submit">
                            <i class="ti ti-send"></i>
                        </button>
                    </form>
                </div>
            </div>

            <hr class="my-4 border-secondary">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <p class="mb-3 mb-md-0">
                    &copy; {{ date('Y') }}
                    <a href="https://github.com/KenjiWriter" class="text-decoration-none text-primary">Wenzzi</a>.
                    All rights reserved.
                </p>
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <a href="#" class="text-decoration-none text-white-50 small">Privacy Policy</a>
                    </li>
                    <li class="list-inline-item">
                        <span class="text-white-50">•</span>
                    </li>
                    <li class="list-inline-item">
                        <a href="#" class="text-decoration-none text-white-50 small">Terms of Service</a>
                    </li>
                </ul>
            </div>
        </div>
    </footer>

    <!-- Back to top button -->
    <button type="button" class="btn btn-primary btn-icon rounded-circle position-fixed end-0 bottom-0 m-3 shadow"
        id="back-to-top" style="z-index:1030; display:none;">
        <i class="ti ti-arrow-up"></i>
    </button>

    <!-- Modern JavaScript libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Theme toggler functionality
        document.addEventListener('DOMContentLoaded', () => {
            // Theme toggle
            const themeToggle = document.getElementById('theme-toggle');
            const themeIcon = themeToggle.querySelector('i');

            // Check for saved theme preference or default to user preference
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            // Set initial theme
            if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
                themeIcon.classList.remove('ti-sun');
                themeIcon.classList.add('ti-moon');
            }

            // Toggle theme on click
            themeToggle.addEventListener('click', () => {
                const currentTheme = document.documentElement.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

                document.documentElement.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);

                // Toggle icon
                themeIcon.classList.toggle('ti-sun');
                themeIcon.classList.toggle('ti-moon');
            });

            // Back to top button
            const backToTopButton = document.getElementById('back-to-top');

            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    backToTopButton.style.display = 'flex';
                } else {
                    backToTopButton.style.display = 'none';
                }
            });

            backToTopButton.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>
    @livewireScripts
    @stack('scripts')
</body>

</html>
