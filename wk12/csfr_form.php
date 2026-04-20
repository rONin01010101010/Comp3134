<?php
session_start();

// Create a PHP session variable called confirmation with a random value
$_SESSION["confirmation"] = bin2hex(random_bytes(16));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CSRF Mitigated - Login Form</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px; margin: 60px auto; padding: 20px; }
        input { display: block; width: 100%; margin: 8px 0; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 20px; background: #28a745; color: white; border: none; cursor: pointer; width: 100%; }
        button:hover { background: #1e7e34; }
    </style>
</head>
<body>
    <h2>Login (CSRF Protected)</h2>
    <form method="POST" action="csfr_action.php">
        <label>Username:</label>
        <input type="text" name="username" placeholder="Enter username" />
        <label>Password:</label>
        <input type="password" name="password" placeholder="Enter password" />

        <!-- Hidden field carrying the CSRF token (session confirmation value) -->
        <input type="hidden" name="confirmation" value="<?php echo $_SESSION['confirmation']; ?>" />

        <button type="submit">Login</button>
    </form>
</body>
</html>
