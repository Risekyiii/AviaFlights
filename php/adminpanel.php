<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <title>Администратор</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="icon" href="../images/rocket.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../styles/normalize.css">
    <link rel="stylesheet" type="text/css" href="../styles/header.css">
    <link rel="stylesheet" type="text/css" href="../styles/footer.css">
    <link rel="stylesheet" type="text/css" href="../styles/adminpanel.css">
</head>
<body>
    <?php include './header.php'; ?>
    <div class="content">
        <div class="adminpage">
            <hr>
            <h1>Панель администратора</h1>
            <h3>Реализуемые рейсы:</h3>
            <?php 

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

                $query = "SELECT * FROM tickets";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $results = $stmt->fetchAll();
                echo '<div class="tickets">';
                foreach ($results as $count) {
                    echo '<form class="userticket" method="post">';
                    echo '<div>';
                    echo '<h3>' . $count['planet_from'] . ' -> ' . $count['planet_to'] . '</h3>';
                    echo '<p>Дата отправления: ' . $count['departure_date'] . '</p>';
                    echo '<p>Дата возвращения: ' . $count['arrival_date'] . '</p>';
                    echo '<p>Стоимость: ' . $count['price'] . 'Р</p>';
                    echo '</div>';
                    echo '<input type="hidden" name="flightId" value="' . $count['id'] . '">';
                    echo '<button class="ticketbutton" name="btnDel">Удалить рейс</button>';
                    echo '</form>';
                }   
                echo '</div>';
            ?>
            <?php 
                if (isset($_POST['btnDel'])) {
                    $flightId = $_POST['flightId'];
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

                    $query = "DELETE FROM tickets WHERE id = ?";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$flightId]);

                    //header('Location: ' . $_SERVER['REQUEST_URI']);
                    exit;
                }
            ?>
            <hr>
            <h3>Добавить рейс:</h3>
            <div class="parameters">
                <form class="searchForm" method="post">
                    <div class="formRow">
                        <div>
                            <p>Откуда/Куда</p>
                            <input name="txtPlanetFrom" type="text" placeholder="Откуда"/>
                            <input name="txtPlanetTo" type="text" placeholder="Куда"/>
                        </div>
                        <div>
                            <p>Дата отправления/возвращения</p>
                            <input name="dateDeparture" type="date"/>
                            <input name="dateArrival" type="date"/>
                            <input name="departureTime" type="time" placeholder="Время отправления">
                            <input name="arrivalTime" type="time" placeholder="Время прибытия">
                        </div>
                        <div>
                            <p>Стоимость билета</p>
                            <input name="txtPrice" type="number"/>
                        </div>
                    </div>
                    <p><b>Тип авиалайнера:</b></p>
                    <div class="formRow">
                        <input id="cargo" name="shipType" type="radio" value="cargo">
                        <label for="cargo">Бюджетный</label>
                        <input id="passenger" name="shipType" type="radio" value="passenger">
                        <label for="passenger">Пассажирский</label>
                        <input id="private" name="shipType" type="radio" value="private">
                        <label for="private">Частный</label>
                        <div>
                            <input class="addButton" name="btnAdd" type="submit" value="Добавить"/>
                        </div>
                    </div>
                    <?php
                        if (isset($_POST['btnAdd'])) {
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

                            $planetFrom = $_POST["txtPlanetFrom"];
                            $planetTo = $_POST["txtPlanetTo"];
                            $price = $_POST["txtPrice"];
                            $departureStr = $_POST["dateDeparture"];
                            $arrivalStr = $_POST["dateArrival"];
                            $departure = strtotime($_POST["dateDeparture"]);
                            $arrival = strtotime($_POST["dateArrival"]);
                            $ship = $_POST["shipType"];

                            $minDate = strtotime('2024-01-01');
                            $maxDate = strtotime('2026-12-31');

                            if ($departure < $arrival && $departure >= $minDate && 
                                    $departure <= $maxDate && $arrival >= $minDate && $arrival <= $maxDate 
                                    && $price > 4000 && $price < 100000 && $planetFrom != "" && 
                                    $planetTo != "") {
                                $query = "SELECT * FROM tickets where planet_from = ? and planet_to = ? and departure_date = ? and arrival_date = ?";

                                $stmt = $pdo->prepare($query);
                                $stmt->execute([$planetFrom, $planetTo, $departureStr, $arrivalStr]);
                                $count = $stmt->fetch();
                                
                                if ($count == 1) {
                                    echo "<p style='color: red;'>Рейс существует</p>";
                                } else {
                                    $query = "INSERT INTO tickets(planet_from, planet_to, departure_date, arrival_date, price, places_taken, places_full, flight_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                                    $departureDateTime = $_POST["dateDeparture"] . ' ' . $_POST["departureTime"];
                                    $arrivalDateTime = $_POST["dateArrival"] . ' ' . $_POST["arrivalTime"];
                                    
                                    switch ($ship) {
                                        case 'cargo': 
                                            $price = $price*1.1;
                                            $places_full = 36;
                                            break;
                                        case 'passenger':
                                            $price = $price*1.3;
                                            $places_full = 36;
                                            break;
                                        case 'private':
                                            $price = $price*1.8;
                                            $places_full = 36;
                                            break;
                                    }
                                    $places_taken = 0;
    
                                    $stmt = $pdo->prepare($query);
                                    $stmt->execute([$planetFrom, $planetTo, $departureDateTime, $arrivalDateTime, $price, $places_taken, $places_full, $ship]);

                                    //header('Location: ' . $_SERVER['REQUEST_URI']);
                                }
                            } else {
                                echo "<p style='color: red;'>Ошибка! Пожалуйста, введите корректные данные, в пределах от 01.01.2024 до 31.12.2026, стоимость >4000 и <100000.</p>";
                            }                      
                        }
                    ?>
                </form>
            </div>
            <hr>
        </div>
    </div>
    <?php include './footer.php';  ?>
</body>
</html>