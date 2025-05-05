<?php
// Include the database connection file
include_once 'connectdb.php';

// Get the raw POST data
$inputData = file_get_contents('php://input');
$data = json_decode($inputData, true);

// Check if the QR data was received
if (isset($data['qrData'])) {
    $qrData = $data['qrData'];

    // Prepare the SQL query to check the QR code against the database
    // Assuming the QR code contains the student's LRN as the unique identifier
    $sql = "SELECT * FROM tbl_student WHERE lrn = :qrData LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':qrData', $qrData, PDO::PARAM_STR);
    
    // Execute the query
    $stmt->execute();

    // Check if a student was found with the QR data
    if ($stmt->rowCount() > 0) {
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        // Prepare the response data with the student's information
        $response = [
            'success' => true,
            'name' => $student['name'],
            'lrn' => $student['lrn'],
            'grade' => $student['grade'],
            'section' => $student['section'],
            'gname' => $student['gname'],
            'gcontact' => $student['gcontact'],
            'address' => $student['address']
        ];
    } else {
        // If no student is found, return an error message
        $response = [
            'success' => false,
            'message' => 'No student found with this LRN (QR Code).'
        ];
    }
} else {
    // If no QR data was received, return an error message
    $response = [
        'success' => false,
        'message' => 'Invalid QR data received.'
    ];
}

// Set the content type to JSON and return the response
header('Content-Type: application/json');
echo json_encode($response);
