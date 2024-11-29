<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection variables
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // the GET request
    $country = isset($_GET['country']) ? $_GET['country'] : '';

    // partial matching
    $sql = "SELECT * FROM countries WHERE name LIKE :country";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
    $stmt->execute();

    // Fetch results 
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the results 
    echo json_encode($results);
} catch (PDOException $e) {
    // Return an error message 
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
