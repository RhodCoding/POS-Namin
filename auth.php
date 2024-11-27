<?php
session_start();

// TODO: Replace with database authentication
$valid_users = [
    // Admin users
    'admin' => [
        'password' => 'admin123',
        'role' => 'admin',
        'name' => 'Administrator'
    ],
    // Employee users
    'cashier1' => [
        'password' => 'password123',
        'role' => 'employee',
        'name' => 'John Doe'
    ],
    'cashier2' => [
        'password' => 'password123',
        'role' => 'employee',
        'name' => 'Jane Smith'
    ]
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (isset($valid_users[$username]) && $valid_users[$username]['password'] === $password) {
        // Set common session variables
        $_SESSION['user_id'] = $username;
        $_SESSION['user_name'] = $valid_users[$username]['name'];
        $_SESSION['role'] = $valid_users[$username]['role'];

        // Redirect based on role
        if ($valid_users[$username]['role'] === 'admin') {
            header('Location: admin/dashboard.php'); // Redirect admin to admin dashboard
        } else {
            header('Location: employee/pos.php'); // Redirect employees to POS system
        }
        exit();
    } else {
        $_SESSION['login_error'] = 'Invalid username or password';
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
