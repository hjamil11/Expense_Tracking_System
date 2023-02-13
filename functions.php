<?php
session_start();


/*******************************************************************************/
/* 																               */
/* Function name:	insertAccInfo                                              */
/* Description: 	inserts user account info in the database                  */
/* Parameters:  	string $name - username                                    */
/*                  string $email - user's email                               */
/*                  string $dob - user's date of birth                         */
/*                  string $password - user's account password                 */
/* Return Value: 	bool - true (success) or false (failure)                   */
/* 					    			                                           */
/*******************************************************************************/
function insertAccInfo($name, $email, $dob, $password)
{
    try
    {
        $db = new PDO("sqlite:database.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO user VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute( [$name, $email, $dob, $password] );
        
        return true;
    }   
    catch (Exception $e)
    {
        print "<p>$e</p>";
        return false;
    } 
}


// function getAllLogs()
// {
//     try
//     {
//         $db = new PDO("sqlite:database.db");
//         $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//         $sql = "SELECT * FROM log WHERE email = ?";
//         $stmt = $db->prepare($sql);
//         $stmt->execute( [$_SESSION['email']] );

//         return $stmt->fetch(PDO::FETCH_ASSOC);
//     }
//     catch (Exception $e)
//     {
//         print "<p>$e</p>";
//         return array();
//     }
// }

/*******************************************************************************/
/* 																               */
/* Function name:	printMaxLog                                                */
/* Description: 	prints highest paid log that a user has entered            */
/* Parameters:  	none                                                       */
/* Return Value: 	none                                                       */
/* 					    			                                           */
/*******************************************************************************/
function printMaxLog()
{
    try 
    {
        $db = new PDO("sqlite:database.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM log WHERE email = ? ORDER BY paid DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute( [$_SESSION['email']] );

        $max_log = $stmt->fetch(PDO::FETCH_ASSOC);

       //print_r($max_log);
        
        if ( !$max_log)
            return false;

        $header = array_keys($max_log);
        
        //print_r($header);

        print "<table>\n";
    
        print "<tr>\n";
        foreach ($header as $col)
        {
            print "<th>$col</th>\n";
        }
        print "</tr>\n";

        print "<tr>";
        foreach ($max_log as $log)
        {
                print "<td>$log</td>";    
        }
        print "</tr>\n";
    
        print "</table>\n";

        return true;
    }
    catch (Exception $e)
    {
        print "<p>$e</p>";
        return false;
    }
}

/*******************************************************************************/
/* 																               */
/* Function name:	printMinLog                                                */
/* Description: 	prints least paid log that a user has entered              */
/* Parameters:  	none                                                       */
/* Return Value: 	bool - true (success) or false (failure)                   */
/* 					    			                                           */
/*******************************************************************************/
function printMinLog()
{
    try 
    {
        $db = new PDO("sqlite:database.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM log WHERE email = ? ORDER BY paid ASC";
        $stmt = $db->prepare($sql);
        $stmt->execute( [$_SESSION['email']] );

        $max_log = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ( !$max_log)
            return false;

        $header = array_keys($max_log);

        print "<table>\n";
    
        print "<tr>\n";
        foreach ($header as $col)
        {
            print "<th>$col</th>\n";
        }
        print "</tr>\n";

        print "<tr>";
        foreach ($max_log as $log)
        {
                print "<td>$log</td>";    
        }
        print "</tr>\n";
    
        print "</table>\n";

        return true;
    }
    catch (Exception $e)
    {
        print "<p>$e</p>";
        return false;
    }
}

/*******************************************************************************/
/* 																               */
/* Function name:	displayAllLogs                                             */
/* Description: 	displays all log entries for a user with a checkbox        */
/* Parameters:  	array $log - array of all log entries                      */
/* Return Value: 	none                                                       */
/* 					    			                                           */
/*******************************************************************************/
function displayAllLogs($logs)
{
    if (count($logs) === 0)
        return;
    
    $header = array_keys($logs[0]);

    print "<table>\n";
    print "<tr>";
    print "<th>Select</th>";

    foreach ($header as $h) {
        print "<th>$h</th>";
    }
    print "</tr>\n";

    foreach($logs as $entry)
    {
        $val = array_values($entry);
        $form_value = implode(',', $val);
        
        print "<tr>";
        print "<td><input type=\"checkbox\" name=\"rows[]\" value=\"$form_value\"></td>";
        
        foreach($val as $item)
        {
            print "<td>$item</td>";
        }
        print "</tr>\n";
    }    
    print "</table>";
}


/*******************************************************************************/
/* 																               */
/* Function name:	printAllLog                                                */
/* Description: 	prints all log entries for a user                          */
/* Parameters:  	none                                                       */
/* Return Value: 	none                                                       */
/* 					    			                                           */
/*******************************************************************************/
function printAllLogs()
{
    $db = new PDO("sqlite:database.db");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM log WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute( [$_SESSION['email']] );

    $logs = $stmt->fetchall(PDO::FETCH_ASSOC);
    
    if ( !$logs )
    {
        print "<p>An error occured in getting the logs from the database!</p>";
    }

    $header = array_keys($logs[0]);

    print "<table>\n";

    print "<tr>\n";
    foreach ($header as $col)
    {
        print "<th>$col</th>\n";
    }
    print "</tr>\n";

    foreach ($logs as $log)
    {
        $entry = array_values($log);

        print "<tr>";
        foreach ($entry as $item)
        {
            print "<td>$item</td>";
        }
        print "</tr>\n";
    }

    print "</table>\n";

}

/*******************************************************************************/
/* 																               */
/* Function name:	insertLog                                                  */
/* Description: 	inserts a log entry in the database                        */
/* Parameters:  	int $id - an entry's id number                             */
/*                  string $id - a user's email associated with the entry      */
/*                  string $description - a brief description of the entry     */
/*                  float paid - amount paid                                   */
/*                  string date - date of the entry                            */
/*                  string location - location of the entry                    */
/* Return Value: 	bool - true (success) or false (failure)                   */
/* 					    			                                           */
/*******************************************************************************/
function insertLog($id, $email, $description, $paid, $date, $location)
{
    try
    {
        $db = new PDO("sqlite:database.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO log VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute( [$id, $email, $description, $paid, $date, $location] );

        return true;
    }
    catch (Exception $e)
    {
        print "<p>$e</p>";
        return false;
    }
}


/*******************************************************************************/
/* 																               */
/* Function name:	updatePassword                                             */
/* Description: 	updates user's password in the database                    */
/* Parameters:  	string $password - user's account's new password           */
/* Return Value: 	bool - true (success) or false (failure)                   */
/* 					    			                                           */
/*******************************************************************************/
function updatePassword($newPassword)
{
    try
    {
        $db = new PDO("sqlite:database.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE user SET password = ? WHERE email = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute( [$newPassword, $_SESSION['email']] );

        return true;
    }
    catch (Exception $e)
    {
        print "<p>$e</p>";
        return false;   
    }
}

/*******************************************************************************/
/* 																               */
/* Function name:	getUserInfo                                                */
/* Description: 	attempts to retrieve user's account info from the database */
/* Parameters:  	string $email - user's email                               */
/*                  string $password - user's account password                 */
/* Return Value: 	array - user's info on success or empty array on failure   */
/* 					    			                                           */
/*******************************************************************************/
function getUserInfo($email, $password)
{
    try
    {
        $db = new PDO("sqlite:database.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM user WHERE email = ? and password = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute( [$email, $password] );

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch (Exception $e)
    {
        print "<p>$e</p>";
        return array();
    }
}

?>