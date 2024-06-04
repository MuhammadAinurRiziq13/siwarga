<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php'; // Sesuaikan dengan struktur direktori Anda

function sendEmail($name, $email, $subject, $message, $to = 'siwargaa5@gmail.com') {
    $mail = new PHPMailer(true);
    try {
        // Pengaturan server SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'siwargaa5@gmail.com'; // Ganti dengan alamat email Anda
        $mail->Password   = 'undnbasxzrfurvsp';    // Ganti dengan App Password Anda
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Pengaturan email
        $mail->setFrom($email, $name);
        $mail->addAddress($to); // Ganti dengan alamat email tujuan

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "<h1>$subject</h1><p>$message</p>";
        $mail->AltBody = $message;

        $mail->send();
        return ['status' => 'success', 'message' => 'Your message has been sent. Thank you!'];
    } catch (Exception $e) {
        return ['status' => 'error', 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $result = sendEmail($name, $email, $subject, $message);

    // Logging untuk debugging
    error_log(print_r($result, true));

    header('Content-Type: application/json');
    echo json_encode($result);
}
?>
