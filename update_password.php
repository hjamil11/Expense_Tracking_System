<!DOCTYPE html>
<html lang=en>
    <head>
        <title>Update Password</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <?php include "navbar.html" ?>

        <form action="index.php" method="post">
            <label>New password: <input type="password" name="password1" required></label>
            <br>
            <label>Confirm password: <input type="password" name="password2" required></label>
            <br>
            <input type="hidden" name="operation" value="update">
            <input type="submit" value="Update">
        </form>
    </body>
</html>