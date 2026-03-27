<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Compte</title>
    <style>
        /* RESET */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to bottom, #1c1c1c, #2c2c2c); /* fond sombre */
            color: #fff;
        }

        h1 {
            margin-bottom: 30px;
            font-size: 36px;
            text-align: center;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.5);
        }

        a {
            color: #1E90FF;
            text-decoration: none;
            margin-bottom: 20px;
            display: inline-block;
            font-size: 18px;
            transition: 0.3s;
        }

        a:hover {
            color: #104E8B;
            text-decoration: underline;
        }

        button {
            background: #1E90FF;
            color: #fff;
            border: none;
            padding: 12px 25px;
            margin: 10px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        button:hover {
            background: #104E8B;
            transform: scale(1.05);
            box-shadow: 0 6px 18px rgba(0,0,0,0.5);
        }

        .button-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h1>Bonjour <?php echo htmlspecialchars($_SESSION['name']); ?></h1>

<a href="diconnexion.php">Déconnexion</a>

<div class="button-container">
    <button onclick="window.location.href='prompt.php';">Add Prompt</button>
    <button onclick="window.location.href='my_prompt.php';">Voir mes prompts</button>
    <button onclick="window.location.href='prompt_autr.php';">Voir les prompts</button>
</div>

</body>
</html>