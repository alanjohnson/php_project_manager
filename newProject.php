<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>New Project</title>
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
        echo "<h1>New Project</h1>";
        echo "<p>Please enter the data below to create a new project</p>";
        ?>
        <form action="createNewProject.php" method="post" enctype="application/x-www-form-urlencoded">
            <div class="formbox">
                <table class="formTable">
                    <tr><td style=" text-align: right;">Client:*</td><td><input type="text" name="clientName" size="30" /></td></tr>
                    <tr><td style=" text-align: right;">Project:*</td><td><input type="text" name="projectName" size="30" /></td></tr>
                    <tr><td style=" text-align: right;">Bid: </td><td><input type="text" name="projectBid" size="30" /></td></tr>
                    <tr><td style=" text-align: right;">Notes: </td><td><input type="text" name="projectNotes" size="30" /></td></tr>
                </table>
            </div>
            <p>
                <input type="submit" />
            </p>
        </form>
        <!--W3C validation icons-->
        <div class="footer">
            <a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" style="border: 0px;" /></a>
            <a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="http://www.austincc.edu/jscholl/images/vcss.png" alt="Valid CSS!" height="31" width="88" style="border: 0px;" /></a>
        </div>
        </div>
    </body>
</html>
