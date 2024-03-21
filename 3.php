<?php
// Provjera svih datoteka u direktoriju
$encrypted_files = glob("*.enc");

// Iteriranje kroz sve kriptirane datoteke
foreach ($encrypted_files as $encrypted_file) {
    // Dekriptiranje datoteke
    $key = md5('jed4n j4k0 v3l1k1 kljuc');
    $cipher = "AES-128-CTR"; 
    $options = 0; 
    $encryption_iv = "123456789"; 
    $decrypted_content = openssl_decrypt(file_get_contents($encrypted_file), $cipher, $key, $options, $encryption_iv);

    // Ime dekriptirane datoteke
    $decrypted_file_name = str_replace(".enc", "", basename($encrypted_file));
    // Spremanje dekriptiranog sadržaja u novu datoteku
    file_put_contents($decrypted_file_name, $decrypted_content);
}

// Prikaz linkova za preuzimanje dekriptiranih datoteka
echo "<h2>Preuzimanje dekriptiranih dokumenata:</h2>";
foreach ($encrypted_files as $encrypted_file) {
    $decrypted_file_name = str_replace(".enc", "", basename($encrypted_file));
    echo "<a href='$decrypted_file_name' download>$decrypted_file_name</a><br>";
}
?>
