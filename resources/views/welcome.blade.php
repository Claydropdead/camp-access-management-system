<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CAMS - Camp Access Management System</title>
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Materialize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #1565c0;
            --secondary-color: #0d47a1;
            --accent-color: #bbdefb;
        }
        
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            font-family: 'Roboto', sans-serif;
        }
        
        main {
            flex: 1 0 auto;
        }
        
        .nav-wrapper {
            padding: 0 15px;
        }
        
        .brand-logo {
            display: flex;
            align-items: center;
        }
        
        .section {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        
        .card {
            transition: all 0.3s ease;
            border-radius: 8px;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
        }
        
        .feature-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        
        /* Full-screen carousel styles */
        .carousel.carousel-slider {
            height: 100vh !important;
            perspective: 1000px;
            margin-top: -64px; /* Adjust for navbar height */
        }
        
        .carousel .carousel-item {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .carousel .carousel-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4); /* Dark overlay for better text readability */
        }
        
        .carousel-content {
            background: rgba(0, 0, 0, 0.6);
            padding: 30px 40px;
            border-radius: 8px;
            max-width: 700px;
            color: white;
            text-align: center;
            position: relative; /* Ensures content is above the overlay */
            z-index: 2;
        }
        
        .hero-title {
            font-weight: 700;
            margin-top: 0;
            font-size: 3rem;
        }
        
        .list-icon {
            vertical-align: middle;
            margin-right: 8px;
            color: var(--primary-color);
        }
        
        .feature-card-title {
            font-weight: 500;
            margin-top: 10px;
        }
        
        .parallax-container {
            height: 250px;
        }
        
        .cta-section {
            background: linear-gradient(135deg, #1565c0 0%, #0d47a1 100%);
            padding: 40px 0;
            color: white;
        }
        
        .feature-card .card-content {
            min-height: 250px;
        }
        
        .pulse-icon {
            overflow: visible;
            position: relative;
        }
        
        .pulse-icon:after {
            content: '';
            display: block;
            position: absolute;
            width: 70px;
            height: 70px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            animation: pulse 2s infinite;
            z-index: -1;
        }
        
        .hero-btn {
            margin: 8px;
        }
        
        /* Transparent navbar */
        nav {
            background-color: var(--secondary-color);
            box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 3px 1px -2px rgba(0,0,0,0.12), 0 1px 5px 0 rgba(0,0,0,0.2);
            position: absolute;
            z-index: 100;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        
        nav.scrolled {
            background-color: var(--secondary-color);
            box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14), 0 3px 1px -2px rgba(0,0,0,0.12), 0 1px 5px 0 rgba(0,0,0,0.2);
        }
        
        @keyframes pulse {
            0% {
                transform: translate(-50%, -50%) scale(0.5);
                background-color: rgba(21, 101, 192, 0.2);
            }
            70% {
                transform: translate(-50%, -50%) scale(1.2);
                background-color: rgba(21, 101, 192, 0);
            }
            100% {
                transform: translate(-50%, -50%) scale(0.5);
                background-color: rgba(21, 101, 192, 0);
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper">
                <a href="#" class="brand-logo">
                    <i class="material-icons">security</i>
                    CAMS
                </a>
                <a href="#" data-target="mobile-nav" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="#features">Features</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="/booking" class="waves-effect waves-light"><i class="material-icons left">event</i>Visitor Pre-Registration</a></li>
                </ul>
            </div>
        </nav>
    </div>
    
    <!-- Mobile Navigation -->
    <ul class="sidenav" id="mobile-nav">
        <li><a href="#features">Features</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="/booking"><i class="material-icons left">event</i>Visitor Pre-Registration</a></li>
    </ul>

    <main>
        <!-- Full-screen Hero Carousel -->
        <div class="carousel carousel-slider center">
            <div class="carousel-item" style="background-image: url('/images/security_access.jpg');">
                <div class="carousel-content">
                    <h1 class="hero-title">🛡️ Camp Access Management System</h1>
                    <p class="flow-text">End-to-End Security, Access Control & Logistics for Police Camps</p>
                    <div class="hero-buttons">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn-large blue darken-2 waves-effect waves-light hero-btn">Go to Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn-large blue darken-2 waves-effect waves-light hero-btn">Get Started</a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="carousel-item" style="background-image: url('/images/security_technology.jpg');">
                <div class="carousel-content">
                    <h2 class="hero-title">Smart Access Control</h2>
                    <p class="flow-text">RFID-powered secure entry for personnel and vehicles</p>
                    <a href="#features" class="btn-large blue darken-2 waves-effect waves-light hero-btn">Explore Features</a>
                </div>
            </div>
            
            <div class="carousel-item" style="background-image: url('/images/security_visitor.jpg');">
                <div class="carousel-content">
                    <h2 class="hero-title">Efficient Visitor Management</h2>
                    <p class="flow-text">Streamlined registration process with digital passes</p>
                    <a href="#about" class="btn-large blue darken-2 waves-effect waves-light hero-btn">Learn More</a>
                </div>
            </div>
            
            <div class="carousel-item" style="background-image: url('/images/parking_management.jpg');">
                <div class="carousel-content">
                    <h2 class="hero-title">Parking Made Simple</h2>
                    <p class="flow-text">Real-time tracking and efficient space management</p>
                    <a href="#features" class="btn-large blue darken-2 waves-effect waves-light hero-btn">See How</a>
                </div>
            </div>
        </div>

        <!-- Introduction Section -->
        <div class="section" id="about">
            <div class="container">
                <div class="row">
                    <div class="col s12">
                        <div class="card z-depth-3">
                            <div class="card-content">
                                <span class="card-title center-align blue-text text-darken-3">Advanced Security Solution</span>
                                <p class="center-align">
                                    CAMS is a smart, RFID-powered solution tailored for managing access, vehicles, visitors, and 
                                    parking within police camps. Designed for security, efficiency, and full auditability, 
                                    CAMS ensures your facility maintains the highest standards of security and operational excellence.
                                </p>
                                <div class="divider" style="margin: 20px 0;"></div>
                                <div class="row">
                                    <div class="col s12 m6">
                                        <ul class="collection">
                                            <li class="collection-item"><i class="material-icons list-icon">check_circle</i> 100% authorized entry for personnel and vehicles</li>
                                            <li class="collection-item"><i class="material-icons list-icon">check_circle</i> Streamlined parking with real-time tracking</li>
                                        </ul>
                                    </div>
                                    <div class="col s12 m6">
                                        <ul class="collection">
                                            <li class="collection-item"><i class="material-icons list-icon">check_circle</i> Professional visitor handling with traceable logs</li>
                                            <li class="collection-item"><i class="material-icons list-icon">check_circle</i> Automatic deactivation of expired credentials</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action center-align">
                                <a href="#features" class="btn blue darken-2 waves-effect waves-light">Explore Features</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Features Section -->
        <div class="section grey lighten-4" id="features">
            <div class="container">
                <h2 class="center-align blue-text text-darken-3">Key Features</h2>
                <div class="row">
                    <!-- Feature 1 -->
                    <div class="col s12 m6 l3">
                        <div class="card feature-card">
                            <div class="card-content center-align">
                                <div class="pulse-icon">
                                    <i class="material-icons blue-text text-darken-3 feature-icon">lock</i>
                                </div>
                                <h5 class="feature-card-title">Access Control</h5>
                                <p>RFID-based authentication for personnel and vehicles with role-based permissions.</p>
                            </div>
                            <div class="card-action center-align">
                                <a href="#" class="blue-text text-darken-3">Learn More</a>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="col s12 m6 l3">
                        <div class="card feature-card">
                            <div class="card-content center-align">
                                <div class="pulse-icon">
                                    <i class="material-icons blue-text text-darken-3 feature-icon">local_parking</i>
                                </div>
                                <h5 class="feature-card-title">Parking Management</h5>
                                <p>Manual slot assignment with visual dashboard to monitor parking availability.</p>
                            </div>
                            <div class="card-action center-align">
                                <a href="#" class="blue-text text-darken-3">Learn More</a>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="col s12 m6 l3">
                        <div class="card feature-card">
                            <div class="card-content center-align">
                                <div class="pulse-icon">
                                    <i class="material-icons blue-text text-darken-3 feature-icon">people</i>
                                </div>
                                <h5 class="feature-card-title">Visitor Management</h5>
                                <p>Pre-registration, host approval, and digital appointment passes for visitors.</p>
                            </div>
                            <div class="card-action center-align">
                                <a href="#" class="blue-text text-darken-3">Learn More</a>
                            </div>
                        </div>
                    </div>

                    <!-- Feature 4 -->
                    <div class="col s12 m6 l3">
                        <div class="card feature-card">
                            <div class="card-content center-align">
                                <div class="pulse-icon">
                                    <i class="material-icons blue-text text-darken-3 feature-icon">assignment_turned_in</i>
                                </div>
                                <h5 class="feature-card-title">Compliance Engine</h5>
                                <p>Automated credential expiry alerts and enforcement for consistent security.</p>
                            </div>
                            <div class="card-action center-align">
                                <a href="#" class="blue-text text-darken-3">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="cta-section">
            <div class="container center-align">
                <h3>Ready to Secure Your Camp?</h3>
                <p class="flow-text">Get started with CAMS today and experience enhanced security and efficiency.</p>
                <div class="section">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-large white blue-text text-darken-3 waves-effect waves-light">Go to Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-large white blue-text text-darken-3 waves-effect waves-light">Get Started</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="page-footer grey darken-3">
        <div class="container">
            <div class="row">
                <div class="col s12 m6">
                    <h5 class="white-text">Camp Access Management System</h5>
                    <p class="grey-text text-lighten-4">End-to-End Security, Access Control & Logistics for Police Camps</p>
                </div>
                <div class="col s12 m6">
                    <h5 class="white-text">Quick Links</h5>
                    <ul>
                        <li><a class="grey-text text-lighten-3" href="#features">Features</a></li>
                        <li><a class="grey-text text-lighten-3" href="#about">About</a></li>
                        <li><a class="grey-text text-lighten-3" href="#">Support</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                © {{ date('Y') }} Camp Access Management System. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Materialize components
            M.AutoInit();
            
            // Initialize carousel with options
            var carousel = document.querySelectorAll('.carousel.carousel-slider');
            M.Carousel.init(carousel, {
                fullWidth: true,
                indicators: true,
                duration: 300,
            });
            
            // Auto play carousel
            setInterval(function() {
                var instance = M.Carousel.getInstance(carousel[0]);
                instance.next();
            }, 6000);
            
            // Transparent navbar effect
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('nav');
                if (window.scrollY > 100) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        });
    </script>
</body>
</html>