<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false]);
    exit;
}

$to      = "itsme@anthonymeszaros.com";
$subject = "New Quote Request — Electrical Buddy";

$name    = strip_tags(trim($_POST['name']    ?? ''));
$phone   = strip_tags(trim($_POST['phone']   ?? ''));
$email   = strip_tags(trim($_POST['email']   ?? ''));
$time    = strip_tags(trim($_POST['time']    ?? 'Not specified'));
$notes   = strip_tags(trim($_POST['notes']   ?? 'None'));
$service = strip_tags(trim($_POST['service'] ?? ''));
$homeType= strip_tags(trim($_POST['homeType']?? ''));
$homeAge = strip_tags(trim($_POST['homeAge'] ?? ''));
$priceLo = strip_tags(trim($_POST['priceLo'] ?? ''));
$priceHi = strip_tags(trim($_POST['priceHi'] ?? ''));
$details = strip_tags(trim($_POST['details'] ?? ''));

$body  = "New quote request from electricalbuddy.ca\n";
$body .= str_repeat("=", 46) . "\n\n";

$body .= "CONTACT INFO\n";
$body .= "Name:       $name\n";
$body .= "Phone:      $phone\n";
$body .= "Email:      $email\n";
$body .= "Best Time:  $time\n\n";

$body .= "QUOTE DETAILS\n";
$body .= "Service:    $service\n";
$body .= "Details:    $details\n";
$body .= "Home Type:  $homeType\n";
$body .= "Home Age:   $homeAge\n";
$body .= "Estimate:   \$$priceLo – \$$priceHi\n\n";

$body .= "NOTES\n";
$body .= "$notes\n";

$headers  = "From: Electrical Buddy <noreply@electricalbuddy.ca>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$sent = mail($to, $subject, $body, $headers);

header('Content-Type: application/json');
echo json_encode(['success' => $sent]);
