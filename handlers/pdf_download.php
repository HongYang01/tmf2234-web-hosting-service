<?php
if (isset($_POST['pdfData']) && !empty($_POST['pdfData'])) {
    $pdfData = base64_decode($_POST['pdfData']);

    // Set appropriate headers for the PDF file
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="subscription_receipt.pdf"');

    echo $pdfData;
    exit;
} else {
    echo "Error generate pdf";
}
