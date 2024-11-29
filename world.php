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
    // the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // the GET request
    $country = isset($_GET['country']) ? $_GET['country'] : '';
    $lookup = isset($_GET['lookup']) ? $_GET['lookup'] : '';

    // cities
    if ($lookup === 'cities') {
        // SQL query 
        $sql = "
            SELECT c.name AS city_name, c.district, c.population
            FROM cities c
            JOIN countries co ON c.country_code = co.code
            WHERE co.name LIKE :country
            ORDER BY c.population DESC
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
        $stmt->execute();

        // Fetch results 
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // the HTML table for cities
        $html = '<table border="1" cellpadding="10" cellspacing="0">';
        $html .= '<thead>
                    <tr>
                        <th>City Name</th>
                        <th>District</th>
                        <th>Population</th>
                    </tr>
                  </thead>';
        $html .= '<tbody>';

        // Check if there are city results
        if ($results) {
            // Loop through the results and add rows to the table
            foreach ($results as $row) {
                $html .= '<tr>';
                $html .= '<td>' . htmlspecialchars($row['city_name']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['district']) . '</td>';
                $html .= '<td>' . htmlspecialchars($row['population']) . '</td>';
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr><td colspan="3">No cities found for this country.</td></tr>';
        }

        $html .= '</tbody>';
        $html .= '</table>';

        // Output the table for cities
        echo $html;
    } else {
        // Query for country information
        $sql = "SELECT name, continent, independence_year, head_of_state FROM countries WHERE name LIKE :country";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
        $stmt->execute();

        // Fetch results 
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $html = '<table border="1" cellpadding="10" cellspacing="0">';
        $html .= '<thead>
                    <tr>
                        <th>Country Name</th>
                        <th>Continent</th>
                        <th>Independence Year</th>
                        <th>Head of State</th>
                    </tr>
                  </thead>';
        $html .= '<tbody>';

        // Check country results
        if ($results) {
            foreach ($results as $row) {
              $html .= '<tr>';
              $html .= '<td>' . htmlspecialchars($row['name'] ?? '') . '</td>';
              $html .= '<td>' . htmlspecialchars($row['continent'] ?? '') . '</td>';
              $html .= '<td>' . htmlspecialchars($row['independence_year'] ?? '') . '</td>';
              $html .= '<td>' . htmlspecialchars($row['head_of_state'] ?? '') . '</td>';
              $html .= '</tr>';
          }
        } else {
            $html .= '<tr><td colspan="4">No countries found matching that name.</td></tr>';
        }

        $html .= '</tbody>';
        $html .= '</table>';

        // The table for countries
        echo $html;
    }

} catch (PDOException $e) {
    // Return an error message if something goes wrong
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
