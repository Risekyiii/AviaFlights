<!-- <?php

// Подключение к базе данных
$host = '127.0.0.1';
$dbname = 'spacetickets';
$bdusername = 'postgres';
$bdpassword = 'postgres';

try {
    $pdo = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $bdusername, $bdpassword); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Ошибка при получении данных: ' . $e->getMessage()]);
    exit(); // Прерываем выполнение скрипта в случае ошибки
}

// Загрузка ключа шифрования
$key_path = './encryption.key';
if (!file_exists($key_path)) {
    die('Encryption key not found.');
}
$key = file_get_contents($key_path);
if (strlen($key) !== SODIUM_CRYPTO_SECRETBOX_KEYBYTES) {
    die('Invalid key size.');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['txtLogin'];
    $password = $_POST['txtPass'];

    // Хэширование пароля с использованием библиотеки Sodium
    $hashed_password = sodium_crypto_pwhash_str(
        $password,
        SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
        SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
    );

    // Шифрование логина
    $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
    $encrypted_login = $nonce . sodium_crypto_secretbox($login, $nonce, $key);

    // Для отладки, выводим зашифрованные данные
    echo '<pre>';
    echo 'Encrypted login: ' . bin2hex($encrypted_login) . PHP_EOL;
    echo 'Hashed password: ' . $hashed_password . PHP_EOL;
    echo '</pre>';

    try {
        // Подготовка SQL-запроса
        $sql = "INSERT INTO users (username, password, role) VALUES (:username, :password, 'defaultuser')";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $encrypted_login, PDO::PARAM_LOB);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);

        // Выполнение запроса
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?> -->