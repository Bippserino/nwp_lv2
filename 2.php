<?php
// Provjeri je li forma poslana
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    // Ime uploadane datoteke
    $target_file = basename($_FILES["file"]["name"]);
    // Format dopuštenih datoteka
    $allowed_extensions = array("pdf", "jpeg", "jpg", "png");
    $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Provjera dopuštenih ekstenzija
    if (!in_array($file_extension, $allowed_extensions)) {
        echo "Dozvoljene su samo PDF, JPEG, JPG i PNG datoteke.";
        exit();
    }

    // Upload datoteke
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        // Kriptiranje datoteke
        $cipher_method =  "AES-128-CTR";
        $encryption_key = md5('jed4n j4k0 v3l1k1 kljuc');
        // $iv_length = openssl_cipher_iv_length($cipher_method); 
        $encryption_iv = "123456789";  
        $options = 0; 
        $encrypted_content = openssl_encrypt(file_get_contents($target_file), $cipher_method, $encryption_key, $options, $encryption_iv);
        $encrypted_file = $target_file . ".enc";
        file_put_contents($encrypted_file, $encrypted_content);
        unlink($target_file); // Brisanje originalne datoteke

        echo "Datoteka je uspješno uploadana i kriptirana.";
    } else {
        echo "Došlo je do greške prilikom uploada datoteke.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload i kriptiranje datoteke</title>
</head>
<body>
    <h2>Upload i kriptiranje datoteke</h2>
    <form method="post" enctype="multipart/form-data">
        Odaberite datoteku za upload:
        <input type="file" name="file" id="file">
        <input type="submit" value="Upload" name="submit">
    </form>
</body>
</html>