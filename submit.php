<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // $name = $_POST['name'];
    // $email = $_POST['email'];
    // $file = $_FILES['file'];
    // $comment = $_POST['comment'];
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $batch = isset($_POST['batch']) ? $_POST['batch'] : '';
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';
    $file = isset($_FILES['file']) ? $_FILES['file'] : '';


    // Temporary file path
    $filePath = 'uploads/' . basename($file['name']);

    // Save the file
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        // Send the email
        if (send_email($name, $email,$batch,$comment, $filePath)) {
            echo 'Form submitted successfully!';
        } else {
            echo 'Failed to send email.';
        }

        // Remove the file after sending email
        unlink($filePath);
    } else {
        echo 'Failed to upload file.';
    }
}

function send_email($name, $email,$batch,$comment, $filePath) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'fahadtutorial20@gmail.com';
        $mail->Password = 'kqol oocv oxaa kjeg'; // Use the app-specific password here
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('your_email@gmail.com', 'Mailer');
        $mail->addAddress('your_email@gmail.com', 'Your Name');

        // Attachments
        $mail->addAttachment($filePath);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Form Submission';
        $mail->Body    = "Name: $name<br>Email: $email<br>Batch:$batch<br>Problem:$comment" ;
        $mail->AltBody = "Name: $name\nEmail: $email";

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}
?>
