<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StyleFashion - Thời Trang Hiện Đại</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        :root {
            --primary: #e74c3c;
            --primary-dark: #c0392b;
            --secondary: #2c3e50;
            --light: #f9f9f9;
            --dark: #333;
            --gray: #777;
            --light-gray: #eee;
        }

        body {
            line-height: 1.6;
            color: var(--dark);
            background-color: var(--light);
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Header */
        header {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .top-bar {
            background-color: var(--secondary);
            color: white;
            padding: 8px 0;
            font-size: 14px;
        }

        .top-bar-content {
            display: flex;
            justify-content: space-between;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .logo i {
            margin-right: 10px;
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links li {
            margin-left: 25px;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background-color: var(--primary);
            bottom: -5px;
            left: 0;
            transition: width 0.3s;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .nav-icons {
            display: flex;
            align-items: center;
        }

        .nav-icon {
            margin-left: 20px;
            font-size: 20px;
            color: var(--dark);
            cursor: pointer;
            transition: color 0.3s;
            position: relative;
        }

        .nav-icon:hover {
            color: var(--primary);
        }

        .user-dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: #fff;
            min-width: 200px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1001;
            list-style: none;
            padding: 10px 0;
        }

        .user-dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu li {
            margin: 0;
        }

        .dropdown-menu a {
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            color: var(--dark);
            font-size: 14px;
            transition: background-color 0.3s;
            border-bottom: 1px solid var(--light-gray);
        }

        .dropdown-menu a:hover {
            background-color: var(--light-gray);
            color: var(--primary);
        }

        .dropdown-menu a:last-child {
            border-bottom: none;
        }

        .dropdown-menu a i {
            margin-right: 10px;
            width: 16px;
        }

        .cart-count {
            background-color: var(--primary);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: -8px;
            right: -8px;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            height: 90vh;
            display: flex;
            align-items: center;
            color: #fff;
        }

        .hero-content {
            max-width: 600px;
        }

        .hero h1 {
            font-size: 52px;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .btn {
            display: inline-block;
            background-color: var(--primary);
            color: #fff;
            padding: 12px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-outline {
            background-color: transparent;
            border: 2px solid #fff;
            margin-left: 15px;
        }

        .btn-outline:hover {
            background-color: #fff;
            color: var(--dark);
        }

        /* Categories Section */
        .section {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 36px;
            color: var(--dark);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            width: 70px;
            height: 3px;
            background-color: var(--primary);
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .section-title p {
            color: var(--gray);
            max-width: 600px;
            margin: 0 auto;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .category-card {
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            height: 300px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .category-card:hover {
            transform: translateY(-10px);
        }

        .category-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .category-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            color: white;
            padding: 20px;
        }

        .category-content h3 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        /* Featured Products */
        .featured-products {
            background-color: #fff;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
        }

        .product-card {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background-color: var(--primary);
            color: white;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: 600;
            z-index: 2;
        }

        .product-img {
            height: 250px;
            overflow: hidden;
        }

        .product-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .product-card:hover .product-img img {
            transform: scale(1.1);
        }

        .product-info {
            padding: 20px;
        }

        .product-info h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .product-price {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .current-price {
            color: var(--primary);
            font-weight: 700;
            font-size: 18px;
            margin-right: 10px;
        }

        .original-price {
            color: var(--gray);
            text-decoration: line-through;
            font-size: 14px;
        }

        .product-rating {
            color: #ffc107;
            margin-bottom: 15px;
        }

        .product-actions {
            display: flex;
            justify-content: space-between;
        }

        .add-to-cart {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
        }

        .add-to-cart i {
            margin-right: 5px;
        }

        .add-to-cart:hover {
            background-color: var(--primary-dark);
        }

        .wishlist {
            background-color: transparent;
            border: 1px solid var(--light-gray);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .wishlist:hover {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Promo Banner */
        .promo-banner {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1558769132-cb25c5c11cd9?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            padding: 80px 0;
            text-align: center;
            color: white;
        }

        .promo-banner h2 {
            font-size: 42px;
            margin-bottom: 20px;
        }

        .promo-banner p {
            font-size: 18px;
            margin-bottom: 30px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Services Section */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .service-card {
            text-align: center;
            padding: 30px 20px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }

        .service-card:hover {
            transform: translateY(-10px);
        }

        .service-icon {
            font-size: 50px;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .service-card h3 {
            font-size: 22px;
            margin-bottom: 15px;
        }

        .service-card p {
            color: var(--gray);
        }

        /* Newsletter */
        .newsletter {
            background-color: var(--secondary);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .newsletter h2 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .newsletter p {
            max-width: 600px;
            margin: 0 auto 30px;
            opacity: 0.8;
        }

        .newsletter-form {
            display: flex;
            max-width: 500px;
            margin: 0 auto;
        }

        .newsletter-input {
            flex: 1;
            padding: 15px 20px;
            border: none;
            border-radius: 30px 0 0 30px;
            font-size: 16px;
        }

        .newsletter-btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 0 30px;
            border-radius: 0 30px 30px 0;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .newsletter-btn:hover {
            background-color: var(--primary-dark);
        }

        /* Footer */
        footer {
            background-color: #1a1a1a;
            color: #bbb;
            padding: 70px 0 20px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-column h3 {
            color: white;
            font-size: 18px;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            width: 40px;
            height: 2px;
            background-color: var(--primary);
            bottom: 0;
            left: 0;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #bbb;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: #333;
            border-radius: 50%;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .social-links a:hover {
            background-color: var(--primary);
        }

        .contact-info {
            list-style: none;
        }

        .contact-info li {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .contact-info i {
            color: var(--primary);
            margin-right: 10px;
            margin-top: 5px;
        }

        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid #333;
            color: #777;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .nav-links {
                display: none;
            }

            .menu-toggle {
                display: block;
            }

            .hero h1 {
                font-size: 42px;
            }
        }

        @media (max-width: 768px) {
            .hero {
                height: 70vh;
            }

            .hero h1 {
                font-size: 36px;
            }

            .hero p {
                font-size: 16px;
            }

            .section {
                padding: 60px 0;
            }

            .newsletter-form {
                flex-direction: column;
            }

            .newsletter-input {
                border-radius: 30px;
                margin-bottom: 10px;
            }

            .newsletter-btn {
                border-radius: 30px;
                padding: 15px;
            }
        }

        @media (max-width: 576px) {
            .top-bar-content {
                flex-direction: column;
                text-align: center;
            }

            .top-bar-content div {
                margin-bottom: 5px;
            }

            .hero h1 {
                font-size: 32px;
            }

            .btn {
                display: block;
                width: 100%;
                margin-bottom: 10px;
            }

            .btn-outline {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container top-bar-content">
            <div>Chào mừng đến với StyleFashion - Thời trang cho mọi người</div>
            <div>Hotline: 0901 234 567</div>
        </div>
    </div>

    <!-- Header -->
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="#" class="logo">
                    <i class="fas fa-tshirt"></i>
                    StyleFashion
                </a>
                <ul class="nav-links">
                    <li><a href="#" class="active">Trang Chủ</a></li>
                    <li><a href="#">Sản Phẩm</a></li>
                    <li><a href="#">Bộ Sưu Tập</a></li>
                    <li><a href="#">Khuyến Mãi</a></li>
                    <li><a href="#">Về Chúng Tôi</a></li>
                    <li><a href="#">Liên Hệ</a></li>
                </ul>
                <div class="nav-icons">
                    <div class="nav-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    @auth
                        <div class="nav-icon user-dropdown">
                            <i class="fas fa-user"></i>
                            <ul class="dropdown-menu">
                                <li><a href=""><i class="fas fa-user-edit"></i>Thông tin cá nhân</a></li>
                                <li><a href=""><i class="fas fa-history"></i>Lịch sử giao dịch</a></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                            <i class="fas fa-sign-out-alt"></i>Đăng xuất
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <div class="nav-icon">
                            <a href="{{ route('login') }}" style="color: inherit; text-decoration: none;">
                                <i class="fas fa-user"></i>
                            </a>
                        </div>
                    @endauth
                    <div class="nav-icon" style="position: relative;">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count">3</span>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    @yield('content')

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Về StyleFashion</h3>
                    <p>StyleFashion là thương hiệu thời trang hàng đầu với những sản phẩm chất lượng và phong cách hiện
                        đại.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Liên Kết Nhanh</h3>
                    <ul class="footer-links">
                        <li><a href="#">Trang Chủ</a></li>
                        <li><a href="#">Sản Phẩm</a></li>
                        <li><a href="#">Bộ Sưu Tập</a></li>
                        <li><a href="#">Khuyến Mãi</a></li>
                        <li><a href="#">Về Chúng Tôi</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Chính Sách</h3>
                    <ul class="footer-links">
                        <li><a href="#">Chính sách bảo mật</a></li>
                        <li><a href="#">Chính sách vận chuyển</a></li>
                        <li><a href="#">Chính sách đổi trả</a></li>
                        <li><a href="#">Điều khoản dịch vụ</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Thông Tin Liên Hệ</h3>
                    <ul class="contact-info">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>123 Đường ABC, Quận 1, TP. Hồ Chí Minh</span>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <span>Hotline: 0901 234 567</span>
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            <span>contact@stylefashion.vn</span>
                        </li>
                        <li>
                            <i class="fas fa-clock"></i>
                            <span>Giờ mở cửa: 8:00 - 22:00 (T2 - CN)</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2023 StyleFashion. Tất cả các quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>

    <script>
        // Simple script for cart functionality
        document.addEventListener('DOMContentLoaded', function () {
            const addToCartButtons = document.querySelectorAll('.add-to-cart');
            const cartCount = document.querySelector('.cart-count');

            addToCartButtons.forEach(button => {
                button.addEventListener('click', function () {
                    let count = parseInt(cartCount.textContent);
                    count++;
                    cartCount.textContent = count;

                    // Add animation
                    cartCount.style.transform = 'scale(1.5)';
                    setTimeout(() => {
                        cartCount.style.transform = 'scale(1)';
                    }, 300);

                    // Show confirmation (in a real app, this would be more sophisticated)
                    alert('Sản phẩm đã được thêm vào giỏ hàng!');
                });
            });

            // Wishlist functionality
            const wishlistButtons = document.querySelectorAll('.wishlist');

            wishlistButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const icon = this.querySelector('i');
                    if (icon.classList.contains('far')) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        this.style.backgroundColor = 'var(--primary)';
                        this.style.color = 'white';
                        this.style.borderColor = 'var(--primary)';
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        this.style.backgroundColor = 'transparent';
                        this.style.color = '';
                        this.style.borderColor = 'var(--light-gray)';
                    }
                });
            });
        });
    </script>
</body>

</html>