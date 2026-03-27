<?php

require 'connexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$cats = $db->query("SELECT category_id, name FROM categories ORDER BY name ASC");

if (isset($_POST['add_prompt'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category_id = intval($_POST['category_id']); 
    $user_id = $_SESSION['user_id'];

    if (empty($title) || empty($content) || empty($category_id)) {
        $error = "Tous les champs sont obligatoires";
    } else {
        $stmt = $db->prepare("INSERT INTO prompts (title, content, category_id, user_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $content, $category_id, $user_id]);
        $success = "Prompt ajouté avec succès !";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Prompt</title>
</head>
<body>
<h2>Ajouter un Prompt</h2>

<?php
if (isset($error)) echo "<p style='color:red;'>$error</p>";
if (isset($success)) echo "<p style='color:green;'>$success</p>";
?>

<form method="POST">
    <input type="text" name="title" placeholder="Titre du prompt" required><br><br>
    <textarea name="content" placeholder="Contenu du prompt" rows="5" cols="50" required></textarea><br><br>
    
    <label>Catégorie :</label>
    <select name="category_id" required>
        <option value="">--Choisir une catégorie--</option>
        <?php while ($cat = $cats->fetch(PDO::FETCH_ASSOC)): ?>
            <option value="<?php echo $cat['category_id']; ?>">
                <?php echo htmlspecialchars($cat['name']); ?>
            </option>
        <?php endwhile; ?>
    </select><br><br>

    <button type="submit" name="add_prompt">Ajouter le prompt</button>
</form>

<br>
<a href="account.php">Retour au compte</a>
</body>
</html>