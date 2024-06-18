<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $flightId = $data['flightId'];

    $host = '127.0.0.1';
    $dbname = 'spacetickets';
    $bdusername = 'postgres';
    $bdpassword = 'postgres';

    try {
        $pdo = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $bdusername, $bdpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Получаем данные о занятых местах
        $stmt = $pdo->prepare('SELECT places_taken FROM places WHERE flight_id = :flight_id');
        $stmt->bindParam(':flight_id', $flightId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && !empty($result['places_taken'])) {
            $placesTakenArray = $result['places_taken'];
            echo json_encode(['success' => true, 'placesTaken' => $placesTakenArray]);
        } else {
            // Если нет данных о занятых местах, вернуть пустой массив
            echo json_encode(['success' => true, 'placesTaken' => []]);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>