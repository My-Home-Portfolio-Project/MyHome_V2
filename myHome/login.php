<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION["user_id"])) {
    header("Location: renters.php");
    exit;
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $mysqli = require __DIR__ . "/database.php";
        
        // Validate email
        $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $errors[] = "Please enter a valid email address";
        }
        
        // Use prepared statement instead of string interpolation
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $_POST["email"]);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user) {
            if (password_verify($_POST["password"], $user["password_hash"])) {
                session_regenerate_id(true);
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["last_activity"] = time();
                
                $params = session_get_cookie_params();
                setcookie(session_name(), session_id(), [
                    'expires' => time() + $params["lifetime"],
                    'path' => $params["path"],
                    'domain' => $params["domain"],
                    'secure' => true,
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]);
                
                header("Location: renters.php");
                exit;
            }
        }
        
        $errors[] = "Invalid login credentials";
        
    } catch (Exception $e) {
        $errors[] = "An error occurred. Please try again later.";
        error_log("Login error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login to MyHome - Real Estate Connect">
    <title>Login - MyHome</title>
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --background-color: #f5f6fa;
            --text-color: #2c3e50;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            flex-direction: column;
            color: var(--text-color);
        }

        .title-container {
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            z-index: 1000;
            color: white;
            animation: fadeIn 1s ease-in;
        }

        .title-container img {
            height: 40px;
            width: auto;
        }

        .my_home {
            margin: 0;
            font-size: 24px;
        }

        .login-container {
            margin: auto;
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            animation: slideUp 0.8s ease-out;
        }

        header {
            text-align: center;
            color: white;
            margin-bottom: 2rem;
        }

        nav {
            margin-top: 1rem;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            position: relative;
            transition: all 0.3s ease;
        }

        nav a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: white;
            transition: width 0.3s ease;
        }

        nav a:hover::after {
            width: 100%;
        }

        .login-form {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            animation: fadeIn 1s ease-in;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--secondary-color);
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e1e1e1;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        button {
            width: 100%;
            padding: 0.8rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: transform 0.2s ease, background 0.3s ease;
        }

        button:hover {
            background: #357abd;
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }

        .error-message {
            background: #fff;
            color: var(--accent-color);
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            border-left: 4px solid var(--accent-color);
            animation: shake 0.5s ease-in-out;
        }

        p {
            text-align: center;
            margin-top: 1rem;
        }

        p a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        p a:hover {
            color: #357abd;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        /* Floating bubbles animation */
        .bubbles {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .bubble {
            position: absolute;
            bottom: -100px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            opacity: 0.5;
            animation: rise 15s infinite ease-in;
        }

        .bubble:nth-child(1) { left: 10%; animation-duration: 8s; }
        .bubble:nth-child(2) { left: 20%; animation-duration: 12s; animation-delay: 1s; }
        .bubble:nth-child(3) { left: 35%; animation-duration: 10s; animation-delay: 2s; }
        .bubble:nth-child(4) { left: 50%; animation-duration: 15s; animation-delay: 0s; }
        .bubble:nth-child(5) { left: 65%; animation-duration: 11s; animation-delay: 3s; }
        .bubble:nth-child(6) { left: 80%; animation-duration: 13s; animation-delay: 2s; }
        .bubble:nth-child(7) { left: 90%; animation-duration: 9s; animation-delay: 1s; }

        @keyframes rise {
            0% {
                bottom: -100px;
                transform: translateX(0);
            }
            50% {
                transform: translateX(100px);
            }
            100% {
                bottom: 1080px;
                transform: translateX(-200px);
            }
        }
    </style>
</head>
<body>
    <div class="bubbles">
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
    </div>

    <div class="title-container">
        <img src="/static/home.png" alt="myHome Logo" width="40" height="40">
        <h1 class="my_home">myHome</h1>
    </div>
    
    <div class="login-container">
        <header>
            <h1>Real Estate Connect</h1>
            <nav>
                <a href="/">Home</a> | <a href="/about">About</a> | 
                <a href="tel:+254711316745">Contact</a>
            </nav>
        </header>

        <section class="login-form">
            <h2>Login to Your Account</h2>
            
            <?php if (!empty($errors)): ?>
                <div class="error-message">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                           required autocomplete="email">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" 
                           required autocomplete="current-password">
                </div>
                
                <button type="submit">Login</button>
            </form>
            
            <p><a href="/forgot-password">Forgot Password?</a></p>
            <p>Don't have an account? <a href="./register.html">Sign up</a></p>
        </section>
    </div>
</body>
</html>
