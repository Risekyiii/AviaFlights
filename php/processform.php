<?php
session_start();

// Подключаем автозагрузчик классов
require 'vendor/autoload.php';

// Импортируем нужный класс из YooKassa
use YooKassa\Client;

// Проверяем метод запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $username = $_SESSION["username"];
    $gender = $_POST['gender'];
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $birth_date = $_POST['birth_date'];
    $citizenship = $_POST['citizenship'];
    $document_series_number = $_POST['document_series_number'];
    $country_of_issue = $_POST['country_of_issue'];
    $flightId = $_POST['flightId']; // Получаем ID рейса
    $document_series_number_hash = password_hash($document_series_number, PASSWORD_ARGON2ID);
    $birth_date_hash = password_hash($birth_date, PASSWORD_ARGON2ID);

    // Параметры подключения к базе данных
    $host = '127.0.0.1';
    $dbname = 'spacetickets';
    $bdusername = 'postgres';
    $bdpassword = 'postgres';
    $encryption_key = file_get_contents('./encryption.key');
    
    

    try {
        // Подключаемся к базе данных
        $pdo = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $bdusername, $bdpassword); 
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Начало транзакции
        $pdo->beginTransaction();

        // Записываем данные в таблицу passenger_info с шифрованием
        // Преобразуем birth_date в строку
$birth_date_str = strval($birth_date);

 // Записываем данные в таблицу passenger_info с шифрованием
// Запрос на вставку данных
$query = "INSERT INTO passenger_info (username, gender, last_name, first_name, middle_name, birth_date, citizenship, document_series_number, country_of_issue, flight_id) 
VALUES (
  :username, 
  :gender, 
  :last_name, 
  :first_name, 
  :middle_name, 
  :birth_date_hash,
  :citizenship, 
  :document_series_number_hash, 
  :country_of_issue, 
  :flightId
)";

// Выполняем запрос
$stmt = $pdo->prepare($query);
$stmt->execute([
'username' => $username,
'gender' => $gender,
'last_name' => $last_name,
'first_name' => $first_name,
'middle_name' => $middle_name,
'birth_date_hash' => $birth_date_hash, 
'citizenship' => $citizenship,
'document_series_number_hash' => $document_series_number_hash, 
'country_of_issue' => $country_of_issue,
'flightId' => $flightId

]);
        // Обновление статуса подтверждения билета в таблице places
        $query = "UPDATE places SET is_confirmed = TRUE WHERE flight_id = :flightId AND username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['flightId' => $flightId, 'username' => $username]);

        // Обновление статуса билета на 'completed' в таблице tickets
        $query = "UPDATE tickets SET status = 'completed' WHERE id = :flightId";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['flightId' => $flightId]);

        // Подтверждаем транзакцию
        $pdo->commit();

        // Получаем цену билета из таблицы tickets
        $stmt = $pdo->prepare("SELECT price FROM tickets WHERE id = ?");
        $stmt->execute([$flightId]);
        $ticket = $stmt->fetch(PDO::FETCH_ASSOC);
        $ticketPrice = $ticket['price'];

        // Получаем общее количество занятых мест
        $stmt = $pdo->prepare("SELECT places_taken FROM places WHERE flight_id = ?");
        $stmt->execute([$flightId]);
        $placesTaken = $stmt->fetchColumn();
        $occupiedPlaces = explode(',', trim($placesTaken, '{}'));
        $totalOccupiedPlaces = count($occupiedPlaces);

        // Рассчитываем общую стоимость билетов
        $totalPrice = (float) $ticketPrice * $totalOccupiedPlaces;

        // Создаем платеж через YooKassa
        $client = new Client();
        $client->setAuth('395469', 'test_jNM1RElOXXBtrqrS4KvJtZWgNWmdGmXTayANJiNJg10');

        // Генерируем ключ идемпотентности
        $idempotenceKey = uniqid('', true);

        try {
            // Создаем платеж
            $payment = $client->createPayment(
                [
                    'amount' => [
                        'value' => $totalPrice, // Сумма платежа
                        'currency' => 'RUB',
                    ],
                    'confirmation' => [
                        'type' => 'redirect',
                        'return_url' => 'usertickets.php', // URL, куда вернется пользователь после оплаты
                    ],
                    'capture' => true,
                    'description' => 'Оплата заказа №' . $flightId,
                ],
                $idempotenceKey
            );

            // Сохраняем ID платежа в сессии для последующей проверки
            $_SESSION['payment_id'] = $payment->getId();

            // Перенаправляем пользователя на страницу оплаты
            header('Location: ' . $payment->getConfirmation()->getConfirmationUrl());
            exit;
        } catch (Exception $e) {
            echo 'Ошибка: ' . $e->getMessage();
        }

    } catch(PDOException $e) {
        // Откатываем транзакцию в случае ошибки
        $pdo->rollBack();
        echo "Ошибка при сохранении данных: " . $e->getMessage();
    }
} else {
    echo "Неверный метод запроса.";
}
?>