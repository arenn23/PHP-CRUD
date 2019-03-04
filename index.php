<?php

session_start();
require_once "pdo.php";
require_once "head.html";



if  (isset ($_SESSION['user_id'])){
$user = $_SESSION['user_id'];

    echo('<table border="1">'."\n");
    $stmt = $pdo->query("SELECT first_name, last_name, headline, profile_id FROM profile WHERE user_id = $user");

    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        echo "<tr><td>";
        echo(htmlentities($row['first_name']));
        echo("</td><td>");
        echo(htmlentities($row['last_name']));
        echo("</td><td>");
        echo(htmlentities($row['headline']));
        echo("</td><td>");
        echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
        echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
        echo("</td></tr>\n");
    }
    echo('<a href="add.php">Add New Entry</a>');
    echo('<br>');
    echo('<a href="logout.php">Logout</a>'); 
    
}
else{
    echo('<table border="1">'."\n");
    $stmt = $pdo->query("SELECT first_name, last_name, headline, profile_id FROM profile");

    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        echo "<tr><td>";
        echo(htmlentities($row['first_name']));
        echo("</td><td>");
        echo(htmlentities($row['last_name']));
        echo("</td><td>");
        echo(htmlentities($row['headline']));
        echo("</td></tr>\n");
    }
echo('<a href="login.php">Log In</a>');
}

if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}

?>

<!DOCTYPE html>
<html>
<head>
<title> Alan J Renner Resume </title>
</head>
<body>
</body>
</html>