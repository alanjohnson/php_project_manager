<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Your Tasks</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="en-us" />
        <link href="myStyle.css" rel="stylesheet" type="text/css" />
    </head>
    <body> 
        <!-- Your page here -->
        <?php
        include('siteNav.php');
        echo"<div class='container'>";
        echo"<h1>Your Tasks</h1>";
        $file = "projects.xml";
        if (file_exists($file) && '' != file_get_contents($file)) {
            $xml = simplexml_load_file("projects.xml");
            if (count($xml->project) > 0) {
                foreach ($xml->project as $node) {
                    // This prints out each of the projects tasks
                    $project = $node->attributes()->name;
                    echo "<h3>Project: ".$project."</h3>";
                    if (count($node->task) > 0) {
                        echo"<table class='tasktable'><tr><th class='td1'>Task</th><th class='td2'>Rate</th><th class='td3'>Status</th><th class='td4'>Notes</th></tr>";
                        foreach ($node->task as $task) {
                            $taskName = $task->attributes()->name;
                            $taskRate = $task->attributes()->rate;
                            $taskComplete = $task->attributes()->status;
                            $taskNotes = $task->attributes()->notes;
                            echo"<tr><td>".$taskName."</td><td>$".$taskRate."</td>";
                            if ($taskComplete == 'In Progress'){echo"<td><img src='../images/statusInProgress.gif' alt='status' title='In Progress' style='display: block; margin:auto;' /></td>";}
                                else if ($taskComplete == 'Complete'){echo"<td><img src='../images/statusCompleted.gif' alt='status' title='Completed' /></td>";}
                                else if ($taskComplete == 'Cancelled'){echo"<td><img src='../images/statusCancelled.gif' alt='status' title='Cancelled' /></td>";}
                                else{echo"<td></td>";}
                            if($taskNotes == "n/a") {
                                echo"<td></td></tr>";
                            }
                            else {
                                echo"<td><img src='../images/notepad.gif' alt='notepad' title='".$taskNotes."' /></td></tr>";
                            }
                        }
                        echo"</table>";
                    }
                    else {
                        echo "<p>You currently have no tasks for this project.<br />";
                        echo "Create one now on the <a href=\"newTask.php\">Create Task</a> Page</p>";
                    }
                }
            }
            else {
                //If the file exists but there are no projects in it
                echo "<p>You currently have no Projects or tasks. You need a project to begin adding tasks</p>";
                echo "<p>Create one now on the <a href=\"newProject.php\">Create Project</a> Page</p>";
            }
        }
        else { // If file does not exist
            echo "<p>You currently have no Projects or tasks. You need a project to begin adding tasks</p>";
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
