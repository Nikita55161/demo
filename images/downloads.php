<?php
$fileUrl = 'https://teacher.co.ke/wp-content/uploads/bsk-pdf-manager/2019/01/the-a-to-z-of-correct-english.pdf';
$fileName = basename($fileUrl);

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $fileName . '"');
readfile($fileUrl);
exit;
?>