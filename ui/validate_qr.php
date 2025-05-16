<?php
include_once 'connectdb.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set timezone
date_default_timezone_set('Asia/Manila');

// Get and decode the raw POST data
$inputData = file_get_contents('php://input');
$data = json_decode($inputData, true);

error_log("Received data: " . print_r($data, true)); // Debug log

// Check if LRN is provided
if (isset($data['lrn'])) {
    $qrData = trim($data['lrn']);

    error_log("Looking up LRN: $qrData");

    // Check if student exists
    $sql = "SELECT * FROM tbl_student WHERE lrn = :qrData LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':qrData', $qrData, PDO::PARAM_STR);

    try {
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $student = $stmt->fetch(PDO::FETCH_ASSOC);

            // Prepare attendance variables
            $today = date('Y-m-d');
            $currentTime = date('H:i:s'); // Current time in HH:MM:SS format

            // Check if attendance already exists for today
            $checkSql = "SELECT * FROM tbl_attendance WHERE lrn = :lrn AND date = :date LIMIT 1";
            $checkStmt = $pdo->prepare($checkSql);
            $checkStmt->execute([
                ':lrn' => $qrData,
                ':date' => $today
            ]);

            if ($checkStmt->rowCount() > 0) {
                // If attendance exists, check which field (morningIn, morningOut, etc.) is empty
                $attendance = $checkStmt->fetch(PDO::FETCH_ASSOC);
                $updateField = null;

                if (empty($attendance['morningIn'])) {
                    $updateField = 'morningIn';
                } elseif (empty($attendance['morningOut'])) {
                    $updateField = 'morningOut';
                } elseif (empty($attendance['afternoonIn'])) {
                    $updateField = 'afternoonIn';
                } elseif (empty($attendance['afternoonOut'])) {
                    $updateField = 'afternoonOut';
                }

                if ($updateField) {
                    $updateSql = "UPDATE tbl_attendance SET $updateField = :time WHERE id = :id";
                    $updateStmt = $pdo->prepare($updateSql);
                    $updateStmt->execute([
                        ':time' => $currentTime,
                        ':id' => $attendance['id']
                    ]);
                    $attendanceMessage = ucfirst($updateField) . " time recorded at $currentTime";
                } else {
                    $attendanceMessage = "All attendance records for today have already been filled.";
                }
            } else {
                // First scan of the day: insert lrn, name, date, and morningIn
                $insertSql = "INSERT INTO tbl_attendance (lrn, name, date, morningIn) VALUES (:lrn, :name, :date, :morningIn)";
                $insertStmt = $pdo->prepare($insertSql);
                $insertStmt->execute([
                    ':lrn' => $qrData,
                    ':name' => $student['name'], // Add name from student table
                    ':date' => $today,
                    ':morningIn' => $currentTime
                ]);

                $attendanceMessage = "Morning In time recorded at $currentTime";
            }

            // Prepare response with student info + attendance message
            $response = [
                'success' => true,
                'name' => $student['name'],
                'lrn' => $student['lrn'],
                'grade' => $student['grade'],
                'section' => $student['section'],
                'gname' => $student['gname'],
                'gcontact' => $student['gcontact'],
                'address' => $student['address'],
                'attendance' => $attendanceMessage
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No student found with this LRN (QR Code).'
            ];
        }
    } catch (PDOException $e) {
        error_log('SQL Error: ' . $e->getMessage());
        $response = [
            'success' => false,
            'message' => 'Database query failed: ' . $e->getMessage()
        ];
    }
} else {
    $response = [
        'success' => false,
        'message' => 'Invalid QR data received.'
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
