<?php
// Activer l'affichage des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connexion à la base de données
$conn = mysqli_connect("localhost", "root", "root", "pluviometres_db");

// Vérifier la connexion
if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

// Requête pour récupérer les tables
$sql = "SHOW TABLES";
$result = mysqli_query($conn, $sql);

// Vérifier si des tables existent
if (mysqli_num_rows($result) > 0) {
    echo "<h2>Liste des tables dans la base de données 'pluviometres_db' :</h2>";
    echo "<ul>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<li>" . $row[0] . "</li>";
    }
    echo "</ul>";
} else {
    echo "Aucune table trouvée dans la base de données.";
}

// Fermer la connexion
mysqli_close($conn);
?>
