<?php
$key = sodium_crypto_secretbox_keygen();
file_put_contents('../encryption.key', $key);
echo "Encryption key generated and saved to 'encryption.key'.";
?>