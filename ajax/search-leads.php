<?php
// Include database connection file
require_once('../config/database.php');

// Check if search query is set
$searchQuery = isset($_GET['search_query']) ? $_GET['search_query'] : '';

// Get the current page and limit
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5; // Set the number of results per page
$start = ($page - 1) * $limit;

// Prepare the SQL query with pagination and search filter
$stmt = $conn->prepare("SELECT * FROM leads WHERE lead_number LIKE :search OR customer_name LIKE :search LIMIT :start, :limit");
$searchTerm = '%' . $searchQuery . '%';
$stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
$stmt->bindParam(':start', $start, PDO::PARAM_INT);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

// Execute the query
$stmt->execute();

// Fetch and display the results
$results = '';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $results .= "<tr>";
    $results .= "<td>" . $row['lead_number'] . "</td>";
    $results .= "<td>" . $row['customer_name'] . "</td>";
    $results .= "<td>" . $row['contact_no'] . "</td>";
    $results .= "<td>" . $row['project_name'] . "</td>";
    $results .= "<td><button class='btn btn-info btn-sm view-details' data-lead-id='" . $row['lead_id'] . "'>View Details</button></td>";
    $results .= "</tr>";
}

// Count total results for pagination
$stmtTotal = $conn->prepare("SELECT COUNT(*) FROM leads WHERE lead_number LIKE :search OR customer_name LIKE :search");
$stmtTotal->bindParam(':search', $searchTerm, PDO::PARAM_STR);
$stmtTotal->execute();
$total = $stmtTotal->fetchColumn();

// Calculate total pages
$pages = ceil($total / $limit);

// Generate pagination HTML
$paginationHTML = '';
$paginationHTML .= '<nav aria-label="Page navigation">';
$paginationHTML .= '<ul class="pagination justify-content-center">';

// Previous button
$paginationHTML .= '<li class="page-item ' . ($page === 1 ? 'disabled' : '') . '">';
$paginationHTML .= '<a class="page-link" href="#" data-page="' . ($page - 1) . '">Previous</a>';
$paginationHTML .= '</li>';

// Page numbers
for ($i = 1; $i <= $pages; $i++) {
    $paginationHTML .= '<li class="page-item ' . ($i === $page ? 'active' : '') . '">';
    $paginationHTML .= '<a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a>';
    $paginationHTML .= '</li>';
}

// Next button
$paginationHTML .= '<li class="page-item ' . ($page === $pages ? 'disabled' : '') . '">';
$paginationHTML .= '<a class="page-link" href="#" data-page="' . ($page + 1) . '">Next</a>';
$paginationHTML .= '</li>';

$paginationHTML .= '</ul>';
$paginationHTML .= '</nav>';

// Return both results and pagination HTML
echo json_encode([
    'results' => $results,
    'paginationHTML' => $paginationHTML
]);
?>
