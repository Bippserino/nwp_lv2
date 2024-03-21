<?php
// Učitavanje XML datoteke
$xml = simplexml_load_file('LV2.xml');

foreach ($xml->record as $osoba) {
    // Podaci o osobi
    $id = (int)$osoba->id;
    $ime = (string)$osoba->ime;
    $prezime = (string)$osoba->prezime;
    $email = (string)$osoba->email;
    $spol = (string)$osoba->spol;
    $slika = (string)$osoba->slika;
    $zivotopis = (string)$osoba->zivotopis;

    // Prikaz profila osobe
    echo "<div><img src='$slika'/><div><p>Ime: $ime</p></div><div><p>Prezime: $prezime</p></div><div><p>Email: $email</p></div><div><p>Životopis: $zivotopis</p></div></div>";
}
?>
