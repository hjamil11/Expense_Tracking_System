<?php session_start(); ?>
<!DOCTYPE html>
<html lang=en>
    <head>
        <title></title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <h2>Delete Entry</h2>
        <?php include "navbar.html"; ?>
        
        <form action="index.php" method="post">
            <?php
                require_once("functions.php");
                
                // Attempts to open the database.
                $db = new PDO("sqlite:database.db");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Attempts to retrieve all users log info from the database.
                $sql = "SELECT * FROM log WHERE email = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute( [$_SESSION['email']] );

                $logs = $stmt->fetchall(PDO::FETCH_ASSOC);

                // Displays the information with a checkbox for all the rows.
                displayAllLogs($logs); 
            ?>

            <input type="hidden" name="operation" value="delete">
            <input type="submit" value="Delete">
        </form>

        
    </body>
</html>