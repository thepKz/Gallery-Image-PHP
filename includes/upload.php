<?php
class FileUploader {
    private $uploadPath;
    private $allowedTypes;
    private $maxSize;

    public function __construct($uploadPath = 'uploads/', $maxSize = 5242880) {
        $this->uploadPath = $uploadPath;
        $this->maxSize = $maxSize;
        $this->allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    }

    public function upload($file, $newFileName = null) {
        try {
            if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
                throw new Exception('No file uploaded');
            }

            // Check file size
            if ($file['size'] > $this->maxSize) {
                throw new Exception('File too large');
            }

            // Check file type
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $this->allowedTypes)) {
                throw new Exception('Invalid file type');
            }

            // Generate unique filename
            $fileName = $newFileName ?? uniqid() . '.' . $ext;
            $destination = $this->uploadPath . $fileName;

            // Create directory if not exists
            if (!is_dir($this->uploadPath)) {
                mkdir($this->uploadPath, 0777, true);
            }

            // Move uploaded file
            if (!move_uploaded_file($file['tmp_name'], $destination)) {
                throw new Exception('Failed to move uploaded file');
            }

            return $fileName;

        } catch (Exception $e) {
            error_log("Upload error: " . $e->getMessage());
            throw $e;
        }
    }
} 