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
    // Create a PDO connection to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the country parameter from the GET request
    $country = isset($_GET['country']) ? $_GET['country'] : '';

    // Prepare the SQL query with LIKE for partial matching
    $sql = "SELECT name, continent, independence_year, head_of_state FROM countries WHERE name LIKE :country";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
    $stmt->execute();

    // Fetch results as an associative array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return results in JSON format
    if ($results) {
        echo json_encode(['success' => true, 'data' => $results]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No countries found matching that name.']);
    }

} catch (PDOException $e) {
    // Return a database error message as JSON
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
