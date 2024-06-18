<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных из запроса
    $username = $_SESSION["username"];
    $flightId = $_POST['flightId'];

    // Подключение к базе данных
    $host = '127.0.0.1';
    $dbname = 'spacetickets';
    $bdusername = 'postgres';
    $bdpassword = 'postgres';

    try {
        $pdo = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $bdusername, $bdpassword); 
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Удаление записи из таблицы places
        $query = "DELETE FROM places WHERE flight_id = :flightId AND username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['flightId' => $flightId, 'username' => $username]);

        echo "Билет успешно удален";
    } catch(PDOException $e) {
        echo "Ошибка при удалении билета: " . $e->getMessage();
    }
} else {
    echo "Неверный метод запроса.";
}
?>