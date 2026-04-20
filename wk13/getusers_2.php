<?php
// Database configuration — update these values to match your droplet
$db_host = "localhost";
$db_user = "root";
$db_pass = "1f7d9df4cf27634fee8a46d95486b35878defb32e50b064b";;  // Replace with your actual MySQL password
$db_name = "comp3134";          // Replace with your schema name

$results = [];
$query_value = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["firstname"]) && $_GET["firstname"] !== "") {
    $query_value = $_GET["firstname"];

    // Connect to database
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        $error = "Connection failed: " . $conn->connect_error;
    } else {
        // MITIGATED — using prepared statements with bound parameters
        // The ? placeholder ensures user input is NEVER interpreted as SQL syntax
        $stmt = $conn->prepare(
            "SELECT id, username, email, firstname, lastname, active 
             FROM users 
             WHERE firstname = ? AND active = 1"
        );

        if ($stmt) {
            // Bind the user input as a string parameter
            $stmt->bind_param("s", $query_value);
            $stmt->execute();

            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $results[] = $row;
            }

            $stmt->close();
        } else {
            $error = "Prepare failed: " . $conn->error;
        }

        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Get Users (Mitigated)</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 40px auto; padding: 20px; }
        input[type="text"] { padding: 8px; width: 250px; }
        button { padding: 8px 16px; background: #28a745; color: white; border: none; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #f0f0f0; }
        .error { color: red; margin-top: 10px; }
        .safe { background: #d4edda; padding: 10px; border-left: 4px solid #28a745; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>User Search (Mitigated — Prepared Statements)</h1>
    <div class="safe">✅ This page uses prepared statements to prevent SQL injection.</div>

    <form method="GET" action="getusers_2.php">
        <label for="firstname">Search by First Name:</label><br><br>
        <input type="text" id="firstname" name="firstname"
               value="<?php echo htmlspecialchars($query_value); ?>"
               placeholder="e.g. Ben" />
        <button type="submit">Search</button>
    </form>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($results)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Active</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($row['lastname']); ?></td>
                        <td><?php echo htmlspecialchars($row['active']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["firstname"]) && !$error): ?>
        <p>No active users found matching "<strong><?php echo htmlspecialchars($query_value); ?></strong>".</p>
    <?php endif; ?>
</body>
</html>
