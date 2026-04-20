<?php
session_start();

$message = "";
$show_splash = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $show_splash = true;

    // GET session variable named confirmation
    $session_confirmation = $_SESSION["confirmation"] ?? null;

    // Retrieve POST value named confirmation
    $post_confirmation = $_POST["confirmation"] ?? null;

    // Ensure session variable and POST confirmation are equal
    if ($session_confirmation !== null && $session_confirmation === $post_confirmation) {
        // Token matched — now check credentials
        $username = $_POST["username"] ?? "";
        $password = $_POST["password"] ?? "";

        if ($username === "host" && $password === "pass") {
            $message = "✅ Login successful! CSRF token validated. Welcome, host.";
            $success = true;
        } else {
            $message = "❌ Invalid credentials.";
            $success = false;
        }
    } else {
        // Token mismatch — likely a CSRF attack
        $message = "🚫 CSRF token mismatch! Request rejected.";
        $success = false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CSRF Mitigated - Action</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px; margin: 60px auto; padding: 20px; }
        #splash { display: <?php echo $show_splash ? 'block' : 'none'; ?>;
                  padding: 12px; margin-top: 16px; border-radius: 4px;
                  background: <?php echo (isset($success) && $success) ? '#d4edda' : '#f8d7da'; ?>;
                  color: <?php echo (isset($success) && $success) ? '#155724' : '#721c24'; ?>; }
    </style>
</head>
<body>
    <h2>CSRF Action Handler</h2>
    <div id="splash"><?php echo htmlspecialchars($message); ?></div>
    <?php if (!$show_splash): ?>
        <p>This page handles form submissions from <a href="csfr_form.php">csfr_form.php</a>.</p>
    <?php endif; ?>
</body>
</html>
