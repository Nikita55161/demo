<?php
// External file URL
$fileUrl = "https://teacher.co.ke/wp-content/uploads/bsk-pdf-manager/2019/01/the-a-to-z-of-correct-english.pdf";
// Decide what you want the downloaded file to be named
$fileName = "the-a-to-z-of-correct-english.pdf";

// Initialize cURL
$ch = curl_init($fileUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
// (Optional) to avoid SSL errors, you can disable verification, though not recommended for production
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$data = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// If fetch failed or returned non-200 status, show error
if ($httpCode !== 200 || !$data) {
    header("HTTP/1.1 404 Not Found");
    echo "Could not retrieve file.";
    exit;
}

// Send headers to force download
header("Content-Type: application/pdf");
header("Content-Disposition: attachment; filename=\"$fileName\"");
header("Content-Length: " . strlen($data));

// Output the data
echo $data;
exit;
?>