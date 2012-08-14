<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Time Sheet</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="en-us" />
        <link href="myStyle.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
            /* <![CDATA[ */
            function setTime(formNum,inOut){
                var now = new Date();
                var curr_date = now.getDate();
                var curr_month = now.getMonth();
                curr_month++;
                var curr_year = now.getFullYear();
                var date = curr_month + "/" + curr_date + "/" + curr_year;
                var ampm = "";
                var hour = now.getHours();
                if (hour < 12) {ampm = "AM";}
                else{ampm = "PM";}
                if (hour == 0){hour = 12;}
                if (hour > 12){hour = hour - 12;}
                var min = now.getMinutes();
                min = min + "";
                if (min.length == 1) {min = "0" + min;}
                var curTime = hour + ":" + min;
                if(inOut == "in"){
                    document.forms[formNum].dateIn.value=date;
                    document.forms[formNum].timeIn.value=curTime;
                    document.forms[formNum].ampmIn.value=ampm;
                }
                else{
                    document.forms[formNum].dateOut.value=date;
                    document.forms[formNum].timeOut.value=curTime;
                    document.forms[formNum].ampmOut.value=ampm;
                }
            }
            /* ]]> */
        </script>
    </head>
    <body> 
        <!-- Your page here -->
        <?php
        include('siteNav.php');
        echo"<div class='container'>";
        echo"<h1>Time Sheet</h1>";
        date_default_timezone_set('America/Chicago'); // set default date to avoid warnings if php.ini does nto have default time zone set.
        include 'getTotalTime.php';
        $file = "projects.xml";
        //Check if file exists, and that it's not empty
        if (file_exists($file) && '' != file_get_contents($file)) {
            $xml = simplexml_load_file("projects.xml");
            if (count($xml->project) > 0) {
                $i=0;
                $projectID=0;
                foreach ($xml->project as $node) {
                    // This prints out each of the projects tasks
                    $project = $node->attributes()->name;
                    echo "<h3>Project: ".$project."</h3>";
                    if (count($node->task) > 0) {
                        echo"<table class='timesheet'><tr><th class='td1'>Task</th><th class='td2'>Rate</th><th class='td3'>Status</th><th class='td4'>Notes</th><th class='td5'>Time In</th><th class='td6'>Time Out</th><th class='td7'>Total Time</th><th class='td8'></th></tr></table>";
                        $taskID = 0;

                        foreach ($node->task as $task) {
                            $taskName = $task->attributes()->name;
                            $taskRate = $task->attributes()->rate;
                            $taskComplete = $task->attributes()->status;
                            $taskNotes = $task->attributes()->notes;
                            $total = getTotalTime($projectID, $taskID);
                            echo"<form action='timeTracker.php' method='post' enctype='application/x-www-form-urlencoded'><table class='timesheet'><tr><td class='td1'>".$taskName."</td><td class='td2'>$".$taskRate."</td>";


                            if ($taskComplete == 'In Progress'){echo"<td class='td3'><img src='../images/statusInProgress.gif' alt='status' title='In Progress' style='display: block; margin:auto;' /></td><td class='td4'>";}
                                else if ($taskComplete == 'Complete'){echo"<td class='td3'><img src='../images/statusCompleted.gif' alt='status' title='Completed' /></td><td class='td4'>";}
                                else if ($taskComplete == 'Cancelled'){echo"<td class='td3'><img src='../images/statusCancelled.gif' alt='status' title='Cancelled' /></td><td class='td4'>";}
                                else{echo"<td class='td3'></td><td class='td4'>";}
                            if($taskNotes == "n/a"){
                                echo "</td>";
                            }
                            else{
                                echo "<img src='../images/notepad.gif' alt='notepad' title='".$taskNotes."' /></td>";
                            }
                            echo"<td class='td5'><input type='hidden' name='projectID' value='".$projectID."' /><input type='hidden' name='project' value='".$project."' /><input type='hidden' name='task' value='".$taskName."' /><input type='hidden' name='taskID' value='".$taskID."' />";
                            echo"<img src='../images/stopWatch.gif' class='imgbutton' style='vertical-align:middle' alt='Set to NOW' title='Set to NOW' onclick='setTime(".$i.",\"in\");' /><input type='text' name='dateIn' value='".date('n/j/Y')."' size='6' maxlength='10' /><input type='text' name='timeIn' size='4' maxlength='5' /><select name='ampmIn'><option>AM</option><option>PM</option></select></td>";
                            echo"<td class='td6'><img src='../images/stopWatch.gif' class='imgbutton' style='vertical-align:middle' alt='Set to NOW' title='Set to NOW' onclick='setTime(".$i.",\"out\");' /><input type='text' name='dateOut' value='".date('n/j/Y')."' size='6' maxlength='10' /><input type='text' name='timeOut' size='4' maxlength='5' /><select name='ampmOut'><option>AM</option><option>PM</option></select></td><td class='td7'><b>$total</b></td>";
                            echo"<td class='td8'><input type='submit' value='add' /></td></tr></table></form>";
                            ++$i;
                            ++$taskID;
                            //------------------ Code here for listing existing time tables
                            if (count($task->interval) > 0) {
                                foreach ($task->interval as $interval) {
                                    $interval = explode(",", $interval);
                                    $timeIn = $interval[0];
                                    $timeOut = $interval[1];
                                    $hoursDiff = floor((strtotime($timeOut) - strtotime($timeIn)) / 3600);
                                    $minutesDiff = ((strtotime($timeOut) - strtotime($timeIn)) / 60) % 60;
                                    echo"<table class='timetable'><tr><td class='td1'></td><td class='td2'></td><td class='td3'></td><td class='td4'></td><td class='td5'>$timeIn</td><td class='td6'>$timeOut</td><td class='td7'>".$hoursDiff."h ".$minutesDiff."m</td><td class='td8'></td></tr></table>";
                                }
                            }
                        }
                        //------------------
                    }
                    else{
                        //If the project has no tasks
                        echo "<p>You currently have no tasks for this project.<br />";
                        echo "Create one now on the <a href=\"newTask.php\">Create Task</a> Page</p>";
                    }
                    ++$projectID;
                }
            }
            else{
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
        <br />
        <div class="footer">
            <a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" style="border: 0px;" /></a>
            <a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="http://www.austincc.edu/jscholl/images/vcss.png" alt="Valid CSS!" height="31" width="88" style="border: 0px;" /></a>
        </div>
        </div>
    </body>
</html>

