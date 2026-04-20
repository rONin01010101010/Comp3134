<?php
$message = "";
$show_splash = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $show_splash = true;
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    if ($username === "host" && $password === "pass") {
        $message = "✅ Login successful! Welcome, host.";
        $success = true;
    } else {
        $message = "❌ Login failed. Invalid credentials.";
        $success = false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CSRF Demo - Login</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px; margin: 60px auto; padding: 20px; }
        input { display: block; width: 100%; margin: 8px 0; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; width: 100%; }
        button:hover { background: #0056b3; }
        #splash { display: <?php echo $show_splash ? 'block' : 'none'; ?>;
                  padding: 12px; margin-top: 16px; border-radius: 4px;
                  background: <?php echo (isset($success) && $success) ? '#d4edda' : '#f8d7da'; ?>;
                  color: <?php echo (isset($success) && $success) ? '#155724' : '#721c24'; ?>; }
    </style>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="csfr.php">
        <label>Username:</label>
        <input type="text" name="username" placeholder="Enter username" />
        <label>Password:</label>
        <input type="password" name="password" placeholder="Enter password" />
        <button type="submit">Login</button>
    </form>
    <div id="splash"><?php echo htmlspecialchars($message); ?></div>
</body>
</html>
