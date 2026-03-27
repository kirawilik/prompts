<?php
require 'connexion.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_POST['add_category'])) {
    $name = trim($_POST['name']);

    if (empty($name)) {
        $error = "Nom obligatoire";
    } else {
        $check = $db->prepare("SELECT category_id FROM categories WHERE name = ?");
        $check->execute([$name]);

        if ($check->rowCount() > 0) {
            $error = "Catégorie existe déjà";
        } else {
            $stmt = $db->prepare("INSERT INTO categories(name) VALUES(?)");
            $stmt->execute([$name]);
            $success = "Catégorie ajoutée ✔";
        }
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $db->prepare("DELETE FROM categories WHERE category_id = ?");
    $stmt->execute([$id]);
    header("Location: Category.php");
    exit();
}

$cats = $db->query("SELECT * FROM categories ORDER BY category_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Catégories</title>
</head>
<body>
<h2>Ajouter une catégorie</h2>

<?php
if (isset($error)) echo "<p style='color:red;'>$error</p>";
if (isset($success)) echo "<p style='color:green;'>$success</p>";
?>

<form method="POST">
    <input type="text" name="name" placeholder="Nom catégorie" required>
    <button type="submit" name="add_category">Ajouter</button>
</form>

<hr>

<h2>Liste des catégories</h2>

<?php while ($cat = $cats->fetch()): ?>
    <p>
        <?php echo htmlspecialchars($cat['name']); ?>
        <a href="Category.php?delete=<?php echo $cat['category_id']; ?>" onclick="return confirm('Supprimer cette catégorie ?');">Supprimer</a>
    </p>
<?php endwhile; ?>

<br>
<a href="account_admin.php">Retour au panneau admin</a>
</body>
</html>