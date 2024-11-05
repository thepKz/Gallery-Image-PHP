<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/autoload.php';
require_once 'config.php';

function sendEmailNotification($to, $template, $data) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        // Recipients
        $mail->setFrom(ADMIN_EMAIL, SITE_NAME);
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        
        switch($template) {
            case 'registration':
                $mail->Subject = 'Xác nhận đăng ký khóa học';
                $mail->Body = getEmailTemplate('registration', $data);
                break;
            case 'payment':
                $mail->Subject = 'Xác nhận thanh toán';
                $mail->Body = getEmailTemplate('payment', $data);
                break;
        }

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email sending failed: {$mail->ErrorInfo}");
        return false;
    }
}

function getEmailTemplate($template, $data) {
    ob_start();
    include "email-templates/{$template}.php";
    return ob_get_clean();
} 