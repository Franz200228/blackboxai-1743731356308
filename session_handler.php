<?php
session_start();
require 'config.php';

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['error'] = 'Please login first';
        header('Location: login.php');
        exit;
    }
}

function displayMessages() {
    if (isset($_SESSION['error'])) {
        echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">'.$_SESSION['error'].'</div>';
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">'.$_SESSION['success'].'</div>';
        unset($_SESSION['success']);
    }
}
?>