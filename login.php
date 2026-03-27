<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login & Register</title>
    <style>
        /* RESET */
        * { margin:0; padding:0; box-sizing:border-box; font-family: Arial, sans-serif; }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #87ceeb, #00cfff); /* Bleu ciel dégradé */
        }

        .container {
            background: #fff;
            width: 400px;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            position: relative;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            padding: 12px 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        input[type="submit"] {
            padding: 12px;
            border:none;
            border-radius: 8px;
            background: #00cfff; /* bleu ciel */
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            background: #00a8cc; /* un bleu ciel plus foncé au hover */
        }

        .switch-form {
            text-align: center;
            margin-top: 10px;
            color: #555;
            cursor: pointer;
        }

        .switch-form span {
            color: #00cfff;
            text-decoration: underline;
        }

        .message {
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .error { background: #f8d7da; color: #721c24; }
        .success { background: #d4edda; color: #155724; }
    </style>
</head>
<body>

<div class="container">

    <?php
    if(isset($_SESSION['error'])){
        echo "<div class='message error'>".$_SESSION['error']."</div>";
        unset($_SESSION['error']);
    }

    if(isset($_SESSION['success'])){
        echo "<div class='message success'>".$_SESSION['success']."</div>";
        unset($_SESSION['success']);
    }
    ?>

   
    <div id="login-form">
        <h2>Connexion</h2>
        <form method="POST" action="connexion.php">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="submit" name="signIn" value="Se connecter">
        </form>
        <div class="switch-form">
            Pas de compte ? <span onclick="showRegister()">S'inscrire</span>
        </div>
    </div>

  
    <div id="register-form" style="display:none;">
        <h2>S'inscrire</h2>
        <form method="POST" action="connexion.php">
            <input type="text" name="name" placeholder="Nom d'utilisateur" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="submit" name="register" value="S'inscrire">
        </form>
        <div class="switch-form">
            Déjà un compte ? <span onclick="showLogin()">Se connecter</span>
        </div>
    </div>

</div>

<script>
    function showRegister(){
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('register-form').style.display = 'block';
    }
    function showLogin(){
        document.getElementById('register-form').style.display = 'none';
        document.getElementById('login-form').style.display = 'block';
    }
</script>

</body>
</html>