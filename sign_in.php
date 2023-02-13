<?php

// If a user's log in creditials match the ones in database,
// it allows them to access their account.
require_once("functions.php");

if ( isset( $_POST['email'] )
    && isset( $_POST['password'] )
)
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = getUserInfo($email, $password);

    if ( $user )
    {
        session_start();
        $_SESSION += $user;
        header("Location: index.php");
        exit();
    }
    else
    {
        print "<p>Account does not exist!</p>";
    }
}
?>

<!DOCTYPE>
<html lang="en">
    <head>
        <title>HOME</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <nav>
            <a href="index.php">HOME</a>
        </nav>

        <h1>SIGN IN</h1>

        <form action="sign_in.php" method="post">
            <label>Email <input type="email" name="email" required autofocus></label>
            <br>
            <label>Password <input type="password" name="password" required></label>
            <br>
            <input type="submit" value="Sign In">
        </form>
    </body>
</html>

