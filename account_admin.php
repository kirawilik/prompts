<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
</head>
<body>
<h1>Bonjour Admin <?php echo htmlspecialchars($_SESSION['name']); ?></h1>
<a href="diconnexion.php">Déconnexion</a>
<br><br>
<button onclick="window.location.href='Category.php';">Gérer les catégories</button>

<br><br>
<a href="users.php"><button type="button">Voir les contributeurs</button></a>
</body>
</html>