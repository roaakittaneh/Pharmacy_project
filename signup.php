<?php
require "config.php";

// Define variables and initialize with empty values
$username = $email = $password = "";
$username_err = $email_err = $password_err = "";

// Process the form when it's submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Username
    if (empty(trim($_POST["name"]))) {
        $username_err = "Please enter your full name.";
    } else {
        $username = trim($_POST["name"]);
    }

    // Validate Email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email address.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate Password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (!preg_match("/^\d+$/", trim($_POST["password"]))) {
        $password_err = "Password must contain only numbers.";
    } else {
        $password = trim($_POST["password"]);
    }

    // If no errors, proceed with database insertion
    if (empty($username_err) && empty($email_err) && empty($password_err)) {
        // Prepare an insert statement
        $stmt = $conn->prepare("INSERT INTO account (user_name, password, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $email);  // "sss" means the parameters are strings

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>
                    alert('Sign Up Successful');
                    window.location.href = 'home.html'; // Redirect to home page
                  </script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up & Log In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="home">
        <nav>
            <a class="logo">
                <i class="fa-solid fa-leaf"></i>
                <h3>pharmacy</h3>
            </a>
            <div class="nav">
                <a href="home.html">Home</a>
                <a href="product.html">Products</a>
                <a href="home.html#aboutas">About Us</a>
                <a href="cart.html">My Cart</a>
                <a href="http://localhost/phpuser/signup.php">Sign Up</a>
            </div>
        </nav>
    </div>
    <div class="form-box">
        <!-- Sign Up Form -->
        <div id="signup-form" class="form">
            <span class="title">Sign Up</span>
            <span class="subtitle">Create a free account with your email.</span>
            <div class="form-container">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="text" class="input" id="signup-name" name="name" placeholder="Full Name" required value="<?php echo $username; ?>">
                    <span class="error"><?php echo $username_err; ?></span>
                    
                    <input type="email" class="input" id="signup-email" name="email" placeholder="Email" required value="<?php echo $email; ?>">
                    <span class="error"><?php echo $email_err; ?></span>
                    
                    <input type="password" class="input" id="signup-password" name="password" placeholder="Password" required value="<?php echo $password; ?>">
                    <span class="error"><?php echo $password_err; ?></span>
                    
                    <button type="submit">Sign Up</button>
                </form>
            </div>
            <div class="form-section">
                <p>Already have an account? <a href="http://localhost/phpuser/login.php" onclick="showLogin()">Log In</a></p>
            </div>
        </div>

        <!-- Log In Form -->
        <div id="login-form" class="form hidden">
            <span class="title">Log In</span>
            <span class="subtitle">Access your account using your email and password.</span>
            <div class="form-container">
                <input type="email" class="input" id="login-email" placeholder="Email" required>
                <input type="password" class="input" id="login-password" placeholder="Password" required>
            </div>
            <button onclick="logIn()">Log In</button>
            <div class="form-section">
                <p>Don't have an account? <a href="#" onclick="showSignUp()">Sign Up</a></p>
            </div>
        </div>
    </div>
</body>
</html>
