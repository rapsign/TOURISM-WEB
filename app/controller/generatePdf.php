<?php
require('../../public/assets/fpdf/fpdf.php');
include '../config/database.php';

// START: Mengambil parameter dari URL
$invoice_id = isset($_GET['invoice_id']) ? $_GET['invoice_id'] : 0;
$email = isset($_GET['email']) ? $_GET['email'] : '';

// START: Validasi ID dan Email
if ($invoice_id === 0 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid request.");
}

// START: Query untuk mengambil data invoice
$sql = "SELECT i.*, d.destination_price, d.transport_price, d.food_price, d.destination_name
        FROM invoice i
        JOIN destination d ON i.destination_id = d.id
        WHERE i.invoice_id = ? AND i.email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('is', $invoice_id, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Invoice not found or email mismatch.");
}

// START: Mengambil data invoice dari hasil query
$invoice = $result->fetch_assoc();
$name = $invoice['name'];
$days = $invoice['days'];
$phone = $invoice['phone'];
$guest = $invoice['guest'];
$booking_date = $invoice['booking_date'];
$departure_date = $invoice['departure_date'];
$destination_name = $invoice['destination_name'];
$paid = $invoice['paid'] ? 'Paid' : 'Unpaid';
$total = $invoice['total'];
$transport = $invoice['transport'] ? 'Include' : 'Exclude';
$food = $invoice['food'] ? 'Include' : 'Exclude';

// Function to format currency
function format_currency($amount) {
    return 'Rp. ' . number_format($amount, 0, ',', '.');
}

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Title
$pdf->Cell(0, 10, 'INVOICE #' . $invoice_id, 0, 1, 'C');

// Invoice Details
$pdf->SetFont('Arial', '', 12);
$leftColWidth = 100;
$rightColWidth = 90;
$lineHeight = 10;

// Name and Payment Status
$pdf->Cell(170 , $lineHeight, "Name: " . $name, 0, 0);
$pdf->SetFont('Arial', 'B', 12);
if ($invoice['paid']) {
    $pdf->SetFillColor(0, 128, 0);
    $pdf->SetTextColor(255, 255, 255); 
} else {
    $pdf->SetFillColor(255, 0, 0);
    $pdf->SetTextColor(255, 255, 255);
}
$pdf->Cell( 20 , $lineHeight, $paid, 0, 1, 'C', true);
$pdf->SetFont('Arial', '', 12); 
$pdf->SetTextColor(0, 0, 0);

// Email and Booking Date
$pdf->Cell($leftColWidth, $lineHeight, "Email : " . $email, 0, 0);
$pdf->Cell($rightColWidth, $lineHeight, "Booking Date : " . date('d F Y', strtotime($booking_date)), 0, 1, 'R');

// Phone, Guest, Departure Date
$pdf->Cell(0, 10, "Phone : " . $phone, 0, 1);
$pdf->Cell(0, 10, "Guest : " . $guest, 0, 1);
$pdf->Cell(0, 10, "Departure Date : " . date('d F Y', strtotime($departure_date)), 0, 1);
$pdf->Ln(10);

// Define column widths for two-column layout
$col1Width = 60;
$col2Width = 130;

// Start two-column layout
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell($col1Width, 10, 'Invoice ID', 1);
$pdf->Cell($col2Width, 10, ' #' . $invoice_id, 1);
$pdf->Ln();

$pdf->Cell($col1Width, 10, 'Destination', 1);
$pdf->Cell($col2Width, 10, ' ' . $destination_name, 1);
$pdf->Ln();

$pdf->Cell($col1Width, 10, 'Days', 1);
$pdf->Cell($col2Width, 10, ' ' . $days . ' days', 1);
$pdf->Ln();

$pdf->Cell($col1Width, 10, 'Transport', 1);
$pdf->Cell($col2Width, 10, ' ' . $transport, 1);
$pdf->Ln();

$pdf->Cell($col1Width, 10, 'Food', 1);
$pdf->Cell($col2Width, 10, ' ' . $food, 1);
$pdf->Ln();

$pdf->Cell($col1Width, 10, 'Price', 1);
$pdf->Cell($col2Width, 10, ' ' . format_currency($total), 1);
$pdf->Ln(5);

// Total
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Total: ' . format_currency($total), 0, 1, 'R');

// Output PDF
$filename = 'INVOICE - #' . $invoice_id . '.pdf';
$pdf->Output('D', $filename);
?>
