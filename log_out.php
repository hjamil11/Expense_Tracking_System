<?php
// If the user log's out, it unset the session variables
// and then destroys them.
session_start();
session_unset();
session_destroy();
header("Location: index.php");
?>