<?php
require "config.php";
$flag = 0;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = "";
    $password = "";
    if (isset($_POST["username"])) {
        $username = $_POST["username"];
    }
    if (isset($_POST["password"])) {
        $password = $_POST["password"];
    }
    // Query updated to match table and column names

  
    $result = $conn->query("SELECT * FROM account WHERE email = '$username' AND password = '$password'");
    if ($result->num_rows > 0) {
        if ($row = $result->fetch_assoc()) {
            // Assuming the 'role' and 'id' columns exist in your 'account' table
            if ($row['role'] == "1") {
                header("Location: MainPage.php?id=" . $row['account_id']);
            } else {
                header("Location: /phpuser/home.html");
            }
        }
    } else {
        $flag = 1;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <style>
        html, body {
            background-color: lightgray;
            height: 100%;
        }

        #parentLoginDiv {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            border: 1px solid black;
        }

        .container-fluid {
            height: 100%;
        }

        #loginDiv {
            border-radius: 5%;
            background-color: lightpink;
            box-shadow: 5px 5px 15px black;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row" id="parentLoginDiv">
        <div id="loginDiv" class="col-md-3">

            <form method="POST" action="login.php">
                <div class="form-group">
                    <label>Email address</label>
                    <input type="text" class="form-control" id="username" name="username"
                           placeholder="Enter your username">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="Enter your password">
                </div>
                <div class="<?php if ($flag == 1) { echo "alert alert-danger"; } ?>">
                    <?php
                    if ($flag == 1) {
                        echo "Username or password is incorrect";
                    }
                    ?>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Login">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
