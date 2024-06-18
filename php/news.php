<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Новости</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="icon" href="../images/rocket.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../styles/normalize.css">
    <link rel="stylesheet" type="text/css" href="../styles/header.css">
    <link rel="stylesheet" type="text/css" href="../styles/footer.css">
    <link rel="stylesheet" type="text/css" href="../styles/news.css">
</head>
<body>
    <?php include './header.php'; ?>
    <div class="content">
        <div class="newsHeader">
            <h1>Последние новости предприятия</h1>
        </div>
        <!-- news start -->
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

            $query = "SELECT * FROM news";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll();

            foreach ($results as $count) {
                echo '<div class="newsElement">';
                echo '<div class="text">';
                if ($count['image_path'] != "")
                    echo '<img src=' . $count['image_path'] . '>';
                else 
                    echo '';
                echo '<div>';
                echo '<p>' . $count['news_text'] . '</p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '<hr>';
            }
        ?>
    </div>
    <?php include './footer.php';  ?>
</body>
</html>