<?php 

session_start();
require_once "pdo.php";
require_once "head.html";

$salt = 'XyZzy12*_';

if ( isset($_POST['email']) && isset($_POST['pass']) ) {
$check = hash('md5', $salt.$_POST['pass']);
$stmt = $pdo->prepare("SELECT user_id, name FROM users
WHERE email = :em AND password = :pw");
$stmt->execute(array(
':em' => $_POST['email'],
':pw' => $check));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
print_r($row);

    if ( $row !== false ) {
        header("Location: index.php");
        error_log("Login success ".$_POST['email']);
        $_SESSION['name'] = $_row['name'];
        $_SESSION['user_id'] = $row['user_id'];
    return;
    } 
    else {
        $_SESSION['failure'] = "Incorrect password";
        header("Location: login.php");
        error_log("Login fail ".$_POST['email']." $check");
        return;
    }
}

if ( isset($_POST['cancel'] ) ) {
    header("Location: index.php");
    return;
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Alan J Renner Login Page</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>

<?php
if (isset($_SESSION['failure'])){
    echo('<p style="color: red;">'.$_SESSION['failure']."</p>\n");
    unset($_SESSION['failure']);
}

?>

<form method="POST">
<label for="email">Email</label>
<input type="text" name="email" id="email"><br/>
<label for="id_1723">Password</label>
<input type="password" name="pass" id="id_1723"><br/>
<input type="submit" onclick="return validate();" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<!-- Hint: 
The account is umsi@umich.edu
The password is the three character name of the 
programming language used in this class (all lower case) 
followed by 123. -->
</div>
<script>
    function validate(){
        addr = document.getElementById('email').value;
        pw = document.getElementById('id_1723').value;
        if (addr == null || addr == "" || pw == null || pw == ""){
            alert("Both fields must be filled out");
            return false
        }
        if (addr.indexOf('@') == -1){
            alert("Invalid email address");
            return false;
        }
    }
</script>
</body>