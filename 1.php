<?php

$host = 'localhost'; 
$username = "u376204397_labosi";
$password = "Labosi1234!";
$database = "u376204397_radovi";

// Spajanje na bazu podataka
$conn = new mysqli($host, $username, $password, $database);

// Provjera konekcije
if ($conn->connect_error) {
    die("Greška u konekciji: " . $conn->connect_error);
}

// Dobivanje svih tablica u bazi podataka i spremanje njihovih naziva u tables array
$tables = array();
$result = $conn->query("SHOW TABLES");
while ($row = $result->fetch_row()) {
    $tables[] = $row[0];
}

// Otvaranje datoteke za pisanje
$backup_file = 'backup.txt';
$fp = fopen($backup_file, 'w');

// Iteriranje kroz sve tablice
foreach ($tables as $table) {
    // Dohvaćanje naziva stupaca
    $result = $conn->query("SHOW COLUMNS FROM $table");
    $columns = array();
    while ($row = $result->fetch_assoc()) {
        $columns[] = $row['Field'];
    }
    $c = implode(",", $columns);

    // Dobivanje podataka iz tablice
    $result = $conn->query("SELECT * FROM $table");

    while ($row = $result->fetch_assoc()) {
        // Formatiranje podataka u SQL naredbu INSERT
        $values = "'" . implode("', '", array_values($row)) . "'";
        $insert_query = "INSERT INTO $table ($c)\n VALUES ($values);";
        // Upisivanje INSERT naredbe u datoteku
        fwrite($fp, "$insert_query\n");
    }
}

// Zatvaranje datoteke
fclose($fp);

echo 'Backup je uspješno napravljen. Možete mu pristupiti preko: <a href="https://bojanmandic.com/nwp/lv2/backup.txt" target="_blank">linka</a>';

$input_file = 'backup.txt';
// Čitanje sadržaja ulazne datoteke
$file_content = file_get_contents($input_file);

// Komprimiranje sadržaja
$compressed_content = gzencode($file_content);

// Pisanje komprimiranog sadržaja u izlaznu datoteku
file_put_contents($input_file . ".gz", $compressed_content);
echo "<br>Datoteka je uspješno sažeta.";


// Zatvaranje veze s bazom podataka
$conn->close();
?>
