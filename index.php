<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Alan Johnson - ProjectManager</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="en-us" />
        <link href="myStyle.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <!-- Your page here -->
        <?php
        include('siteNav.php');
        echo"<div class='container'>";
        date_default_timezone_set('America/Chicago'); // set default date to avoid warnings if php.ini does nto have default time zone set.
        echo "<h1>Welcome to Project Manager</h1>";
        ?>
        <h3>This site will enable you to:</h3>
        <ul>
            <li>Create projects</li>
            <li>List projects</li>
            <li>Create Tasks</li>
            <li>List Tasks</li>
            <li>Track time per task</li>
            <li>More to come!</li>
        </ul>
        <!--W3C validation icons-->
        <div class="footer">
            <a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" style="border: 0px;" /></a>
            <a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="http://www.austincc.edu/jscholl/images/vcss.png" alt="Valid CSS!" height="31" width="88" style="border: 0px;" /></a>
        </div>
        </div>
    </body>
</html>

