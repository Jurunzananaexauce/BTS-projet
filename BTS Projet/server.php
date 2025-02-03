<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connexion à une base de données MySQL
    $conn = new mysqli("localhost", "root", "", "pluviometres_db");

    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Vérifier les identifiants (à sécuriser avec hashage de mot de passe)
    $stmt = $conn->prepare("SELECT * FROM connexion WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php"); // Redirection après connexion réussie
        exit();
    } else {
        echo "<script>alert('Nom d\'utilisateur ou mot de passe incorrect'); window.location.href='connexion.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
