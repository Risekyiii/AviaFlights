<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <title>Билеты</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="icon" href="../images/rocket.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../styles/normalize.css">
    <link rel="stylesheet" type="text/css" href="../styles/header.css">
    <link rel="stylesheet" type="text/css" href="../styles/footer.css">
    <link rel="stylesheet" type="text/css" href="../styles/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    
</head>
<body>
    <?php include './header.php'; ?>
    <dialog id="lalka" class="lalka"> 
        <h3 class="lalka-title">Выберите места</h3>
        <div class="squares">
            <div class="squares-cont">
                <div class="free"></div>
            </div>
            <div class="squares-cont">
                <div class="occup"></div>
            </div>
        </div>
        <div class="lalka-cont">
            <div class="seats">
                <input type="checkbox" class="lalka-btn" value="1">
                <input type="checkbox" class="lalka-btn" value="2">
                <input type="checkbox" class="lalka-btn" value="3">
                <input type="checkbox" class="lalka-btn" value="4">
                <input type="checkbox" class="lalka-btn" value="5">
                <input type="checkbox" class="lalka-btn" value="6">
                <input type="checkbox" class="lalka-btn" value="7">
                <input type="checkbox" class="lalka-btn" value="8">
                <input type="checkbox" class="lalka-btn" value="9">
                <input type="checkbox" class="lalka-btn" value="10">
                <input type="checkbox" class="lalka-btn" value="11">
                <input type="checkbox" class="lalka-btn" value="12">
                <input type="checkbox" class="lalka-btn" value="13">
                <input type="checkbox" class="lalka-btn" value="14">
                <input type="checkbox" class="lalka-btn" value="15">
                <input type="checkbox" class="lalka-btn" value="16">
                <input type="checkbox" class="lalka-btn" value="17">
                <input type="checkbox" class="lalka-btn" value="18">
            </div>
            <div class="seats">
                <input type="checkbox" class="lalka-btn" value="19">
                <input type="checkbox" class="lalka-btn" value="20"> 
                <input type="checkbox" class="lalka-btn" value="21">
                <input type="checkbox" class="lalka-btn" value="22">
                <input type="checkbox" class="lalka-btn" value="23">
                <input type="checkbox" class="lalka-btn" value="24">
                <input type="checkbox" class="lalka-btn" value="25">
                <input type="checkbox" class="lalka-btn" value="26">
                <input type="checkbox" class="lalka-btn" value="27">
                <input type="checkbox" class="lalka-btn" value="28">
                <input type="checkbox" class="lalka-btn" value="29"> 
                <input type="checkbox" class="lalka-btn" value="30">
                <input type="checkbox" class="lalka-btn" value="31">
                <input type="checkbox" class="lalka-btn" value="32">
                <input type="checkbox" class="lalka-btn" value="33">
                <input type="checkbox" class="lalka-btn" value="34">
                <input type="checkbox" class="lalka-btn" value="35">
                <input type="checkbox" class="lalka-btn" value="36">
                
            </div>
        </div>
        <div class="confirm">
            <button class="cancelbtn">Отмена</button>
            <button id="confirmbtn" name="confirmbtn" class="confirmbtn">Подтвердить</button>
        </div>
    </dialog>
    <div class="content">
        <div class="ticket">
            <hr>
            <h1>ПОИСК АВИАБИЛЕТОВ</h1>
            <!-- <button id="knopka" class="knopka">knopka</button> -->
            <div class="parameters">
                <h3>Укажите параметры для поиска подходящего маршрута</h3>
                <form class="searchForm" method="post">
                    <div class="formRow">
                        <div>
                            <p></p>
                            <input name="txtPlanetFrom" type="text" placeholder="Откуда"/>
                            <input name="txtPlanetTo" type="text" placeholder="Куда"/>
                        </div>
                        <div>
                            <p></p>
                            <input name="dateDeparture" type="date"/>
                            <input name="dateArrival" type="date"/>
                            <input name="departureTime" type="time" placeholder="Время отправления">
                            <input name="arrivalTime" type="time" placeholder="Время прибытия">
                        </div>
                        <div>
                            <p></p>
                            <input name="txtPriceFrom" type="number" placeholder="Цена от"/>
                            <input name="txtPriceTo" type="number" placeholder="Цена до"/>
                        </div>
                    </div>
                    <p><b></b></p>
                    <div class="formRow1">
                        <input id="cargo" name="shipType" type="radio" value="cargo">
                        <label for="cargo">Бюджетный</label>
                        <input id="passenger" name="shipType" type="radio" value="passenger">
                        <label for="passenger">Пассажирский</label>
                        <input id="private" name="shipType" type="radio" value="private">
                        <label for="private">Частный </label>
                        <div>
                            <input class="findButton last"  name="btnFind" type="submit" value="Найти"/>
                        </div>
                    </div>
                    <div>
                        <p></p>
                        <input name="txtPlaces" type="number" placeholder="Кол-во мест"/>
                    </div>
                </form>
            </div>
            <hr>
            <form class="filters" method="post">
                <div class="sort-block">
                    <h3>Сортировать по цене: </h3>
                    <input class="findButton" name="sortMoneyAscButton" type="submit" value="По возрастанию"/>
                    <input class="findButton" name="sortMoneyDescButton" type="submit" value="По убыванию"/>
                </div>
                <div class="sort-block">
                    <h3>Сортировать по времени: </h3>
                    <input class="findButton" name="sortDateAscButton" type="submit" value="По возрастанию"/>
                    <input class="findButton" name="sortDateDescButton" type="submit" value="По убыванию"/>
                </div>
            </form>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function(){
                    $(".knopka").mouseenter(function(){
                        $(this).siblings(".numPlaces").show();
                    });
                    $(".userticket").mouseleave(function(){
                        $(".numPlaces").hide();
                    });
                });
            </script>
            <hr>
            <h3 class="meow">Доступные рейсы:</h3>
            <?php
                if (isset($_POST['btnFind'])) {                    
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
                    
                    $query = "SELECT * FROM tickets WHERE 1=1"; 
                    $params = [];

                    if (!empty($_POST['txtPlanetFrom'])) {
                        $query .= " AND planet_from = ?";
                        $params[] = $_POST['txtPlanetFrom'];
                    }
                    if (!empty($_POST['txtPlanetTo'])) {
                        $query .= " AND planet_to = ?";
                        $params[] = $_POST['txtPlanetTo'];
                    }
                    if (!empty($_POST['dateDeparture'])) {
                        $query .= " AND departure_date = ?";
                        $params[] = $_POST['dateDeparture'];
                    }
                    if (!empty($_POST['dateArrival'])) {
                        $query .= " AND arrival_date = ?";
                        $params[] = $_POST['dateArrival'];
                    }
                    if (!empty($_POST['shipType'])) {
                        $query .= " AND flight_name = ?";
                        $params[] = $_POST['shipType'];
                    }
                    if (!empty($_POST['txtPriceFrom'])) {
                        $query .= " AND price > ?";
                        $params[] = $_POST['txtPriceFrom'];
                    }
                    if (!empty($_POST['txtPriceTo'])) {
                        $query .= " AND price < ?";
                        $params[] = $_POST['txtPriceTo'];
                    }
                    if (!empty($_POST['txtPlaces'])) {
                        $query .= " AND places_full > ?";
                        $params[] = $_POST['txtPlaces'];
                    }
                    
                    $stmt = $pdo->prepare($query);
                    $stmt->execute($params);
                    $results = $stmt->fetchAll();

                    echo '<div class="results">';
                    foreach ($results as $count) {
                        echo '<form class="userticket" method="post">';
                        echo '<div style="width: 100%; margin-top: 15px">';
                        echo '<h3>' . $count['planet_from'] . ' -> ' . $count['planet_to'] . '</h3>';
                        echo '<p>Дата отправления: ' . $count['departure_date'] . '</p>';
                        echo '<p>Дата возвращения: ' . $count['arrival_date'] . '</p>';
                        echo '<p>Стоимость: ' . $count['price'] . 'Р</p>';
                        echo '</div>';
                        echo '<input type="hidden" name="flightId" value="' . $count['id'] . '">';
                        echo '<div class="buttonDiv">';
                        echo '<input type="knopka" class="knopka" value="забронировать">';
                        echo '<input class="numPlaces" type="number" size="1" maxlength="1" min="0" max="9" name="numPlaces">';
                        echo '</div>';
                        echo '</form>';
                    }
                    echo '</div>';
                    session_start();
                    $_SESSION["results"] = $results;
                }
                else if (isset($_POST['sortMoneyAscButton'])) {
                        session_start();
                        $results = $_SESSION["results"];

                        function compareByPrice($a, $b) {
                            return $a['price'] - $b['price'];
                        }
                        usort($results, 'compareByPrice');

                        echo '<div class="results">';
                        foreach ($results as $count) {
                            echo '<form class="userticket" method="post">';
                            echo '<div style="width: 100%; margin-top: 15px">';
                            echo '<h3>' . $count['planet_from'] . ' -> ' . $count['planet_to'] . '</h3>';
                            echo '<p>Дата отправления: ' . $count['departure_date'] . '</p>';
                            echo '<p>Дата возвращения: ' . $count['arrival_date'] . '</p>';
                            echo '<p>Стоимость: ' . $count['price'] . 'Р</p>';
                            echo '</div>';
                            echo '<input type="hidden" name="flightId" value="' . $count['id'] . '">';
                            echo '<div class="buttonDiv">';
                            echo '<input type="knopka" class="knopka" value="забронировать">';
                            echo '<input class="numPlaces" type="number" size="1" maxlength="1" min="0" max="9" name="numPlaces">';
                            echo '</div>';
                            echo '</form>';
                        }
                        echo '</div>';  
                    }
                    else if (isset($_POST['sortMoneyDescButton'])) {
                        session_start();
                        $results = $_SESSION["results"];

                        function compareByPrice($a, $b) {
                            return $b['price'] - $a['price'];
                        }
                        usort($results, 'compareByPrice');

                        echo '<div class="results">';
                        foreach ($results as $count) {
                            echo '<form class="userticket" method="post">';
                            echo '<div style="width: 100%; margin-top: 15px">';
                            echo '<h3>' . $count['planet_from'] . ' -> ' . $count['planet_to'] . '</h3>';
                            echo '<p>Дата отправления: ' . $count['departure_date'] . '</p>';
                            echo '<p>Дата возвращения: ' . $count['arrival_date'] . '</p>';
                            echo '<p>Стоимость: ' . $count['price'] . 'Р</p>';
                            echo '</div>';
                            echo '<input type="hidden" name="flightId" value="' . $count['id'] . '">';
                            echo '<div class="buttonDiv">';
                            echo '<input type="knopka" class="knopka" value="забронировать">';
                            echo '<input class="numPlaces" type="number" size="1" maxlength="1" min="0" max="9" name="numPlaces">';
                            echo '</div>';
                            echo '</form>';
                        }
                        echo '</div>';
                    }
                    else if (isset($_POST['sortDateAscButton'])) {
                        session_start();
                        $results = $_SESSION["results"];

                        function compareByDepartureDate($a, $b) {
                            $timeInFlightA = strtotime($a['arrival_date']) - strtotime($a['departure_date']);
                            $timeInFlightB = strtotime($b['arrival_date']) - strtotime($b['departure_date']);
                            return $timeInFlightA - $timeInFlightB;
                        }
                        usort($results, 'compareByDepartureDate');

                        echo '<div class="results">';
                        foreach ($results as $count) {
                            echo '<form class="userticket" method="post">';
                            echo '<div style="width: 100%; margin-top: 15px">';
                            echo '<h3>' . $count['planet_from'] . ' -> ' . $count['planet_to'] . '</h3>';
                            echo '<p>Дата отправления: ' . $count['departure_date'] . '</p>';
                            echo '<p>Дата возвращения: ' . $count['arrival_date'] . '</p>';
                            echo '<p>Стоимость: ' . $count['price'] . 'Р</p>';
                            echo '</div>';
                            echo '<input type="hidden" name="flightId" value="' . $count['id'] . '">';
                            echo '<div class="buttonDiv">';
                            echo '<input type="knopka" class="knopka" value="забронировать">';
                            echo '<input class="numPlaces" type="number" size="1" maxlength="1" min="0" max="9" name="numPlaces">';
                            echo '</div>';
                            echo '</form>';
                        }
                        echo '</div>';
                    }
                    else if (isset($_POST['sortDateDescButton'])) {
                        session_start();
                        $results = $_SESSION["results"];

                        function compareByDepartureDate($a, $b) {
                            $timeInFlightA = strtotime($a['arrival_date']) - strtotime($a['departure_date']);
                            $timeInFlightB = strtotime($b['arrival_date']) - strtotime($b['departure_date']);
                            return $timeInFlightB - $timeInFlightA;
                        }
                        usort($results, 'compareByDepartureDate');

                        echo '<div class="results">';
                        foreach ($results as $count) {
                            echo '<form class="userticket" method="post">';
                            echo '<div style="width: 100%; margin-top: 15px">';
                            echo '<h3>' . $count['planet_from'] . ' -> ' . $count['planet_to'] . '</h3>';
                            echo '<p>Дата отправления: ' . $count['departure_date'] . '</p>';
                            echo '<p>Дата возвращения: ' . $count['arrival_date'] . '</p>';
                            echo '<p>Стоимость: ' . $count['price'] . 'Р</p>';
                            echo '</div>';
                            echo '<input type="hidden" name="flightId" value="' . $count['id'] . '">';
                            echo '<div class="buttonDiv">';
                            echo '<input type="knopka" class="knopka" value="забронировать">';
                            echo '<input class="numPlaces" type="number" size="1" maxlength="1" min="0" max="9" name="numPlaces">';
                            echo '</div>';
                            echo '</form>';
                        }
                        echo '</div>';
                    }
                    else {
                        echo '<h3 class="meow">Выберите параметры интересуещего вас рейса выше</h3>';
                    }
            ?>
            <hr>
        </div>
    </div>
    <?php include './footer.php';?>
    <?php include './save_seats.php';?>
    <?php include './load_seats.php';?>
    <script src="../js/main.js"></script>
</body>
</html>