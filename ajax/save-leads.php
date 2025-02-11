<?php

require_once('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    $response = ["status" => false, "message" =>  "Method Not Allowed"];
    echo json_encode($response);
    exit;
}

$customer_name = isset($_POST['customer_name']) ? htmlspecialchars(trim($_POST['customer_name'])) : '';
$contact_no = isset($_POST['contact_no']) ? htmlspecialchars(trim($_POST['contact_no'])) : '';
$project_name = isset($_POST['project_name']) ? htmlspecialchars(trim($_POST['project_name'])) : '';
$flat_details = isset($_POST['flat_details']) ? htmlspecialchars(trim($_POST['flat_details'])) : '';
$property_cost = isset($_POST['property_cost']) ? htmlspecialchars(trim($_POST['property_cost'])) : '';
$loan_amount = isset($_POST['loan_amount']) ? htmlspecialchars(trim($_POST['loan_amount'])) : '';
$rate_of_interest = isset($_POST['rate_of_interest']) ? htmlspecialchars(trim($_POST['rate_of_interest'])) : '';
$tenor = isset($_POST['tenor']) ? htmlspecialchars(trim($_POST['tenor'])) : '';
$emi = isset($_POST['emi']) ? htmlspecialchars(trim($_POST['emi'])) : '';
$state = isset($_POST['state']) ? htmlspecialchars(trim($_POST['state'])) : '';
$city = isset($_POST['city']) ? htmlspecialchars(trim($_POST['city'])) : '';

if (empty($customer_name) || empty($contact_no) || empty($project_name) || empty($flat_details) || empty($property_cost) || empty($loan_amount) || empty($rate_of_interest) || empty($tenor) || empty($state) || empty($city)) {
    http_response_code(400);
    $response = ["status" => false, "message" => "All fields are required."];
    echo json_encode($response);
    exit;
}

if (!preg_match('/^[0-9]{10}$/', $contact_no)) {
    http_response_code(400);
    $response = ["status" => false, "message" => "Invalid contact number. It should be 10 digits."];
    echo json_encode($response);
    exit;
}

if (!is_numeric($property_cost) || !is_numeric($loan_amount) || !is_numeric($rate_of_interest) || !is_numeric($tenor)) {
    http_response_code(400);
    $response = ["status" => false, "message" => "Property cost, loan amount, rate of interest, and tenor should be numeric values."];
    echo json_encode($response);
    exit;
}

if ($rate_of_interest > 0 && $tenor > 0) {
    $monthly_interest_rate = $rate_of_interest / (12 * 100);
    $emi = $loan_amount * $monthly_interest_rate / (1 - pow(1 + $monthly_interest_rate, -$tenor));
} else {
    $emi = 0;
}

$stmt = $conn->prepare("SELECT lead_number FROM leads ORDER BY lead_id DESC LIMIT 1");
$stmt->execute();
$last_lead = $stmt->fetch(PDO::FETCH_ASSOC);

if ($last_lead) {
    $last_lead_number = $last_lead['lead_number'];
    $lead_number = 'LEAD' . str_pad(substr($last_lead_number, 4) + 1, 4, '0', STR_PAD_LEFT);
} else {
    $lead_number = 'LEAD0001';
}

try {
    $stmt = $conn->prepare("INSERT INTO leads (lead_number, customer_name, contact_no, project_name, flat_details, property_cost, loan_amount, rate_of_interest, tenor, emi, state, city) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$lead_number, $customer_name, $contact_no, $project_name, $flat_details, $property_cost, $loan_amount, $rate_of_interest, $tenor, $emi, $state, $city]);
    $lead_id = $conn->lastInsertId();

    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        $image_paths = [];
        $images = $_FILES['images'];

        foreach ($images['tmp_name'] as $key => $tmp_name) {
            $image_name = basename($images['name'][$key]);
            $image_tmp_name = $images['tmp_name'][$key];

            $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($image_ext, $allowed_ext)) {
                http_response_code(400);
                $response = ["status" => false, "message" => "Invalid image type. Only JPG, JPEG, PNG, and GIF are allowed."];
                echo json_encode($response);
                continue;
            }

            $upload_dir = '../images/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $unique_image_name = uniqid('img_', true) . '.' . $image_ext;
            $image_path = $upload_dir . $unique_image_name;

            if (move_uploaded_file($image_tmp_name, $image_path)) {
                $stmt = $conn->prepare("INSERT INTO lead_images (lead_id, image_path) VALUES (?, ?)");
                $stmt->execute([$lead_id, $image_path]);
                $image_paths[] = $image_path;
            } else {
                http_response_code(400);
                $response = ["status" => false, "message" => "Failed to upload image: " . $image_name];
                echo json_encode($response);
                exit;
            }
        }
    }

    http_response_code(200);
    $response = ["status" => true, "message" => "Lead has been added successfully!"];
    echo json_encode($response);
    exit;

} catch (PDOException $e) {
    http_response_code(500);
    $response = ["status" => false, "message" => "Error: " . $e->getMessage()];
    echo json_encode($response);
    exit;
}

?>
