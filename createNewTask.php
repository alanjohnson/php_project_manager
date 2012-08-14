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
            // Create variables
            $projectName=$_POST['projectName'];
            $newTask=$_POST['taskName'];
            //make sure valid data was entered first (and not just spaces were entered)
            $newTaskCheck = preg_replace('/\s*/m', '', $newTask);
            $ProjectNameCheck = preg_replace('/\s*/m', '', $projectName);
            if ($ProjectNameCheck != "" && $newTaskCheck != ""){
                $taskRate=$_POST['taskRate'];
                if (is_numeric ($taskRate) || $taskRate == "") {
                    if ($taskRate == "") {
                        $taskRate = "noRate";
                    }
                    $taskNotes=$_POST['taskNotes'];
                    if ($taskNotes == "") {
                        $taskNotes = "n/a";
                    }
                    $Duplicate = "false";
                    $CurrentProject = 0;
                    // END Create variables

                    $projectId = -1;
                    // Make sure file and project exists, and find selected projects ID
                    $file = "projects.xml";
                    if (file_exists($file)) {
                        $xml = simplexml_load_file("projects.xml");
                        $i = 0;
                        foreach($xml->project as $project)
                        {
                            if($project['name'] == $projectName)
                            {
                                $projectId = $i;
                                break;
                            }
                            ++$i;
                        }
                    }
                    else{
                        echo "<p>Error loading file!</p>";
                    }
                    if ($projectId != -1){ // make sure the project IS valid
                        // Check if task already exists
                        if (count($xml->project[$projectId]->task) > 0) {
                            foreach ($xml->project[$projectId]->task as $node) {
                                if ($node->attributes()->name == $newTask) {
                                    $Duplicate = "true";
                                }
                            }
                        }
                        if ($Duplicate == "false") {
                            $task = $xml->project[$projectId]->addChild("task");
                            $task->addAttribute('name',htmlspecialchars(utf8_encode($newTask)));
                            $task->addAttribute('rate',htmlspecialchars(utf8_encode($taskRate)));
                            $task->addAttribute('status','In Progress');
                            $task->addAttribute('notes',htmlspecialchars(utf8_encode($taskNotes)));
                            //$xml->asXML("projects.xml"); // Would use instead of DOM code below if didn't care about indenting
                            //Using DOM just to save XML with indent tree rather than one line
                                $dom = new DOMDocument('1.0');
                                $dom->preserveWhiteSpace = false;
                                $dom->formatOutput = true;
                                $dom->loadXML($xml->asXML());
                                //Save XML to file - remove this and following line if save not desired
                                $dom->save('projects.xml');
                            //END Using DOM just to save XML with indent tree rather than one line
                            echo "<p>Task added</p>";
                        }
                        else {
                            echo "<p>This Task already exists!</p>";
                            echo "<p>Back to <a href=\"newTask.php\">Create Task</a> Page</p>";
                        }
                    }
                    else {
                        echo "<p>You did not enter a valid Project Name.</p>";
                        echo "<p>Back to <a href=\"newTask.php\">Create Task</a> Page</p>";
                    }
                }else {
                    echo "<p>Hourly Rate must be a numeric value.</p>";
                    echo "<p>Back to <a href=\"newTask.php\">Create Task</a> Page</p>";
                    }
            }else {
                echo "<p>Please be sure to enter both Project and Task Names.</p>";
                echo "<p>Back to <a href=\"newTask.php\">Create Task</a> Page</p>";
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
