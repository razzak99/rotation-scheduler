<?php
session_start();
if (!isset($_SESSION['logged']) && basename($_SERVER['PHP_SELF']) !== 'index.php') {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>People Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">People Admin</a>
    <div class="d-flex">
      <?php if (isset($_SESSION['logged'])): ?>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<div class="container">