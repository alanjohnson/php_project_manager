<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>New Task</title>
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
        echo "<h1>New Task</h1>";
        $file = "projects.xml";
        if (file_exists($file) && '' != file_get_contents($file)) {
            $xml = simplexml_load_file("projects.xml");
            if (count($xml->project) > 0) {
                echo "<p>Please enter the data below to create a new task</p>";
                echo"<form action='createNewTask.php' method='post' enctype='application/x-www-form-urlencoded'>";
                echo"<div class='formbox'><table class='formTable'>";
                echo"<tr><td style=' text-align: right;'>Project:*</td><td><select name='projectName' style='width: 194px'>";
                foreach ($xml->project as $node) {
                    $listItem = $node->attributes()->name;
                    echo "<option value='$listItem'>$listItem</option>";
                }
                echo"</select></td></tr>";
                echo"<tr><td style=' text-align: right;'>Task:*</td><td><input type='text' name='taskName' size='26' /></td></tr>";
                echo"<tr><td style=' text-align: right;'>Rate(hourly):</td><td><input type='text' name='taskRate' size='26' /></td></tr>";
                echo"<tr><td style=' text-align: right;'>Notes:</td><td><input type='text' name='taskNotes' size='26' /></td></tr>";

                echo"</table></div>";
                echo"<p><input type='submit' /></p></form>";
            }
            else{
                echo "<p>You currently have no Projects. You need a project to begin adding tasks</p>";
                echo "<p>Create one now on the <a href=\"newProject.php\">Create Project</a> Page</p>";
            }
        }
        else { // If file does not exist, create one for all projects to be placed in
            echo "<p>You currently have no Projects. You need a project to begin adding tasks</p>";
            echo "<p>Create one now on the <a href=\"newProject.php\">Create Project</a> Page</p>";
        }
        ?>
        <!--W3C validation icons-->
        <div class="footer">
            <a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" style="border: 0px;" /></a>
            <a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="http://www.austincc.edu/jscholl/images/vcss.png" alt="Valid CSS!" height="31" width="88" style="border: 0px;" /></a>
        </div>
        </div>
    </body>
</html>
