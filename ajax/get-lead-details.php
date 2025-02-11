<?php
require_once('../config/database.php');

if (!isset($_GET['lead_id'])) {
    echo "<p>No lead ID provided.</p>";
    exit;
}

$lead_id = $_GET['lead_id'];

$stmt = $conn->prepare("SELECT * FROM leads WHERE lead_id = :lead_id");
$stmt->execute(['lead_id' => $lead_id]);
$lead = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$lead) {
    echo "<p>Lead not found.</p>";
    exit;
}

echo "<p><strong>Lead Number:</strong> " . htmlspecialchars($lead['lead_number']) . "</p>";
echo "<p><strong>Customer Name:</strong> " . htmlspecialchars($lead['customer_name']) . "</p>";
echo "<p><strong>Contact No:</strong> " . htmlspecialchars($lead['contact_no']) . "</p>";
echo "<p><strong>Project Name:</strong> " . htmlspecialchars($lead['project_name']) . "</p>";
echo "<p><strong>Flat Details:</strong> " . nl2br(htmlspecialchars($lead['flat_details'])) . "</p>";
echo "<p><strong>Property Cost:</strong> ₹" . number_format($lead['property_cost'], 2) . "</p>";
echo "<p><strong>Loan Amount:</strong> ₹" . number_format($lead['loan_amount'], 2) . "</p>";
echo "<p><strong>Rate of Interest:</strong> " . htmlspecialchars($lead['rate_of_interest']) . "%</p>";
echo "<p><strong>Tenor:</strong> " . htmlspecialchars($lead['tenor']) . " months</p>";
echo "<p><strong>EMI:</strong> ₹" . number_format($lead['emi'], 2) . "</p>";
echo "<p><strong>State:</strong> " . htmlspecialchars($lead['state']) . "</p>";
echo "<p><strong>City:</strong> " . htmlspecialchars($lead['city']) . "</p>";

$stmt_images = $conn->prepare("SELECT image_path FROM lead_images WHERE lead_id = :lead_id");
$stmt_images->execute(['lead_id' => $lead_id]);
$images = $stmt_images->fetchAll(PDO::FETCH_ASSOC);

if ($images) {
    echo "<p><strong>Images:</strong><br>";
    foreach ($images as $image) {
        echo "<img width='100%' class='server-pond' src='/images/" . htmlspecialchars($image['image_path']) . "' alt='Lead Image' class='img-fluid' style='max-width: 200px; margin: 5px;'><br>";
    }
} else {
    echo "<p>No images available.</p>";
}
?>
