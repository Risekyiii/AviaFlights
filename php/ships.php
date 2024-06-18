<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <title>Самолёты</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link rel="icon" href="../images/rocket.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../styles/normalize.css">
    <link rel="stylesheet" type="text/css" href="../styles/slider.css">
    <link rel="stylesheet" type="text/css" href="../styles/header.css">
    <link rel="stylesheet" type="text/css" href="../styles/footer.css">
    <link rel="stylesheet" type="text/css" href="../styles/ships.css">
</head>
<body>
    <?php include './header.php'; ?>
    <div class="content">
        <div class="ships">
            <div class="text">
                <hr>
                <h1>Информация о самолётах</h1>
                <div class="slider">
                    <ul class="sliderList">
                        <li><img src="../images/atr.jpg" alt="screen"></li>
                        <li class="sliderElem"><img src="../images/maw.jpg" alt="0"></li>
                        <li class="sliderElem"><img src="../images/mew.jpg" alt="1"></li>
                        <li class="sliderElem"><img src="../images/atr.jpg" alt="2"></li>
                    </ul>
                    <div class="leftArrow"></div>
                    <div class="rightArrow"></div>
                    <div class="sliderDots"></div>
                </div>
                <p class="textSlider"></p>
                <hr>
            </div>
        </div>
    </div>
    <?php include './footer.php';  ?>
    <script src="../js/scriptSlider.js"></script>
</body>
</html>