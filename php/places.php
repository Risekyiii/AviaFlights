<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Получаем данные из POST-запроса
    $ticketId = $_POST['flightId'] ?? null;

    if (!$ticketId) {
        echo json_encode(['success' => false, 'message' => 'Flight ID not provided.']);
        exit();
    }

    // Подключение к базе данных
    $host = '127.0.0.1';
    $dbname = 'spacetickets';
    $bdusername = 'postgres';
    $bdpassword = 'postgres';

    try {
        $pdo = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $bdusername, $bdpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Ошибка при получении данных: ' . $e->getMessage()]);
        exit(); // Прерываем выполнение скрипта в случае ошибки
    }

    // Запрос к базе данных для получения информации о занятых местах
    $query = 'SELECT places.places_taken 
              FROM places 
              INNER JOIN tickets ON places.flight_id = tickets.id
              WHERE tickets.id = ?';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$ticketId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Проверяем результат запроса
    if ($result && $result['places_taken']) {
        echo json_encode(['success' => true, 'placesTaken' => $result['places_taken']]);
    } else {
        // Если данных нет, возвращаем пустой массив
        echo json_encode(['success' => true, 'placesTaken' => []]);
    }
}
?>