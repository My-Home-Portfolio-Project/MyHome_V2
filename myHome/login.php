<?php
$is_invalid = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$mysqli = require __DIR__ . "/database.php";
	$sql = sprintf("SELECT * FROM users WHERE email = '%s'",
		$mysqli->real_escape_string($_POST["email"]));
	$result = $mysqli->query($sql);
	$user = $result->fetch_assoc();
	if ($user) {
		if (password_verify($_POST["password"], $user["password_hash"])) {
			session_start();
			session_regenerate_id();
			$_SESSION["user_id"] = $user["id"];
			header("Location: renters.php");
			exit;
		}
		}

$is_invalid = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MyHome</title>
    <link rel="stylesheet" href="/static/styles2.css">
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .title-container {
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background: transparent;
            z-index: 1000;
        }

        .title-container img {
            height: 40px;
            width: auto;
        }

        .my_home {
            margin: 0;
            font-size: 24px;
        }

        /* Adjust login container to not overlap with header */
        .login-container {
            margin-top: 80px; /* Provide space for fixed header */
        }
    </style>
</head>
<body>
    <!-- Moved to top left -->
    <div class="title-container">
        <img src="/static/home.png" alt="myHome Logo">
        <h1 class="my_home">myHome</h1>
    </div>

    <div class="login-container">
        <header>
            <h1>Real Estate Connect</h1>
<?php if ($is_invalid): ?>
<em>login details not valid</em>
<?php endif; ?> 
            <nav>
                <a href="/">Home</a> | <a href="/about">About</a> | <a href="/+254711316745">Contact</a>
            </nav>
        </header>

        <section class="login-form">
            <h2>Login to Your Account</h2>
            <form method="POST">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Login</button>
                 

            </form>
            <p><a href="/forgot-password">Forgot Password?</a></p>
            <p>Don't have an account? <a href="./register.html">Sign up</a></p>
        </section>
    </div>
</body>
</html>  
