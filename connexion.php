<?php
session_start();

try {
    $db = new PDO("mysql:host=localhost;dbname=prompts;charset=utf8", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERREUR : " . $e->getMessage());
}

if(isset($_POST['register'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if(empty($name) || empty($email) || empty($password)){
        $_SESSION['error'] = "Tous les champs sont obligatoires";
        header("Location: login.php");
        exit();
    }

    $check = $db->prepare("SELECT * FROM users WHERE email = ?");
    $check->execute([$email]);
    if($check->rowCount() > 0){
        $_SESSION['error'] = "Email déjà utilisé";
        header("Location: login.php");
        exit();
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')");
    $stmt->execute([$name, $email, $passwordHash]);

    $_SESSION['success'] = "Compte créé avec succès  Connectez-vous maintenant";
    header("Location: login.php#signin");
    exit();
}

if(isset($_POST['signIn'])){
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if(empty($email) || empty($password)){
        $_SESSION['error'] = "Remplir tous les champs";
        header("Location: login.php#signin");
        exit();
    }

    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($password, $user['password'])){
        $_SESSION['user_id'] = $user['user_id']; 
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        if($user['role'] == 'admin'){
            header("Location: account_admin.php");
            exit();
        } else {
            header("Location: account.php");
                exit();
        }
    } else {
      $_SESSION['error'] = "Email ou mot de passe incorrect";
        header("Location: login.php#signin");
        exit();
    }
}
?>