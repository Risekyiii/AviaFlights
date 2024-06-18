<!-- <?php
session_start();

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
    $login = $_POST["txtLogin"];
    $password = $_POST["txtPass"];

    // Escape input data
    $login = htmlspecialchars($login);

    try {
        // Подготовка запроса для получения всех пользователей
        $query = "SELECT (username, password) FROM users";
        $stmt = $pdo->prepare($query); // Используем $pdo вместо $db
        $stmt->execute();
        
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $user_found = false;

        foreach ($users as $row) {
            // Извлечение nonce и зашифрованной электронной почты
            $username = $row['username'];
            if (strlen($username) < SODIUM_CRYPTO_SECRETBOX_NONCEBYTES) {
                continue; // Пропустить, если длина имени пользователя меньше длины nonce
            }
            $nonce = substr($username, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
            $encrypted_login = substr($username, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
            error_log("Attempting to decrypt login with nonce: " . bin2hex($nonce) . " and encrypted part: " . bin2hex($encrypted_login));
            // Расшифровка электронной почты
            $decrypted_login = sodium_crypto_secretbox_open($encrypted_login, $nonce, $key);

            if ($decrypted_login === false) {
                continue; // Если не удалось расшифровать, пропустить эту запись
            }

            // Получение хеша пароля из BLOB
            $hashed_password_blob = sodium_hex2bin($row['password']);
            
            if ($decrypted_login === $login && sodium_crypto_pwhash_str_verify($hashed_password_blob, $password)) {
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $login;
                $user_found = true;

                // Redirect based on user
                if ($login == "komarovA") {  // используйте фактический email администратора
                    header("Location: ./adminpanel.php");
                } else {
                    header("Location: ./index.php");
                }
                exit();
            }
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?> -->