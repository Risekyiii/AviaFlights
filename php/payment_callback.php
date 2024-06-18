<?php
session_start();

require 'vendor/autoload.php';
use YooKassa\Client;

$client = new Client();
$client->setAuth('395469', 'test_jNM1RElOXXBtrqrS4KvJtZWgNWmdGmXTayANJiNJg10');

try {
    $paymentId = $_SESSION['payment_id'];
    $payment = $client->getPaymentInfo($paymentId);

    if ($payment->getStatus() == 'succeeded') {
        // Платеж успешно завершен, обновите статус в базе данных
        $host = '127.0.0.1';
        $dbname = 'spacetickets';
        $bdusername = 'postgres';
        $bdpassword = 'postgres';

        $pdo = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $bdusername, $bdpassword); 
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $flightId = $payment->getDescription(); // Предполагается, что в описании хранится ID рейса
        $username = $_SESSION["username"];

        // Начало транзакции
        $pdo->beginTransaction();

        // Обновление статуса подтверждения билета в таблице places
        $query = "UPDATE places SET is_confirmed = TRUE WHERE flight_id = :flightId AND username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['flightId' => $flightId, 'username' => $username]);

        // Обновление статуса билета на 'completed' в таблице tickets
        $query = "UPDATE tickets SET status = 'completed' WHERE id = :flightId";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['flightId' => $flightId]);

        // Подтверждение транзакции
        $pdo->commit();

        // Перенаправление на страницу подтверждения
        header('Location: usertickets.php');
        exit;
    } else {
        // Платеж не завершен, обработайте этот случай
        echo "Платеж не завершен. Статус: " . $payment->getStatus();
    }
} catch (Exception $e) {
    echo "Ошибка при проверке платежа: " . $e->getMessage();
}
?>