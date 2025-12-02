<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get form data
$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
if (empty($data['name']) || empty($data['email']) || empty($data['phone']) || empty($data['message'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields']);
    exit;
}

// Sanitize input
$name = htmlspecialchars(trim($data['name']));
$email = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);
$phone = htmlspecialchars(trim($data['phone']));
$productInterest = htmlspecialchars(trim($data['productInterest'] ?? 'Not specified'));
$message = htmlspecialchars(trim($data['message']));

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit;
}

// Create submission object
$submission = [
    'id' => uniqid('msg_', true),
    'timestamp' => date('Y-m-d H:i:s'),
    'name' => $name,
    'email' => $email,
    'phone' => $phone,
    'productInterest' => $productInterest,
    'message' => $message,
    'ip' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
    'userAgent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
];

// Database file
$dbFile = 'messages.json';

// Read existing messages
$messages = [];
if (file_exists($dbFile)) {
    $content = file_get_contents($dbFile);
    $messages = json_decode($content, true) ?? [];
}

// Add new submission
$messages[] = $submission;

// Save to file
if (file_put_contents($dbFile, json_encode($messages, JSON_PRETTY_PRINT))) {
    // Optional: Send email notification
    $to = 'your-email@example.com'; // Replace with your email
    $subject = 'New Contact Form Submission - Krishna Enterprise';
    $emailBody = "New message from Krishna Enterprise website:\n\n";
    $emailBody .= "Name: $name\n";
    $emailBody .= "Email: $email\n";
    $emailBody .= "Phone: $phone\n";
    $emailBody .= "Product Interest: $productInterest\n";
    $emailBody .= "Message:\n$message\n\n";
    $emailBody .= "Submitted: " . date('Y-m-d H:i:s');
    
    $headers = "From: noreply@krishnaenterprise.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    
    // Uncomment to enable email notifications
    // mail($to, $subject, $emailBody, $headers);
    
    echo json_encode([
        'success' => true,
        'message' => 'Thank you for your message! Our team will get back to you within 24 hours.'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to save your message. Please try again or contact us directly.'
    ]);
}
?>
