<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Авторизация</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="icon" href="../images/rocket.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../styles/normalize.css">
    <link rel="stylesheet" type="text/css" href="../styles/header.css">
    <link rel="stylesheet" type="text/css" href="../styles/login.css">
</head>
<body>
    <?php include './header.php'; ?>
    <?php ("config.php"); ob_start(); ?>
    <div class="content">
        <video class="video_content" src="../images/sky.mp4" autoplay muted loop></video>
        <form class="form" method="post">
            <h1>Вход</h1>
            <span class="error"></span>
            <input class="login" name="txtLogin" type="text" maxlength="30" placeholder="Введите Email">
            <input class="password" name="txtPass" type="password" maxlength="30" placeholder="Введите пароль">
            <input class="send_login" name="btnLogin" type="submit" value="Полетели!">
            <input class="send_register" name="btnRegister" type="submit" value="Регистрация">
        <?php 
            if (isset($_POST['btnLogin'])) {
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

                $login = $_POST["txtLogin"];
                $password = $_POST["txtPass"];

                $query = "SELECT * FROM users where username = ? and password = ?";

                $stmt = $pdo->prepare($query);
                $stmt->execute([$login, $password]);
                $count = $stmt->fetch();

                if ($count) {
                    session_start();
                    $_SESSION["username"] = $count['username']; // Используйте имя столбца
                    $_SESSION["role"] = $count['role']; // Используйте имя столбца
                
                    if ($count['role'] == 'admin') // Используйте имя столбца
                        header('Location: ./adminpanel.php');
                    else if ($count['role'] == 'defaultuser') // Используйте имя столбца
                        header('Location: ./usertickets.php');
                    else 
                        header('Location: ./managerpanel.php');
                    exit;
                } else {
                    echo "<p style='color: red;'>Пользователь или пароль не совпадают</p>";
                }
            }
            
            if (isset($_POST['btnRegister'])) {
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

                $login = $_POST["txtLogin"];
                $password = $_POST["txtPass"];

                $query = "SELECT count(*) FROM users where username = ?";

                $stmt = $pdo->prepare($query);
                $stmt->execute([$login]);
                $count = $stmt->fetchColumn();

                if ($count == 1) {
                    echo "<p style='color: red;'>Пользователь существует</p>";
                } else {
                    $query = "INSERT INTO users(username, password, role) VALUES (?, ?, 'defaultuser')";

                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$login, $password]);
                }
            }
		?>
        </form>
    </div>
</body>
</html>