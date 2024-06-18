<?php
session_start(); // Начинаем сессию, если она еще не начата

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $flightId = $data['flightId'];
    $selectedSeats = $data['selectedSeats'];
    $username = $_SESSION['username']; // Получаем имя пользователя из сессии

    $host = '127.0.0.1';
    $dbname = 'spacetickets';
    $bdusername = 'postgres';
    $bdpassword = 'postgres';

    try {
        $pdo = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $bdusername, $bdpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Проверяем, что $selectedSeats является массивом перед использованием implode()
        if (is_array($selectedSeats)) {
            $placesTaken = count($selectedSeats);

            // Обновляем данные в базе данных
            $query = 'UPDATE tickets SET places_taken = places_taken + :places_taken WHERE id = :flight_id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':places_taken', $placesTaken, PDO::PARAM_INT);
            $stmt->bindParam(':flight_id', $flightId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Вставляем данные о занятых местах в таблицу places
                $places = '{' . implode(',', $selectedSeats) . '}';
                $queryPlaces = 'INSERT INTO places (places_taken, flight_id, username) VALUES (:places_taken, :flight_id, :username)';
                $stmtPlaces = $pdo->prepare($queryPlaces);
                $stmtPlaces->bindParam(':places_taken', $places);
                $stmtPlaces->bindParam(':flight_id', $flightId);
                $stmtPlaces->bindParam(':username', $username);

                if ($stmtPlaces->execute()) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error updating the database']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Error updating the database']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid selected seats format.']);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>