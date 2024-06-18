<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="icon" href="../images/rocket.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../styles/normalize.css">
    <link rel="stylesheet" type="text/css" href="../styles/header.css">
    <link rel="stylesheet" type="text/css" href="../styles/footer.css">
    <link rel="stylesheet" type="text/css" href="../styles/usertickets.css">
</head>
<body>
    <?php include './header.php'; ?>
    <div class="content">
        <div class="profile">
            <hr>
            <?php 
                session_start();
                if (isset($_SESSION["username"])) {
                    $name = $_SESSION["username"];
                    echo "<h1>Ваша почта: $name</h1>";
                }
            ?>
            <h1>Ваши билеты</h1>
            <?php 
                if (isset($_SESSION["username"])) {
                    $host = '127.0.0.1';
                    $dbname = 'spacetickets';
                    $bdusername = 'postgres';
                    $bdpassword = 'postgres';

                    try {
                        $pdo = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $bdusername, $bdpassword); 
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    } catch(PDOException $e) {
                        echo "Ошибка при получении данных: " . $e->getMessage();
                    }
                
                    $username = $_SESSION["username"];
                    $query = "SELECT tickets.planet_from, tickets.planet_to, tickets.departure_date, tickets.arrival_date, tickets.price, tickets.id, places.places_taken, places.is_confirmed, tickets.status
                              FROM tickets 
                              INNER JOIN places ON tickets.id = places.flight_id 
                              WHERE username = ?;";
                
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$username]);
                    $sqlresult = $stmt->fetchAll();
                
                    if (count($sqlresult) == 0) {
                        echo "<h3>Вы не бронировали места на рейсы</h3>";
                    } else {
                        echo '<div class="tickets">';
                        foreach ($sqlresult as $count) {
                            // Убираем фигурные скобки и разбиваем строку на массив по запятым
                            $occupiedPlaces = explode(',', trim($count['places_taken'], '{}'));

                            // Рассчитываем общее количество занятых мест
                            $totalOccupiedPlaces = count($occupiedPlaces);

                            // Рассчитываем общую стоимость билета
                            $totalPrice = (float)$count['price'] * $totalOccupiedPlaces;

                            echo '<form class="userticket" method="post" action="delete_ticket.php">';
                            echo '<div>';
                            echo '<h3>' . $count['planet_from'] . ' -> ' . $count['planet_to'] . '</h3>';
                            echo '<p>Дата отправления: ' . $count['departure_date'] . '</p>';
                            echo '<p>Дата возвращения: ' . $count['arrival_date'] . '</p>';
                            echo '<p>Итоговая стоимость: ' . $totalPrice . 'Р</p>';  // Отображаем итоговую стоимость
                            echo '<p>Занятые места: ';
                            if (is_array($count['places_taken'])) {
                                echo implode(", ", $count['places_taken']);
                            } else {
                                echo $count['places_taken'];
                            }
                            echo '</p>'; 
                            echo '</div>';
                            echo '<input type="hidden" name="flightId" value="' . $count['id'] . '">';
                            echo '<button class="ticketbutton" name="btnDel">Отменить бронь</button>';
                            echo '</form>';

                            // Таймер только для неподтвержденных билетов
                            if (!$count['is_confirmed']) {
                                echo '<div id="timer-' . $count['id'] . '" class="timer"></div>';
                                echo '<div id="payment-' . $count['id'] . '" class="payment-section">';
                                echo '<form class="userticket" method="get" action="buyform.php">';
                                echo '<input type="hidden" name="flightId" value="' . $count['id'] . '">';
                                echo '<input type="hidden" name="price" value="' . $totalPrice . '">';  // Передаем итоговую стоимость для оплаты
                                echo '<button class="ticketbutton" type="submit">Оплатить билет</button>';
                                echo '</form>';
                                echo '</div>';
                                echo '<div id="confirmed-' . $count['id'] . '" class="confirmed-section" style="display: none;">Бронь подтверждена</div>';
                            } else {
                                echo '<div id="confirmed-' . $count['id'] . '" class="confirmed-section">Бронь подтверждена</div>';
                            }
                        }
                        echo '</div>';
                    }

                    // Отображение истории бронирований
                    echo "<h1>История бронирований</h1>";
                    $query_history = "SELECT planet_from, planet_to, departure_date, arrival_date, price 
                                      FROM tickets 
                                      INNER JOIN places ON tickets.id = places.flight_id 
                                      WHERE username = ? AND status = 'completed';"; // или другой статус для завершенных рейсов

                    $stmt_history = $pdo->prepare($query_history);
                    $stmt_history->execute([$username]);
                    $history_result = $stmt_history->fetchAll();

                    if (count($history_result) == 0) {
                        echo "<h3>У вас нет завершенных бронирований</h3>";
                    } else {
                        echo '<div class="tickets-history">';
                        foreach ($history_result as $history) {
                            echo '<div class="history-ticket">';
                            echo '<h3>' . $history['planet_from'] . ' -> ' . $history['planet_to'] . '</h3>';
                            echo '<p>Дата отправления: ' . $history['departure_date'] . '</p>';
                            echo '<p>Дата возвращения: ' . $history['arrival_date'] . '</p>';
                            echo '<p>Итоговая стоимость: ' . $totalPrice . 'Р</p>';
                            echo '</div>';
                        }
                        echo '</div>';
                    }
                } 
            ?>
        </div>
    </div>
    <?php include './footer.php'; ?>
    <script>
        // Функция для сохранения состояния таймера в localStorage
        function saveTimerState(ticketId, timer) {
            localStorage.setItem('timer_' + ticketId, timer);
        }

        // Функция для восстановления состояния таймера из localStorage
        function restoreTimerState(ticketId) {
            return localStorage.getItem('timer_' + ticketId);
        }

        // Функция для удаления билета
        function deleteTicket(ticketId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_ticket.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    location.reload(); // Перезагрузка страницы после удаления билета
                }
            };
            xhr.send("flightId=" + ticketId);
        }

        // Функция для запуска таймера
        function startTimer(duration, display, ticketId) {
            var start = Date.now(), // Время начала отсчета
                diff, // Разница между текущим временем и временем начала отсчета
                minutes, seconds;

            function timer() {
                // Вычисляем разницу во времени
                diff = duration - (((Date.now() - start) / 1000) | 0);

                // Преобразуем время в минуты и секунды
                minutes = (diff / 60) | 0;
                seconds = (diff % 60) | 0;

                // Форматируем время для отображения
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                // Обновляем отображение таймера
                display.textContent = minutes + ":" + seconds;

                // Если время истекло, останавливаем таймер
                if (diff <= 0) {
                    clearInterval(interval);
                    deleteTicket(ticketId);
                    return;
                }

                // Сохраняем текущее состояние таймера в localStorage
                saveTimerState(ticketId, diff);
            }

            // Запускаем таймер
            timer();
            var interval = setInterval(timer, 1000);
        }

        // Функция для инициализации таймеров
        window.onload = function () {
            var timers = document.querySelectorAll('.timer');
            timers.forEach(function (timer) {
                var ticketId = timer.id.split('-')[1];
                var remainingTime = restoreTimerState(ticketId) || 600; // 10 минут по умолчанию
                startTimer(remainingTime, timer, ticketId);
            });
        };
    </script>
</body>
</html>