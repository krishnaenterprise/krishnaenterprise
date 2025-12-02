<?php
// Simple admin page to view messages
// IMPORTANT: Add password protection in production!

$password = 'krishna2024'; // Change this password!

session_start();

// Simple authentication
if (!isset($_SESSION['authenticated'])) {
    if (isset($_POST['password']) && $_POST['password'] === $password) {
        $_SESSION['authenticated'] = true;
    } else {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Admin Login - Krishna Enterprise</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                    background: #f5f5f5;
                }
                .login-box {
                    background: white;
                    padding: 2rem;
                    border-radius: 8px;
                    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                }
                input {
                    padding: 0.75rem;
                    width: 250px;
                    margin: 0.5rem 0;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                }
                button {
                    padding: 0.75rem 2rem;
                    background: #000;
                    color: white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    width: 100%;
                }
                button:hover {
                    background: #333;
                }
            </style>
        </head>
        <body>
            <div class="login-box">
                <h2>Admin Login</h2>
                <form method="POST">
                    <input type="password" name="password" placeholder="Enter password" required>
                    <button type="submit">Login</button>
                </form>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: view-messages.php');
    exit;
}

// Read messages
$dbFile = 'messages.json';
$messages = [];
if (file_exists($dbFile)) {
    $content = file_get_contents($dbFile);
    $messages = json_decode($content, true) ?? [];
}

// Sort by newest first
$messages = array_reverse($messages);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact Messages - Krishna Enterprise</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 2rem;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .header {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #000;
        }
        .stats {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            flex: 1;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #000;
        }
        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }
        .message-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .message-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }
        .message-info {
            flex: 1;
        }
        .message-name {
            font-size: 1.25rem;
            font-weight: bold;
            color: #000;
            margin-bottom: 0.25rem;
        }
        .message-contact {
            color: #666;
            font-size: 0.9rem;
        }
        .message-time {
            color: #999;
            font-size: 0.85rem;
        }
        .message-product {
            display: inline-block;
            background: #000;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }
        .message-body {
            color: #333;
            line-height: 1.6;
            padding: 1rem;
            background: #f9f9f9;
            border-radius: 4px;
        }
        .logout-btn {
            padding: 0.75rem 1.5rem;
            background: #dc2626;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .logout-btn:hover {
            background: #b91c1c;
        }
        .no-messages {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 8px;
            color: #666;
        }
        .contact-actions {
            margin-top: 1rem;
            display: flex;
            gap: 1rem;
        }
        .action-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-block;
        }
        .whatsapp-btn {
            background: #25D366;
            color: white;
        }
        .email-btn {
            background: #0066cc;
            color: white;
        }
        .whatsapp-btn:hover {
            background: #128C7E;
        }
        .email-btn:hover {
            background: #0052a3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📬 Contact Messages</h1>
            <a href="?logout=1" class="logout-btn">Logout</a>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?php echo count($messages); ?></div>
                <div class="stat-label">Total Messages</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?php 
                    $today = date('Y-m-d');
                    $todayCount = count(array_filter($messages, function($m) use ($today) {
                        return strpos($m['timestamp'], $today) === 0;
                    }));
                    echo $todayCount;
                    ?>
                </div>
                <div class="stat-label">Today</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?php 
                    $week = date('Y-m-d', strtotime('-7 days'));
                    $weekCount = count(array_filter($messages, function($m) use ($week) {
                        return $m['timestamp'] >= $week;
                    }));
                    echo $weekCount;
                    ?>
                </div>
                <div class="stat-label">This Week</div>
            </div>
        </div>

        <?php if (empty($messages)): ?>
            <div class="no-messages">
                <h2>No messages yet</h2>
                <p>Messages from your contact form will appear here.</p>
            </div>
        <?php else: ?>
            <?php foreach ($messages as $msg): ?>
                <div class="message-card">
                    <div class="message-header">
                        <div class="message-info">
                            <div class="message-name"><?php echo htmlspecialchars($msg['name']); ?></div>
                            <div class="message-contact">
                                📧 <?php echo htmlspecialchars($msg['email']); ?> | 
                                📱 <?php echo htmlspecialchars($msg['phone']); ?>
                            </div>
                            <?php if (!empty($msg['productInterest']) && $msg['productInterest'] !== 'Not specified'): ?>
                                <span class="message-product">🎯 <?php echo htmlspecialchars($msg['productInterest']); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="message-time">
                            <?php echo date('M d, Y - h:i A', strtotime($msg['timestamp'])); ?>
                        </div>
                    </div>
                    <div class="message-body">
                        <?php echo nl2br(htmlspecialchars($msg['message'])); ?>
                    </div>
                    <div class="contact-actions">
                        <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $msg['phone']); ?>" 
                           target="_blank" 
                           class="action-btn whatsapp-btn">
                            💬 WhatsApp
                        </a>
                        <a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>" 
                           class="action-btn email-btn">
                            ✉️ Email Reply
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
