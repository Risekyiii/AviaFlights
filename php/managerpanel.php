<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <title>Менеджер</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="icon" href="../images/rocket.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../styles/normalize.css">
    <link rel="stylesheet" type="text/css" href="../styles/header.css">
    <link rel="stylesheet" type="text/css" href="../styles/footer.css">
    <link rel="stylesheet" type="text/css" href="../styles/managerpanel.css">
</head>
<body>
    <?php include './header.php'; ?>
    <div class="content">
        <div class="managerpage">
            <hr>
            <h1>Панель менеджера</h1>
            <h3>Добавить новость</h3>   
            <div class="parameters">
                <form class="addForm" method="post">
                    <p>Введите текст новости и выберите для неё изображение</p>
                    <div class="formRow">
                        <textarea id="newsText" name="txtNews" rows="4" cols="50"
                        maxlength="800" ></textarea>
                        <input id="idFile" type="file" name="newsPic">
                    </div>
                    <div class="formRow">
                        <input class="addButton" name="btnSendNews" type="submit" value="Отправить"/>
                        <input class="addButton" type="reset" value="Очистка">
                    </div>
                    <?php
                        if (isset($_POST['btnSendNews'])) {
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

                            $txtNews = $_POST["txtNews"];
                            $newsPic = $_POST["newsPic"];

                            if ($txtNews != "" && $newsPic != "")
                            {
                                $newsPic = "../images/".$newsPic;
                                $query = "INSERT INTO news(news_text, image_path) VALUES (?, ?)";

                                $stmt = $pdo->prepare($query);
                                $stmt->execute([$txtNews, $newsPic]);
                                $count = $stmt->fetch();
                            }
                            else if ($txtNews != "" && $newsPic == "")
                            {
                                $query = "INSERT INTO news(news_text, image_path) VALUES (?, ?)";

                                $stmt = $pdo->prepare($query);
                                $stmt->execute([$txtNews, ""]);
                                $count = $stmt->fetch();
                            }
                            else {
                                echo "<p style='color: red;'>Ошибка занесения новости: недостаточно данных</p>";
                            }
                        }
                    ?>
                </form>
            </div>
            <hr>
            <h3>Удалить новость</h3> 
            <div class="parameters">
                <form class="delForm" method="post">
                    <p>Введите id новости для удаления</p>
                    <div class="formRow">
                        <input type="number" name="txtDelId">
                    </div>
                    <div class="formRow">
                        <input class="addButton" name="btnDelNews" type="submit" value="Удалить"/>
                    </div>
                    <?php
                        if (isset($_POST['btnDelNews'])) {
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

                            $txtNewsId = $_POST["txtDelId"];

                            if ($txtNewsId != 0)
                            {
                                $query = "SELECT COUNT(*) FROM news WHERE id_news = ?";

                                $stmt = $pdo->prepare($query);
                                $stmt->execute([$txtNewsId]);
                                $count = $stmt->fetch();

                                if ($count != 0)
                                {
                                    $query = "DELETE FROM news WHERE id_news = ?";

                                    $stmt = $pdo->prepare($query);
                                    $stmt->execute([$txtNewsId]);
                                    $count = $stmt->fetch();
                                }
                                else {
                                    echo "<p style='color: red;'>Записи не существует!</p>";
                                }
                            }
                        }
                    ?>
                </form>
            </div>
        </div>
    </div>
    <?php include './footer.php';  ?>
</body>
</html>