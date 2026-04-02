<?php
session_start();

if (isset($_POST['user']) && isset($_POST['pass'])) {
    if ($_POST['user'] === "admin" && $_POST['pass'] === "12345") {
        $_SESSION['logged'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid login";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login - People Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h4 class="card-title mb-3 text-center">Admin Login</h4>
          <?php if (!empty($error)): ?>
            <div class="alert alert-danger py-2"><?= $error ?></div>
          <?php endif; ?>
          <form method="POST">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="user" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="pass" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>