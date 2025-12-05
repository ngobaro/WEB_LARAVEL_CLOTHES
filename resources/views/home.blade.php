@extends('layouts.app')


@section('title','StyleFashion - Thời Trang Hiện Đại')


@section('content')

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Phong Cách Mới Cho Cuộc Sống Hiện Đại</h1>
                <p>Khám phá bộ sưu tập quần áo mới nhất với thiết kế độc đáo, chất liệu cao cấp và giá cả hợp lý. Thể
                    hiện phong cách riêng của bạn!</p>
                <a href="#" class="btn">Mua Sắm Ngay</a>
                <a href="#" class="btn btn-outline">Khám Phá Bộ Sưu Tập</a>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="section">
        <div class="container">
            <div class="section-title">
                <h2>Danh Mục Sản Phẩm</h2>
                <p>Khám phá các danh mục sản phẩm đa dạng của chúng tôi</p>
            </div>
            <div class="categories-grid">
                <div class="category-card">
                    <img src="https://images.unsplash.com/photo-1595777457583-95e059d581b8?ixlib=rb-1.2.1&auto=format&fit=crop&w=700&q=80"
                        alt="Thời trang nam" class="category-img">
                    <div class="category-content">
                        <h3>Thời Trang Nam</h3>
                        <p>Khám phá ngay</p>
                    </div>
                </div>
                <div class="category-card">
                    <img src="https://images.unsplash.com/photo-1581044777550-4cfa60707c03?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80"
                        alt="Thời trang nữ" class="category-img">
                    <div class="category-content">
                        <h3>Thời Trang Nữ</h3>
                        <p>Khám phá ngay</p>
                    </div>
                </div>
                <div class="category-card">
                    <img src="https://images.unsplash.com/photo-1582418702059-97ebafb35d09?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                        alt="Phụ kiện" class="category-img">
                    <div class="category-content">
                        <h3>Phụ Kiện</h3>
                        <p>Khám phá ngay</p>
                    </div>
                </div>
                <div class="category-card">
                    <img src="https://images.unsplash.com/photo-1556821840-3a63f95609a7?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80"
                        alt="Giảm giá" class="category-img">
                    <div class="category-content">
                        <h3>Khuyến Mãi</h3>
                        <p>Khám phá ngay</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="section featured-products">
        <div class="container">
            <div class="section-title">
                <h2>Sản Phẩm Nổi Bật</h2>
                <p>Những sản phẩm được yêu thích nhất tại cửa hàng</p>
            </div>
            <div class="product-grid">
                <div class="product-card">
                    <div class="product-badge">Giảm 20%</div>
                    <div class="product-img">
                        <img src="https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80"
                            alt="Áo thun nam">
                    </div>
                    <div class="product-info">
                        <h3>Áo Thun Nam Cao Cấp</h3>
                        <div class="product-price">
                            <span class="current-price">350.000 VNĐ</span>
                            <span class="original-price">450.000 VNĐ</span>
                        </div>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <div class="product-actions">
                            <button class="add-to-cart">
                                <i class="fas fa-shopping-cart"></i> Thêm Vào Giỏ
                            </button>
                            <button class="wishlist">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-badge">Mới</div>
                    <div class="product-img">
                        <img src="https://images.unsplash.com/photo-1581044777550-4cfa60707c03?ixlib=rb-1.2.1&auto=format&fit=crop&w=634&q=80"
                            alt="Đầm dự tiệc">
                    </div>
                    <div class="product-info">
                        <h3>Đầm Dự Tiệc Sang Trọng</h3>
                        <div class="product-price">
                            <span class="current-price">1.200.000 VNĐ</span>
                        </div>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <div class="product-actions">
                            <button class="add-to-cart">
                                <i class="fas fa-shopping-cart"></i> Thêm Vào Giỏ
                            </button>
                            <button class="wishlist">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-img">
                        <img src="https://images.unsplash.com/photo-1582418702059-97ebafb35d09?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                            alt="Quần jeans nữ">
                    </div>
                    <div class="product-info">
                        <h3>Quần Jeans Nữ Form Slim</h3>
                        <div class="product-price">
                            <span class="current-price">550.000 VNĐ</span>
                        </div>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="product-actions">
                            <button class="add-to-cart">
                                <i class="fas fa-shopping-cart"></i> Thêm Vào Giỏ
                            </button>
                            <button class="wishlist">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-badge">Bán Chạy</div>
                    <div class="product-img">
                        <img src="https://images.unsplash.com/photo-1595777457583-95e059d581b8?ixlib=rb-1.2.1&auto=format&fit=crop&w=700&q=80"
                            alt="Áo khoác nam">
                    </div>
                    <div class="product-info">
                        <h3>Áo Khoác Nam Phong Cách</h3>
                        <div class="product-price">
                            <span class="current-price">850.000 VNĐ</span>
                        </div>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <div class="product-actions">
                            <button class="add-to-cart">
                                <i class="fas fa-shopping-cart"></i> Thêm Vào Giỏ
                            </button>
                            <button class="wishlist">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div style="text-align: center; margin-top: 40px;">
                <a href="#" class="btn">Xem Tất Cả Sản Phẩm</a>
            </div>
        </div>
    </section>

    <!-- Promo Banner -->
    <section class="promo-banner">
        <div class="container">
            <h2>Giảm Giá Lên Đến 50%</h2>
            <p>Đừng bỏ lỡ cơ hội mua sắm với mức giá tốt nhất trong năm. Ưu đãi chỉ có trong tháng này!</p>
            <a href="#" class="btn">Mua Ngay</a>
        </div>
    </section>

    <!-- Services Section -->
    <section class="section">
        <div class="container">
            <div class="section-title">
                <h2>Dịch Vụ Của Chúng Tôi</h2>
                <p>Chúng tôi cam kết mang đến trải nghiệm mua sắm tốt nhất cho khách hàng</p>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h3>Giao Hàng Miễn Phí</h3>
                    <p>Miễn phí giao hàng toàn quốc cho đơn hàng từ 500.000 VNĐ</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-undo-alt"></i>
                    </div>
                    <h3>Đổi Trả Dễ Dàng</h3>
                    <p>Chính sách đổi trả linh hoạt trong vòng 7 ngày</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3>Thanh Toán An Toàn</h3>
                    <p>Hỗ trợ nhiều phương thức thanh toán an toàn và tiện lợi</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Hỗ Trợ 24/7</h3>
                    <p>Đội ngũ hỗ trợ khách hàng luôn sẵn sàng giải đáp mọi thắc mắc</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter">
        <div class="container">
            <h2>Đăng Ký Nhận Tin</h2>
            <p>Đăng ký ngay để nhận thông tin về sản phẩm mới, khuyến mãi đặc biệt và nhiều ưu đãi hấp dẫn khác</p>
            <form class="newsletter-form">
                <input type="email" class="newsletter-input" placeholder="Nhập địa chỉ email của bạn" required>
                <button type="submit" class="newsletter-btn">Đăng Ký</button>
            </form>
        </div>
    </section>
@endsection