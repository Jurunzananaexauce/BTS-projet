<?php
// Activer l'affichage des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); 

    // Connexion à la base de données
    $conn = mysqli_connect("localhost", "root", "root", "pluviometres_db",);


    if (!$conn) {
        die("Échec de la connexion : " . mysqli_connect_error());
    }

    echo "Connexion réussie";

    // Préparer la requête pour éviter l'injection SQL
    $stmt = mysqli_prepare($conn, "SELECT password FROM Utilisateur WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $password_bd = $row['password']; // Récupère le mot de passe stocké en clair

        // Comparer directement les mots de passe sans hashage
        if ($password == $password_bd) {
            $_SESSION['username'] = $username;
            header("Location: dashboard.html");
            exit();
        } else {
            echo "<script>alert('Nom d\'utilisateur ou mot de passe incorrect'); window.location.href='connexion.html';</script>";
        }
    } else {
        echo "<script>alert('Nom d\'utilisateur ou mot de passe incorrect'); window.location.href='connexion.html';</script>";
    }

    // Fermer la connexion
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
