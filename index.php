<?php 
/******************************************************************************/
/*																			  */
/* Author: 			Hamad Ahmed 											  */
/* Major:  		    Computer Science										  */
/* Professor Name: 	Dr. Schwesinger											  */
/* Due Date: 		11:00pm, Thursday, December 15, 2022		          	  */
/* Assignment: 	    Final Project	    									  */
/* Filename: 		index.php		    									  */
/* Description:     The purspose of this program is create an expense tracking*/
/*                  web application where a user can keep track of their      */
/*                  expenses.                                                 */
/* Note:            Before running the application, please run the following  */
/*                  commands in the terminal:                                 */
/*                           chmod ugo+w database.db                          */
/*                           chmod ugo+w .                                    */
/*                                                                            */
/******************************************************************************/

session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Expense Tracker</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
            if ( $_SESSION )
            {
                include "navbar.html";
            }
            else
            {
        ?>
        
        <nav>
            <ul>
                <li><a href="sign_in.php">Sign In</a></li>
                <li><a href="sign_up.php">Sign Up</a></li>
            </ul>
        </nav>

        <h1>Welcome to the Expense Tracker!</h1>
        <h3>This is a place where you will be able to keep a log</h3>
        <h3>of your expenses. Expense Tracker is determined to help</h3>
        <h3>you keep your spending under control by having a way of</h3>
        <h3>monitoring your expenses!</h3>
        <h3>First, you must Sign In or Create an Account!</h3>

        <?php
            }
        ?>

        <?php
            require_once("functions.php");

            if ( isset( $_POST['operation'] ) )
            {
                $operation = $_POST['operation'];
                

                // If the operation is create, it creates a log entry
                // and stores it in the database.
                if ( $operation === 'create' 
                    && isset( $_POST['description'] )
                    && isset( $_POST['paid'] )
                    && isset( $_POST['date'] )
                    && isset( $_POST['location'] )
                )
                {
                    $id = mt_rand(0, 20000);
                    $email = $_SESSION['email'];
                    $description = $_POST['description'];
                    $paid = $_POST['paid'];
                    $date = $_POST['date'];
                    $location = $_POST['location'];

                    if ( !insertLog($id, $email, $description, $paid, $date, $location) )
                    {
                        print "<p>An error occured in inserting log!</p>";
                    }
                }
                // If the operation is update, prompts the user for the new
                // password, and updates in the database.
                else if ( $operation === 'update' 
                        && isset( $_POST['password1'] )
                        && isset( $_POST['password2'] )
                )
                {
                    $password1 = $_POST['password1'];
                    $password2 = $_POST['password2'];

                    if ( $password1 === $password2 )
                    {
                        if ( !updatePassword($password1) )
                        {
                            print "<p>An error occured in updating password!</p>";
                        }
                    }
                    else
                    {
                        print "<p>Passwords do not match!</p>";
                    }
                }
                // If the operation is delete, allows the user to delete their
                // existing log entries.
                else if ( $operation === 'delete' && isset($_POST['rows']) )
                {
                    $logs = array();
                    $row = $_POST['rows'];

                    foreach ($row as $r)
                    {
                        $logs[] = explode(',', $r);
                    }

                    foreach ($logs as $data)
                    {
                        try
                        {
                            $db = new PDO("sqlite:database.db");
                            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $sql = "DELETE FROM log WHERE id = ? AND email = ?";
                            $stmt = $db->prepare($sql);
                            $stmt->execute([$data[0], $_SESSION['email']]);
                        }
                        catch (Exception $e)
                        {
                            print "$e\n";
                        }
                    }
                }
            }

                
            if ( isset($_POST['button1']) )
            {
                printAllLogs();
            }
            else if ( isset($_POST['button2']) )
            {
                if ( !printMaxLog() )
                    print "<p>An error occured in printing max log!\n</p>";
            }
            else if ( isset($_POST['button3']) )
            {
                if ( !printMinLog() )
                    print "<p>An error occured in printing min log!\n</p>";
            }
        ?>

    </body>
</html>