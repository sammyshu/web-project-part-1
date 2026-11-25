<?php

session_start();

require_once 'settings.php';

if (isset($_SESSION['login'])) {
    if ($_SESSION['login'] === 'manager')
    {
        header('Location: manage.php');
        exit;
    }
}

$error = '';
$username = '';

if (isset($_POST['username'])) {
    $username = trim($_POST['username']);
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    try {
        $conn = mysqli_connect($db_host, $db_user, $db_pwd, $db_name);
        $stmt = mysqli_prepare($conn, 'SELECT username, password_hash FROM users WHERE username = ?');
        mysqli_stmt_bind_param($stmt, 's', $username); /* in week 11 they only show the object oriented version of this but its the same*/
        mysqli_stmt_execute($stmt);
        $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } catch (mysqli_sql_exception $e) {
        $row = false;
        $db_errors[] = $e->getMessage();
    }

    if ($row && password_verify($password, $row['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = $row['username'];
        $_SESSION['login'] = 'manager';
        header('Location: manage.php');
        exit;
    }
    $error = 'Incorrect username or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="Manager sign in for MatchFit Sports"/>
    <link rel="stylesheet" href="styles/style.css">
    <title>Manager Login | MatchFit Sports</title>
    <style>
    </style>
</head>
<body>
<?php require_once __DIR__ . '/header.inc'; ?>
    <main>
        <div class="container">
            <section aria-labelledby="form-heading">
                <h1 id="form-heading">Manager sign in</h1>
                <?php if ($error !== ''): ?>
                    <p class="error" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>
                <form class = "apply-form" method="post" action="login.php">
                    <div class = "form-field">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>" required autocomplete="username">
                    </div>
                    <div class = "form-field">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required autocomplete="current-password">
                    </div>
                    <div class = "form-actions">
                        <button class="btn-primary" type="submit">Sign in</button>
                </div>
                </form>
            </section>
        </div>
    </main>
    <?php require __DIR__ . '/footer.inc'; ?>
</body>
</html>
