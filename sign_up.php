<?php
require_once("functions.php");

// If the user enters all the required information
// to sign up, it creates their account and stores it in the database.
if ( isset( $_POST['user'] )
     && isset( $_POST['email'] )
     && isset( $_POST['dob'] )
     && isset( $_POST['password1'] )
     && isset( $_POST['password2'] )
)
{
    $user = $_POST['user'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $p1 = $_POST['password1'];
    $p2 = $_POST['password2'];

    if ( $p1 === $p2 )
    {
        if ( insertAccInfo($user, $email, $dob, $p1) )
        {
            header("Location: sign_in.php");
            exit();
        }
        else
        {
            print "<p>An error occurred in inserting account info!</p>";
        }
    }
    else
    {
        print "<p>Passwords do not match!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Sign Up</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <nav>
            <a href="index.php">HOME</a>
        </nav>

        <h1>SIGN UP</h1>
        <form action="sign_up.php" method="post">
            <label>User Name<input type="text" name="user" required autofocus> </label>
            <br>
            <label>Email<input type="email" name="email" required></label>
            <br>
            <label>Date of birth: <input type="date" name="dob" required></label>
            <br>
            <label>Password<input type="password" name="password1" required></label>
            <br>
            <label>Retype Password<input type="password" name="password2" required></label>
            <br>
            <input type="submit" value="Sign Up">
        </form>

    </body>
</html>

