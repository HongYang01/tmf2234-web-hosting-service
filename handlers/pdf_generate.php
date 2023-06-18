<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/handlers/fpdf/fpdf.php");

class CustomPDF extends FPDF
{

    function Header()
    {
        // Logo
        $this->Image($_SERVER['DOCUMENT_ROOT'] . "/assets/image/logo.png", 170, 5, 30);  // Adjust the path and coordinates as needed

        // Company Name
        $this->SetFont('Arial', 'B', 33);
        $this->Cell(0, 10, 'Semicolonix', 0, 1);  // Adjust the company name and alignment as needed

        // Line break
        $this->Ln(16);  // Adjust the line break distance as needed
    }

    function Footer()
    {
        // Set up the footer content (optional)
    }

    function Content($receiptEmail, $transactionID, $totalAmount, $subscriptionID, $planID, $planName, $billDate, $nextBillDate)
    {

        $w = 60;
        $h = 10;
        $title = 20;
        $text = 12;

        // Set up the main content
        $this->SetFont('Arial', 'B', $title);
        $this->Cell(0, 30, 'Thank You For Your Subscription', 0, 1);

        $this->SetFont('Arial', 'B', $text); // Set the font style to bold
        $this->Cell($w, $h, 'Receipt Sent to: ', 0, 0);
        $this->SetFont('Arial', '', $text); // Reset the font style to normal
        $this->Cell(0, $h, $receiptEmail, 0, 1);

        $this->SetFont('Arial', 'B', $text); // Set the font style to bold
        $this->Cell($w, $h, 'Transaction ID: ', 0, 0);
        $this->SetFont('Arial', '', $text); // Reset the font style to normal
        $this->Cell(0, $h, $transactionID, 0, 1);

        $this->SetFont('Arial', 'B', $text); // Set the font style to bold
        $this->Cell($w, $h, 'Total Paid Amount: ', 0, 0);
        $this->SetFont('Arial', '', $text); // Reset the font style to normal
        $this->Cell(0, $h, $totalAmount . ' USD', 0, 1);

        $this->SetFont('Arial', 'B', $text); // Set the font style to bold
        $this->Cell($w, $h, 'Subscription ID: ', 0, 0);
        $this->SetFont('Arial', '', $text); // Reset the font style to normal
        $this->Cell(0, $h, $subscriptionID, 0, 1);

        $this->SetFont('Arial', 'B', $text); // Set the font style to bold
        $this->Cell($w, $h, 'Plan ID: ', 0, 0);
        $this->SetFont('Arial', '', $text); // Reset the font style to normal
        $this->Cell(0, $h, $planID, 0, 1);

        $this->SetFont('Arial', 'B', $text); // Set the font style to bold
        $this->Cell($w, $h, 'Plan Name: ', 0, 0);
        $this->SetFont('Arial', '', $text); // Reset the font style to normal
        $this->Cell(0, $h, $planName, 0, 1);

        $this->SetFont('Arial', 'B', $text); // Set the font style to bold
        $this->Cell($w, $h, 'Bill Date: ', 0, 0);
        $this->SetFont('Arial', '', $text); // Reset the font style to normal
        $this->Cell(0, $h, $billDate, 0, 1);

        $this->SetFont('Arial', 'B', $text); // Set the font style to bold
        $this->Cell($w, $h, 'Next Bill Date: ', 0, 0);
        $this->SetFont('Arial', '', $text); // Reset the font style to normal
        $this->Cell(0, $h, $nextBillDate, 0, 1);

        $this->Ln(100);

        $this->SetFont('Arial', '', $text);
        $this->Cell(0, $h, "This is an auto-generated receipt, no signature needed.", 0, 1);
        $this->Cell(30, $h, 'Contact us at: ', 0, 0);

        // set email
        $email = "help@semicolonix.com";
        $this->SetFont('Arial', 'U', $text); // Set the font style to underlined
        $this->SetTextColor(0, 0, 255); // Set the text color to blue
        $this->Cell(20, $h, $email, 0, 0);
        $this->Link(30, $this->GetY(), 0, $h, 'mailto:' . $email);
    }
}
