<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StyleFashion - Thời Trang Hiện Đại</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
        }

        /* Header */
        header {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: #e74c3c;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links li {
            margin-left: 30px;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #e74c3c;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            height: 80vh;
            display: flex;
            align-items: center;
            text-align: center;
            color: #fff;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .hero p {
            font-size: 20px;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            background-color: #e74c3c;
            color: #fff;
            padding: 12px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #c0392b;
        }

        /* About Section */
        .section {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 36px;
            color: #333;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            width: 70px;
            height: 3px;
            background-color: #e74c3c;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .about-content {
            display: flex;
            align-items: center;
            gap: 50px;
        }

        .about-text {
            flex: 1;
        }

        .about-text h3 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }

        .about-text p {
            margin-bottom: 15px;
            color: #666;
        }

        .about-image {
            flex: 1;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .about-image img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.5s;
        }

        .about-image:hover img {
            transform: scale(1.05);
        }

        /* Products Section */
        .products {
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
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
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

        .product-info p {
            color: #e74c3c;
            font-weight: 600;
            font-size: 18px;
        }

        /* Services Section */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
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
            transform: translateY(-5px);
        }

        .service-icon {
            font-size: 40px;
            color: #e74c3c;
            margin-bottom: 20px;
        }

        .service-card h3 {
            font-size: 22px;
            margin-bottom: 15px;
        }

        /* Contact Section */
        .contact {
            background-color: #fff;
        }

        .contact-content {
            display: flex;
            gap: 50px;
        }

        .contact-info,
        .contact-form {
            flex: 1;
        }

        .contact-info h3 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .contact-detail {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .contact-icon {
            font-size: 20px;
            color: #e74c3c;
            margin-right: 15px;
            width: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        textarea.form-control {
            height: 150px;
            resize: vertical;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: #fff;
            padding: 50px 0 20px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .footer-column h3 {
            font-size: 18px;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            width: 40px;
            height: 2px;
            background-color: #e74c3c;
            bottom: 0;
            left: 0;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #bbb;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: #e74c3c;
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
            background-color: #444;
            border-radius: 50%;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .social-links a:hover {
            background-color: #e74c3c;
        }

        .copyright {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #444;
            color: #bbb;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                padding: 15px 0;
            }

            .nav-links {
                margin-top: 15px;
            }

            .nav-links li {
                margin: 0 10px;
            }

            .hero h1 {
                font-size: 36px;
            }

            .hero p {
                font-size: 18px;
            }

            .about-content,
            .contact-content {
                flex-direction: column;
            }

            .section {
                padding: 50px 0;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="#" class="logo">StyleFashion</a>
                <ul class="nav-links">
                    <li><a href="#">Trang Chủ</a></li>
                    <li><a href="#about">Giới Thiệu</a></li>
                    <li><a href="#products">Sản Phẩm</a></li>
                    <li><a href="#services">Dịch Vụ</a></li>
                    <li><a href="#contact">Liên Hệ</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Phong Cách Thời Trang Hiện Đại</h1>
                <p>Khám phá bộ sưu tập quần áo mới nhất với thiết kế độc đáo và chất lượng cao</p>
                <a href="#products" class="btn">Mua Sắm Ngay</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section">
        <div class="container">
            <div class="section-title">
                <h2>Về Chúng Tôi</h2>
            </div>
            <div class="about-content">
                <div class="about-text">
                    <h3>StyleFashion - Thương Hiệu Thời Trang Hàng Đầu</h3>
                    <p>Với hơn 10 năm kinh nghiệm trong ngành thời trang, StyleFashion tự hào là điểm đến tin cậy cho
                        những ai yêu thích phong cách thời thượng và chất lượng.</p>
                    <p>Chúng tôi không ngừng cập nhật xu hướng mới nhất từ các thị trường thời trang quốc tế, mang đến
                        cho khách hàng những sản phẩm đẹp mắt, chất lượng cao với giá cả hợp lý.</p>
                    <p>Đội ngũ thiết kế của chúng tôi luôn sáng tạo không ngừng để cho ra đời những bộ sưu tập độc đáo,
                        phù hợp với nhiều phong cách và lứa tuổi khác nhau.</p>
                    <a href="#contact" class="btn">Liên Hệ Ngay</a>
                </div>
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                        alt="Về chúng tôi">
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="section products">
        <div class="container">
            <div class="section-title">
                <h2>Sản Phẩm Nổi Bật</h2>
            </div>
            <div class="product-grid">
                <div class="product-card">
                    <div class="product-img">
                        <img src="https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80"
                            alt="Áo thun nam">
                    </div>
                    <div class="product-info">
                        <h3>Áo Thun Nam Cao Cấp</h3>
                        <p>350.000 VNĐ</p>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-img">
                        <img src="https://images.unsplash.com/photo-1581044777550-4cfa60707c03?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80"
                            alt="Đầm dự tiệc">
                    </div>
                    <div class="product-info">
                        <h3>Đầm Dự Tiệc Sang Trọng</h3>
                        <p>1.200.000 VNĐ</p>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-img">
                        <img src="https://images.unsplash.com/photo-1582418702059-97ebafb35d09?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                            alt="Quần jeans nữ">
                    </div>
                    <div class="product-info">
                        <h3>Quần Jeans Nữ Form Slim</h3>
                        <p>550.000 VNĐ</p>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-img">
                        <img src="https://images.unsplash.com/photo-1595777457583-95e059d581b8?ixlib=rb-1.2.1&auto=format&fit=crop&w=700&q=80"
                            alt="Áo khoác nam">
                    </div>
                    <div class="product-info">
                        <h3>Áo Khoác Nam Phong Cách</h3>
                        <p>850.000 VNĐ</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="section">
        <div class="container">
            <div class="section-title">
                <h2>Dịch Vụ Của Chúng Tôi</h2>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">🚚</div>
                    <h3>Giao Hàng Miễn Phí</h3>
                    <p>Miễn phí giao hàng toàn quốc cho đơn hàng từ 500.000 VNĐ</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">↩️</div>
                    <h3>Đổi Trả Dễ Dàng</h3>
                    <p>Chính sách đổi trả linh hoạt trong vòng 7 ngày</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">💳</div>
                    <h3>Thanh Toán An Toàn</h3>
                    <p>Hỗ trợ nhiều phương thức thanh toán an toàn và tiện lợi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section contact">
        <div class="container">
            <div class="section-title">
                <h2>Liên Hệ Với Chúng Tôi</h2>
            </div>
            <div class="contact-content">
                <div class="contact-info">
                    <h3>Thông Tin Liên Hệ</h3>
                    <div class="contact-detail">
                        <div class="contact-icon">📍</div>
                        <p>123 Đường ABC, Quận 1, TP. Hồ Chí Minh</p>
                    </div>
                    <div class="contact-detail">
                        <div class="contact-icon">📞</div>
                        <p>Hotline: 0901 234 567</p>
                    </div>
                    <div class="contact-detail">
                        <div class="contact-icon">✉️</div>
                        <p>Email: contact@stylefashion.vn</p>
                    </div>
                    <div class="contact-detail">
                        <div class="contact-icon">🕒</div>
                        <p>Giờ mở cửa: 8:00 - 22:00 (T2 - CN)</p>
                    </div>
                </div>
                <div class="contact-form">
                    <form>
                        <div class="form-group">
                            <label for="name">Họ và Tên</label>
                            <input type="text" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Số Điện Thoại</label>
                            <input type="tel" id="phone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Nội Dung</label>
                            <textarea id="message" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn">Gửi Tin Nhắn</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Về StyleFashion</h3>
                    <p>StyleFashion là thương hiệu thời trang hàng đầu với những sản phẩm chất lượng và phong cách hiện
                        đại.</p>
                    <div class="social-links">
                        <a href="#"><span>FB</span></a>
                        <a href="#"><span>IG</span></a>
                        <a href="#"><span>TW</span></a>
                        <a href="#"><span>YT</span></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Liên Kết Nhanh</h3>
                    <ul class="footer-links">
                        <li><a href="#">Trang Chủ</a></li>
                        <li><a href="#about">Giới Thiệu</a></li>
                        <li><a href="#products">Sản Phẩm</a></li>
                        <li><a href="#services">Dịch Vụ</a></li>
                        <li><a href="#contact">Liên Hệ</a></li>
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
                    <h3>Đăng Ký Nhận Tin</h3>
                    <p>Đăng ký để nhận thông tin về sản phẩm mới và khuyến mãi</p>
                    <form>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Nhập email của bạn" required>
                        </div>
                        <button type="submit" class="btn">Đăng Ký</button>
                    </form>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2023 StyleFashion. Tất cả các quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>
</body>

</html>