<?php
require 'config.php';
require 'session_handler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validate inputs
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = 'Please fill in all fields';
        header('Location: login.php');
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Login successful
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        
        if (isset($_POST['ajax'])) {
            echo json_encode(['success' => true, 'message' => 'Login successful!']);
            exit;
        } else {
            $_SESSION['success'] = 'Login successful!';
            header('Location: dashboard.php');
            exit;
        }
    } else {
        if (isset($_POST['ajax'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
            exit;
        } else {
            $_SESSION['error'] = 'Invalid email or password';
            header('Location: login.php');
            exit;
        }
    }
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Database error: ' . $e->getMessage();
        header('Location: login.php');
        exit;
    }
} else {
    // Not a POST request
    header('Location: login.php');
    exit;
}
?>