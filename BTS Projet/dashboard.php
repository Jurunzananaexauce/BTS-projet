<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <?php
    // Démarrer la session
    session_start();

    // Vérifier si l'utilisateur est connecté
    if (isset($_SESSION['user_id'])) {
        echo "<h1>Connexion réussie à la base de données</h1>";
        echo "<p>Bienvenue, " . htmlspecialchars($_SESSION['username']) . "!</p>";
    } else {
        // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
        header("Location: login.php");
        exit();
    }
    ?>
</body>
</html>