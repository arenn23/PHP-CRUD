<?php
require_once "pdo.php";
require_once "head.html";
session_start();


if ( ! isset($_SESSION['user_id'])){
    die('ACCESS DENIED');
}

for($i=1; $i<=9; $i++){
    if (! isset($_POST['year'.$i])) continue;
    if (! isset($_POST['desc'.$i])) continue;
    if (strlen($_POST['year'.$i]) < 1 || strlen($_POST['desc'.$i]) <1) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: add.php");
        return;
    }
    if (!is_numeric($_POST['year'.$i])){
        $_SESSION['error'] = 'Postion year must be numeric';
        header("Location: add.php");
        return;
    }
}

if (isset($_POST['cancel'])){
    header("Location: index.php");
    return;
}

if ( isset($_POST['first_name']) && isset($_POST['last_name'])
     && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary']) && isset($_POST['add'])) {

    // Data validation
    if ( strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: add.php");
        return;
    }

    if (! strpos($_POST['email'],'@')){
        $_SESSION['error'] = "User name must contain @";
        header("Location: add.php");
        return;
    }

    $sql = "INSERT INTO profile (user_id, first_name, last_name, email, headline, summary)
              VALUES (:user_id, :first_name, :last_name, :email, :headline, :summary)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':user_id' => $_SESSION['user_id'],
        ':first_name' => $_POST['first_name'],
        ':last_name' => $_POST['last_name'],
        ':email' => $_POST['email'],
        ':headline' => $_POST['headline'],
        ':summary' => $_POST['summary']));

    $profile_id=$pdo->lastInsertId();

    $rank=1;
    for($j=1; $j<=9; $j++){
        if (! isset($_POST['year'.$j])) continue;
        if (! isset($_POST['desc'.$j])) continue;
        $year = $_POST['year'.$j];
        $desc = $_POST['desc'.$j];

        $stmt1 = $pdo-> prepare("INSERT INTO position (profile_id, rank, year, description) VALUES ( :pid, :year, :rank, :des)");
        $stmt1->execute(array(
            ':pid' => $profile_id,
            ':rank' => $rank,
            ':year' => $year,
            ':des' => $desc)
        );
        $rank++;
    }
    $_SESSION['success'] = 'Record Added';
    header( 'Location: index.php' ) ;
    return;
}

for($j=1; $j<=9; $j++){
    if (! isset($_POST['year'.$j])) continue;
    if (! isset($_POST['desc'.$j])) continue;
    $year = $_POST['year.$j'];
    $desc = $_POST['desc.$j'];

    $stmt = $pdo-> prepare('INSERT INTO position (profile_id, year, description) VALUES ( :pid, :year, :desc)');
    $stmt->execute(array(
        ':pid' => $profile_id,
        ':year' => $year,
        ':desc' => $desc)
    );
}

if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

?>
<p>Add a New Resume</p>
<form method="post">
<p>First Name:
<br>
<input type="text" name="first_name" size="60"> </p>
<p>Last Name:
<br>
<input type="text" name="last_name" size="60"></p>
<p>Email:
<br>
<input type="text" name="email" size="30"></p>
<p>Headline:
<br>
<input type="text" name="headline" size="80"></p>
<p>Summary:
<br>
<textarea name="summary" rows="8" cols="80"></textarea></p>
<p>Position: <input type="submit" id="addPos" value="+">
<div id="position_fields">
</div>
</p>
<p><input type="submit" name="add" value="Add">
<input type="submit" name="cancel" value="Cancel"></p>
</form>
<title>Alan J Renner- Auto Database</title>

<script>
countPos = 0;

$(document).ready(function(){
    $('#addPos').click(function(event){
        event.preventDefault();
        if ( countPos >= 9 ){
            alert("Maximum of nine position entries exceeded");
            return;
        }
        countPos++;
        $('#position_fields').append(
            '<div id="position'+countPos+'"> \
            <p>Year: <input type="text" name="year'+countPos+'" value ="" /> \
            <input type="button" value="-" \
                onclick = "$(\'#position'+countPos+'\').remove();return false;"></p>\
            <textarea name = "desc'+countPos+'" rows="8" cols="80"></textarea>\
            </div>');
    });
});
</script>