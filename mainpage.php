<?php
require "config.php";
$flag = 0;
$idUSer = "";
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
   if (isset($_GET["id"])){
       $idUSer=$_GET["id"];
   }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = "";
    $password = "";
    $email = "";
    if (isset($_POST["username"])) {
        $username = $_POST["username"];
    }
    if (isset($_POST["password"])) {
        $password = $_POST["password"];
    }
    if(isset($_POST["email"])){
        $email = $_POST["email"];
    }

    if(isset($_POST["addUser"])) {
        $result = $conn->query("INSERT INTO account (user_name, password, email) VALUES ('$username', '$password', '$email')");
        if ($result == TRUE) {
            $flag = 1;
        } else {
            $flag = -1;
        }
    } else if(isset($_POST["updateUser"])) {
        $id = $_POST["id"];
        $result = $conn->query("UPDATE account SET user_name = '$username', password = '$password', email = '$email' WHERE account_id = '$id'");
        if ($result == TRUE) {
            $flag = 2;
        } else {
            $flag = -2;
        }
    } else if(isset($_POST["deleteUser"])) {
        $id = $_POST["id"];
        $result = $conn->query("DELETE FROM account WHERE account_id = '$id'");
        if ($result == TRUE) {
            $flag = 3;
        } else {
            $flag = -3;
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body,html {
            height: 100%;
            background-color: lightgray;
        }
        .row{
            margin: 1%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #formDiv{
            padding: 2%;
            background-color: lightblue;
            box-shadow: 3px 3px 25px black;
            border-radius: 10px;
        }
        #tableDiv{
            box-shadow: 3px 3px 30px black;
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div id="formDiv" class="col-md-8">
            <form id="form" action="MainPage.php" method="post">
                <div class="form-group">
                    <label >username</label>
                    <input type="text" class="form-control" placeholder="username" name="username" id="username" required>
                </div>
                <div class="form-group">
                    <label >password</label>
                    <input type="password" class="form-control" placeholder="password" name="password" id="password" required>
                </div>
                <div class="form-group">
                    <label >Email address</label>
                    <input type="email" class="form-control" name="email" placeholder="Email address" id="email" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="addUser" class="btn btn-primary" value="Add User">
                    <input type="submit" name="updateUser" class="btn btn-primary" value="Update User">
                    <input type="submit" name="deleteUser" class="btn btn-primary" value="Delete User">
                </div>

                <input type="hidden" name="id" id="hideId">
            </form>
            <div class="<?php if($flag == 1 || $flag == 2 || $flag == 3){ echo "alert alert-success";} else if ($flag == -1 || $flag == -2 || $flag == -3){ echo "alert alert-danger";} ?>">
                <?php
                if($flag == 1){
                    echo "User added successfully";
                } else if($flag == -1){
                    echo "User not added";
                } else if($flag == 2){
                    echo "User updated successfully";
                } else if($flag == -2){
                    echo "User not updated";
                } else if($flag == 3){
                    echo "User deleted successfully";
                } else if($flag == -3){
                    echo "User not deleted";
                }
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="tableDiv">
            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Email Address</th>
                </tr>
                <?php
                    $result = $conn->query("SELECT * FROM account");
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                ?>
                            <tr onclick="getData(this);">
                                <td><?php echo $row['account_id']; ?></td>
                                <td><?php echo $row['user_name']; ?></td>
                                <td><?php echo $row['password']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                            </tr>
                <?php
                        }
                    }
                ?>
            </table>
        </div>
    </div>
</div>

<script>
    <?php
        $str = "";
    $result = $conn->query("SELECT * FROM account");
    if($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $str .= $row['account_id'] . ",";
        }
    }
    ?>

    var str = <?php echo json_encode($str); ?>;
    var contr = str.split(",");
    function getData(x){
        arr = x.children;
        document.getElementById("username").value = arr[1].innerHTML.trim();
        document.getElementById("password").value = arr[2].innerHTML.trim();
        document.getElementById("email").value = arr[3].innerHTML.trim();
        document.getElementById("hideId").value = arr[0].innerHTML.trim();
    }
</script>

</body>
</html>
