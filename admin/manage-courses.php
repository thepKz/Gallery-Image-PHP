<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/upload.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$uploader = new FileUploader('../uploads/courses/');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'duration' => $_POST['duration'],
            'status' => $_POST['status']
        ];

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $fileName = $uploader->upload($_FILES['image']);
            $data['image'] = $fileName;
        }

        if (isset($_POST['id'])) {
            // Update existing course
            $id = $_POST['id'];
            $db->update('courses', $data, ['id' => $id]);
            $message = 'Cập nhật khóa học thành công!';
        } else {
            // Create new course
            $db->insert('courses', $data);
            $message = 'Thêm khóa học thành công!';
        }

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Get all courses
$courses = $db->select("SELECT * FROM courses ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý khóa học</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="main-content">
            <h1>Quản lý khóa học</h1>
            
            <?php if (isset($message)): ?>
                <div class="alert alert-success"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" enctype="multipart/form-data" class="course-form">
                <div class="form-group">
                    <input type="text" name="title" placeholder="Tên khóa học" required>
                </div>
                <div class="form-group">
                    <textarea name="description" placeholder="Mô tả" required></textarea>
                </div>
                <div class="form-group">
                    <input type="number" name="price" placeholder="Giá" required>
                </div>
                <div class="form-group">
                    <input type="text" name="duration" placeholder="Thời lượng">
                </div>
                <div class="form-group">
                    <input type="file" name="image" accept="image/*">
                </div>
                <div class="form-group">
                    <select name="status">
                        <option value="active">Hoạt động</option>
                        <option value="inactive">Tạm ẩn</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Thêm khóa học</button>
            </form>
            
            <table class="courses-table">
                <thead>
                    <tr>
                        <th>Tên khóa học</th>
                        <th>Giá</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($courses as $course): ?>
                    <tr>
                        <td><?php echo $course['title']; ?></td>
                        <td><?php echo number_format($course['price']); ?>đ</td>
                        <td><?php echo $course['status']; ?></td>
                        <td>
                            <a href="edit-course.php?id=<?php echo $course['id']; ?>" 
                               class="btn btn-small">Sửa</a>
                            <a href="delete-course.php?id=<?php echo $course['id']; ?>" 
                               class="btn btn-small btn-danger" 
                               onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
    
    <script src="../assets/js/admin.js"></script>
</body>
</html> 