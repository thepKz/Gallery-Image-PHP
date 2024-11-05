<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    $data = [
        'name' => $_POST['name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'course_id' => $_POST['course_id'] ?? ''
    ];

    // Validate form
    $errors = validateForm($data);
    if (!empty($errors)) {
        throw new Exception(implode(', ', $errors));
    }

    // Register student
    $registration_id = registerStudent($data);

    // Send email notification
    sendEmailNotification($data['email'], 'registration', [
        'name' => $data['name'],
        'course' => getCourse($data['course_id'])['title']
    ]);

    echo json_encode([
        'success' => true,
        'registration_id' => $registration_id,
        'message' => 'Đăng ký thành công!'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 