<?php
require_once "../config/database.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(["error" => "Method Not Allowed"]);
    exit();
}

try {

    extract($_POST);

    function countLeadsByState(PDO $conn): array
    {
        $sql = "SELECT COUNT(*) AS `count`, `state` 
                FROM `leads`
                GROUP BY state";

        $result = $conn->prepare($sql);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    $revenueChartDetails = [];


    if (isset($_POST["chart"])) {

        $leadsByState = countLeadsByState($conn);

        echo json_encode($leadsByState); 
        exit;    
    }

} catch (PDOException $e) {
    echo "Something Went Wrong";
}
