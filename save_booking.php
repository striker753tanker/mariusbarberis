<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Validate input
if (!isset($data['date'], $data['time'], $data['purpose'], $data['name'], $data['email'])) {
    echo json_encode(['success' => false, 'error' => 'Missing fields']);
    exit;
}

// Format appointment
$appointment = [
    'date' => $data['date'],
    'time' => $data['time'],
    'purpose' => $data['purpose'],
    'name' => $data['name'],
    'email' => $data['email'],
    'timestamp' => date("Y-m-d H:i:s")
];

// Save to JSON
$file = 'appointments.json';
$appointments = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
$appointments[] = $appointment;
file_put_contents($file, json_encode($appointments, JSON_PRETTY_PRINT));

// Send email
$mail = new PHPMailer(true);
try {
    // SMTP config (use Gmail SMTP here)
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'your.email@gmail.com';        // 🔁 replace with your Gmail
    $mail->Password = 'your-app-password';           // 🔁 app password (see note below)
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Email content
    $mail->setFrom('your.email@gmail.com', 'Barberis Marius');
    $mail->addAddress('your.email@gmail.com');       // 🔁 where notifications go
    $mail->Subject = 'Nauja rezervacija';
    $mail->Body =
        "Nauja rezervacija:\n\n" .
        "Vardas: {$data['name']}\n" .
        "El. paštas: {$data['email']}\n" .
        "Data: {$data['date']}\n" .
        "Laikas: {$data['time']}\n" .
        "Paslauga: {$data['purpose']}\n";

    $mail->send();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $mail->ErrorInfo]);
}
?>
