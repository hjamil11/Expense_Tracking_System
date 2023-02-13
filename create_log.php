<!DOCTYPE html>
<html lang=en>
    <head>
        <title>CREATE LOG</title>
        <link rel="stylesheet" href="style.css">
    </head>
    
    <body>
        <?php include "navbar.html" ?>
        <h1>CREATE LOG</h1>

        <form action="index.php" method="post">
            <label class="block">Description: <input type="text" name="description" required></label>
            <label class="block">Amount Paid: <input type="text" name="paid" required></label>
            <label class="block">Date: <input type="date" name="date" required></label>
            <label class="block">Location: <input type="text" name="location" required></label>
            <input type="hidden" name="operation" value="create">
            <input type="submit" value="Create">
        </form>
    </body>
</html>