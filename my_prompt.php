<?php

require 'connexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


if (isset($_POST['delete'])) {
    $id = intval($_POST['delete']);

    $stmt = $db->prepare("DELETE FROM prompts WHERE prompt_id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['success'] = "Prompt supprimé avec succès";
    } else {
        $_SESSION['error'] = "Erreur ou prompt introuvable";
    }

    header("Location: my_prompt.php");
    exit();
}


$stmt = $db->prepare("
    SELECT p.prompt_id, p.title, p.content, c.name AS category
    FROM prompts p
    INNER JOIN categories c ON p.category_id = c.category_id
    WHERE p.user_id = ?
    ORDER BY p.prompt_id DESC
");

$stmt->execute([$user_id]);
$prompts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Mes Prompts</title>

<style>
body {
    font-family: Arial;
    background: #f4f6f9;
    padding: 20px;
}
.container {
    max-width: 800px;
    margin: auto;
}
.card {
    background: #fff;
    padding: 15px;
    margin: 15px 0;
    border-radius: 10px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
}
.title {
    font-weight: bold;
    color: #007BFF;
    font-size: 18px;
}
.category {
    background: #007BFF;
    color: white;
    padding: 4px 8px;
    border-radius: 5px;
    font-size: 12px;
}
.delete-btn {
    background: red;
    color: white;
    padding: 6px 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    float: right;
}
.delete-btn:hover {
    background: darkred;
}
.btn {
    display: block;
    width: 200px;
    margin: 20px auto;
    text-align: center;
    background: green;
    color: white;
    padding: 10px;
    border-radius: 8px;
    text-decoration: none;
}
.success {
    background: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
    text-align: center;
}
.error {
    background: #f8d7da;
    color: #721c24;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
    text-align: center;
}
</style>

</head>
<body>

<div class="container">

<h2>Mes Prompts</h2>

<?php
if (isset($_SESSION['success'])) {
    echo "<div class='success'>".$_SESSION['success']."</div>";
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo "<div class='error'>".$_SESSION['error']."</div>";
    unset($_SESSION['error']);
}
?>

<?php if (empty($prompts)): ?>
    <p style="text-align:center;">Aucun prompt</p>
<?php else: ?>
    <?php foreach ($prompts as $p): ?>
        <div class="card">

            <form method="POST" onsubmit="return confirm('Supprimer ce prompt ?');">
                <input type="hidden" name="delete" value="<?php echo $p['prompt_id']; ?>">
                <button type="submit" class="delete-btn">Supprimer</button>
            </form>

            <div class="title">
                <?php echo htmlspecialchars($p['title']); ?>
            </div>

            <p>
                <?php echo nl2br(htmlspecialchars($p['content'])); ?>
            </p>

            <span class="category">
                <?php echo htmlspecialchars($p['category']); ?>
            </span>

        </div>
    <?php endforeach; ?>
<?php endif; ?>

<a href="account.php" class="btn">Retour</a>

</div>

</body>
</html>