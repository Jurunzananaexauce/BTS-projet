<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connexion à la base de données
    $conn = mysqli_connect("localhost", "root", "", "pluviometres_db");

    if (!$conn) {
        die("Échec de la connexion : " . mysqli_connect_error());
    }

    // Éviter les injections SQL en échappant les données
    $username = mysqli_real_escape_string($conn, $username);
    
    // Requête SQL pour récupérer le mot de passe haché
    $sql = "SELECT password FROM connexion WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        // Vérifier le mot de passe avec password_verify()
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Nom d\'utilisateur ou mot de passe incorrect'); window.location.href='connexion.html';</script>";
        }
    } else {
        echo "<script>alert('Nom d\'utilisateur ou mot de passe incorrect'); window.location.href='connexion.html';</script>";
    }

    mysqli_close($conn);
}
?>
