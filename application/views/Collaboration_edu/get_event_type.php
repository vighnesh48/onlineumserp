<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include '../db.php'; 
include '../authorization.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $sql = "SELECT `event_type_id`, `event_type_name`
                FROM `su_track_event_types` WHERE `is_active` = 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($events)) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'No events found'
            ]);
            return;
        }

        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => 'Events fetched successfully',
            'total_events' => count($events),
            'events' => $events
        ]);
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'An unexpected error occurred',
        'error' => $e->getMessage()
    ]);
}
?>
