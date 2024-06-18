<script src="https://kit.fontawesome.com/10849d0bac.js" crossorigin="anonymous"></script>
<header>
    <a href="index.php" class="logo"> <span>Avia</span>Flights </a>
    <input type="checkbox" name="menu" id="menu">
    <label for="menu"><i class="fa-solid fa-bars"></i></label> 
    <nav class="navbar">
            <a href="./news.php">
                <div>Новости</div>
            </a>
            <a href="./about.php">
                <div>О предприятии</div>
            </a>
            <a href="./ships.php">
                <div>Самолёты</div>
            </a>
            <a href="./index.php">
                <div>Билеты</div>
            </a>
            <?php 
                session_start();
                
                if (isset($_SESSION["username"])) {
                    if ($_SESSION["role"] == 'admin'){
                        echo "
                        <a href='./adminpanel.php'>
                            <div>Панель адмнистратора</div>
                        </a>
                        ";
                    }
                    else if ($_SESSION["role"] == 'defaultuser') {
                        echo "
                        <a href='./usertickets.php'>
                            <div>Ваши билеты</div>
                        </a>
                        ";
                    }
                    else {
                        echo "
                        <a href='./managerpanel.php'>
                            <div>Панель менеджера</div>
                        </a>
                        ";
                    }
                    echo "
                    <a href='./operations/exit.php'>
                        <div>Выход</div>
                    </a>
                    ";
                } 
                else {
                    echo "
                    <a href='./login.php'>
                        <div>Вход</div>
                    </a>
                    ";
                }
            ?>
        </nav>
    </div>
</header>