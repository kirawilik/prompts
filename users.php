<?php
require 'connexion.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$cats = $db->query("SELECT category_id, name FROM categories ORDER BY name ASC");

$selected_category = '';
$whereCategory = '';
$params = [];
if (isset($_POST['filter_category'])) {
    $selected_category = intval($_POST['category_filter']);
    $whereCategory = " AND p.category_id = ?";
    $params[] = $selected_category;
}

$sql = "
    SELECT u.user_id, u.name AS username, u.email, p.title AS prompt_title, p.content AS prompt_content, c.name AS category
    FROM users u
    LEFT JOIN prompts p ON u.user_id = p.user_id
    LEFT JOIN categories c ON p.category_id = c.category_id
    WHERE 1=1 $whereCategory
    ORDER BY u.name
";
$stmt = $db->prepare($sql);
$stmt->execute($params);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$usersData = [];
foreach ($users as $row) {
    $id = $row['user_id'];
    if (!isset($usersData[$id])) {
        $usersData[$id] = [
            'name' => $row['username'],
            'email' => $row['email'],
            'prompts' => []
        ];
    }
    if ($row['prompt_title']) {
        $usersData[$id]['prompts'][] = [
            'title' => $row['prompt_title'],
            'content' => $row['prompt_content'],
            'category' => $row['category']
        ];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin - Utilisateurs & Prompts</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 20px; }
        .user-card { 
            background: #fff; border-radius: 10px; padding: 15px; margin: 10px 0; 
            display: flex; align-items: center; cursor: pointer; box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .avatar {
            width: 50px; height: 50px; border-radius: 50%; 
            background: #007BFF; color: #fff; display: flex; align-items: center; justify-content: center;
            font-weight: bold; font-size: 18px; margin-right: 15px;
        }
        .user-info h3 { margin: 0; }
        .prompts { display: none; margin-left: 65px; margin-top: 10px; }
        .prompts p { background: #f9f9f9; padding: 10px; border-radius: 5px; }
        .filter-form { margin-bottom: 20px; }
        .filter-form select { padding: 5px; font-size: 14px; }
        .filter-form button { padding: 5px 10px; font-size: 14px; }
    </style>
</head>
<body>

<h1>Bonjour Admin <?php echo htmlspecialchars($_SESSION['name']); ?></h1>
<a href="diconnexion.php">Déconnexion</a>

<h2>Filtrer les utilisateurs par catégorie de prompt</h2>
<form method="POST" class="filter-form">
    <select name="category_filter" required>
        <option value="">--Choisir une catégorie--</option>
        <?php while ($cat = $cats->fetch(PDO::FETCH_ASSOC)): ?>
            <option value="<?php echo $cat['category_id']; ?>" <?php if($selected_category == $cat['category_id']) echo "selected"; ?>>
                <?php echo htmlspecialchars($cat['name']); ?>
            </option>
        <?php endwhile; ?>
    </select>
    <button type="submit" name="filter_category">Filtrer</button>
</form>

<h2>Liste des utilisateurs</h2>

<?php foreach ($usersData as $id => $user): 
    $initials = strtoupper($user['name'][0]);
?>
<div class="user-card" onclick="togglePrompts(<?php echo $id; ?>)">
    <div class="avatar"><?php echo $initials; ?></div>
    <div class="user-info">
        <h3><?php echo htmlspecialchars($user['name']); ?></h3>
        <small><?php echo htmlspecialchars($user['email']); ?></small>
    </div>
</div>
<div class="prompts" id="prompts-<?php echo $id; ?>">
    <?php if (!empty($user['prompts'])): ?>
        <?php foreach ($user['prompts'] as $prompt): ?>
            <p>
                <strong>Prompt:</strong> <?php echo htmlspecialchars($prompt['title']); ?><br>
                <strong>Contenu:</strong> <?php echo htmlspecialchars($prompt['content']); ?><br>
                <strong>Catégorie:</strong> <?php echo htmlspecialchars($prompt['category']); ?>
            </p>
        <?php endforeach; ?>
    <?php else: ?>
        <p><em>Aucun prompt créé</em></p>
    <?php endif; ?>
</div>
<?php endforeach; ?>

<script>
function togglePrompts(userId) {
    const el = document.getElementById('prompts-' + userId);
    el.style.display = (el.style.display === 'block') ? 'none' : 'block';
}
</script>

<br>
<a href="account_admin.php">Retour au panneau admin</a>

</body>
</html>