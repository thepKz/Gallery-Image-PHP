
<main>
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Khóa Học Chuyên Nghiệp</h1>
            <p class="lead">Nâng cao kỹ năng với các khóa học chất lượng</p>
            <a href="#courses" class="btn btn-primary">Xem Khóa Học</a>
        </div>
    </section>

    <!-- Featured Courses -->
    <section id="courses" class="courses">
        <div class="container">
            <h2 class="section-title">Khóa Học Nổi Bật</h2>
            <div class="course-grid">
                <?php foreach($courses as $course): ?>
                <div class="course-card">
                    <div class="course-image">
                        <img src="<?php echo $course['image']; ?>" alt="<?php echo $course['title']; ?>">
                    </div>
                    <div class="course-content">
                        <h3><?php echo $course['title']; ?></h3>
                        <p><?php echo $course['short_desc']; ?></p>
                        <div class="course-meta">
                            <span class="price"><?php echo number_format($course['price']); ?>đ</span>
                            <span class="duration"><?php echo $course['duration']; ?></span>
                        </div>
                        <a href="course-detail.php?id=<?php echo $course['id']; ?>" class="btn btn-outline">Chi Tiết</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Student Works -->
    <section class="student-works">
        <div class="container">
            <h2 class="section-title">Sản Phẩm Học Viên</h2>
            <div class="video-grid">
                <?php foreach($studentWorks as $work): ?>
                <div class="video-item">
                    <div class="video-wrapper">
                        <iframe src="<?php echo $work['video_url']; ?>" 
                                frameborder="0" 
                                allowfullscreen></iframe>
                    </div>
                    <h3><?php echo $work['title']; ?></h3>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Registration Form -->
    <section class="registration">
        <div class="container">
            <h2 class="section-title">Đăng Ký Khóa Học</h2>
            <form id="registrationForm" class="registration-form">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Họ và tên" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="tel" name="phone" placeholder="Số điện thoại" required>
                </div>
                <div class="form-group">
                    <select name="course_id" required>
                        <option value="">Chọn khóa học</option>
                        <?php foreach($courses as $course): ?>
                        <option value="<?php echo $course['id']; ?>"><?php echo $course['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Đăng Ký Ngay</button>
            </form>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>