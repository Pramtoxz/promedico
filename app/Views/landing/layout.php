<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Wisma - Tempat Penginapan Nyaman' ?></title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #1cc88a;
            --dark-color: #5a5c69;
            --light-color: #f8f9fc;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            overflow-x: hidden;
        }
        
        .navbar {
            transition: all 0.3s ease;
            padding: 1rem 2rem;
        }
        
        .navbar-scrolled {
            background-color: #fff !important;
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
            padding: 0.5rem 2rem;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary-color);
        }
        
        .nav-link {
            font-weight: 500;
            margin: 0 10px;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -3px;
            left: 0;
            background-color: var(--primary-color);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover:after {
            width: 100%;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 30px;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #3a5dd0;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
        }
        
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('/assets/img/backgrounds/18.jpg');
            background-size: cover;
            background-position: center;
            color: #fff;
            position: relative;
        }
        
        .hero-content {
            z-index: 1;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .hero-text {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            max-width: 600px;
        }
        
        .section-title {
            position: relative;
            margin-bottom: 3rem;
            font-weight: 700;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            width: 100px;
            height: 3px;
            bottom: -15px;
            left: 0;
            background-color: var(--primary-color);
        }
        
        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        
        .footer {
            background-color: #2c3e50;
            color: #fff;
            padding: 4rem 0;
        }
        
        .footer-title {
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        .footer-links a {
            color: #ddd;
            text-decoration: none;
            transition: all 0.3s ease;
            display: block;
            margin-bottom: 0.8rem;
        }
        
        .footer-links a:hover {
            color: var(--secondary-color);
            transform: translateX(5px);
        }
        
        .social-icons a {
            color: #fff;
            font-size: 1.5rem;
            margin-right: 1rem;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            color: var(--secondary-color);
            transform: translateY(-5px);
        }
        
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: #fff;
            text-align: center;
            line-height: 40px;
            z-index: 99;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .navbar {
                background-color: #fff !important;
                padding: 0.5rem 1rem;
                box-shadow: 0 3px 10px rgba(0,0,0,0.15);
            }
            
            .navbar-brand {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <?= $this->include('landing/navbar') ?>
    
    <!-- Main Content -->
    <?= $this->renderSection('content') ?>
    
    <!-- Footer -->
    <?= $this->include('landing/footer') ?>
    
    <!-- Back to Top Button -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-chevron-up"></i>
    </a>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
        
        // Navbar scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
            
            // Back to top button
            const backToTop = document.getElementById('backToTop');
            if (window.scrollY > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });
        
        // Back to top smooth scroll
        document.getElementById('backToTop').addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Smooth scroll for all anchors
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
    
    <!-- Render additional scripts from content section -->
    <?= $this->renderSection('scripts') ?>
</body>
</html> 