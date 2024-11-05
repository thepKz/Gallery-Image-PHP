<?php
require_once 'config.php';
require_once 'database.php';

// Validate form data
function validateForm($data) {
    $errors = [];
    
    if(empty($data['name'])) {
        $errors[] = 'Họ tên không được để trống';
    }
    
    if(empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email không hợp lệ';
    }
    
    if(empty($data['phone']) || !preg_match('/^[0-9]{10}$/', $data['phone'])) {
        $errors[] = 'Số điện thoại không hợp lệ';
    }
    
    if(empty($data['course_id'])) {
        $errors[] = 'Vui lòng chọn khóa học';
    }
    
    return $errors;
}

// Register student
function registerStudent($data) {
    global $db;
    return $db->insert('registrations', [
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'course_id' => $data['course_id'],
        'status' => 'pending',
        'created_at' => date('Y-m-d H:i:s')
    ]);
}

// Get course by ID
function getCourse($id) {
    global $db;
    $result = $db->select("SELECT * FROM courses WHERE id = ?", [$id]);
    return $result ? $result[0] : null;
}

// Get all courses
function getCourses() {
    global $db;
    return $db->select("SELECT * FROM courses WHERE status = 'active' ORDER BY created_at DESC");
}

// Upload image
function uploadImage($file, $path = 'uploads/images/') {
    $uploader = new FileUploader($path);
    return $uploader->upload($file);
} 