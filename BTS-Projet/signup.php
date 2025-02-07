<?php
// Activer l'affichage des erreurs pour le debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Connexion à la base de données
$conn = mysqli_connect("localhost", "root", "root", "pluviometres_db");

if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

// Vérifier si on a bien reçu des données POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); 

    // Vérifier si l'utilisateur existe déjà
    $stmt = mysqli_prepare($conn, "SELECT password FROM Utilisateur WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // L'utilisateur existe, vérification du mot de passe
        if ($password == $row['password']) {
            $_SESSION['username'] = $username;
            header("Location: text.php");
            exit();
        } else {
            echo "<script>alert('Mot de passe incorrect'); window.location.href='connexion.html';</script>";
        }
    } else {
        // L'utilisateur n'existe pas, on l'ajoute dans la base de données
        $stmt_insert = mysqli_prepare($conn, "INSERT INTO Utilisateur (id, username, password) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt_insert, "sss", $username, $password);
        if (mysqli_stmt_execute($stmt_insert)) {
            $_SESSION['username'] = $username;
            echo "<script>alert('Inscription réussie, redirection vers le tableau de bord...'); window.location.href='dashboard.html';</script>";
            exit();
        } else {
            echo "Erreur lors de l'inscription : " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt_insert);
    }

    // Fermer les connexions
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
