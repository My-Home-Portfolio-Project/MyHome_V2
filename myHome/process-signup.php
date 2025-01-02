
<?php
if (empty($_POST["name"])) {
    die("Name is required");
}
if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format");
}
if (strlen($_POST["password"]) < 9) {
    die("Password must be at least 9 characters long");
}
if (!preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}
if (!preg_match("/[A-Z]/", $_POST["password"])) {
    die("Password must contain at least one uppercase letter");
}
if (!preg_match("/[a-z]/", $_POST["password"])) {
    die("Password must contain at least one lowercase letter");
}
if ($_POST["password"] !== $_POST["confirm_password"]) {
    die("Passwords do not match");
}

// Hash the password
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param(
    "sss",
    $_POST["name"],
    $_POST["email"],
    $password_hash    
);
if ($stmt->execute()) {
	echo "Signup is succesfull";
} else {
	if ($mysqli->errno === 1062)
	{
		die("email already taken");
	} else {
		die($mysqli->error . " " . $mysqli->errno);
	}
}

