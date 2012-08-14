<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Time Sheet</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="en-us" />
        <link href="myStyle.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <!-- Your page here -->
        
        <?php
            include('siteNav.php');
            include('dateTimeValidator.php');
            echo"<div class='container'>";
            echo"<h3>Task Time Sheet Updated</h3>";
            date_default_timezone_set('America/Chicago'); // set default date to avoid warnings if php.ini does not have default time zone set.

            $projectName=$_POST['project'];
            $taskName=$_POST['task'];
            //make sure valid project/task data made its way here (and not just spaces were entered)
            $projectNameCheck = preg_replace('/\s*/m', '', $projectName);
            $taskNameCheck = preg_replace('/\s*/m', '', $taskName);            
            if ($projectNameCheck != "" && $taskNameCheck != ""){
                $validData = true;
                if (!dateChecker($_POST['dateIn'])){
                    echo "<p>".$_POST['dateIn']." is not a valid date</p>";
                    $validData = false;
                }
                if (!dateChecker($_POST['dateOut'])){
                    echo "<p>".$_POST['dateOut']." is not a valid date</p>";
                    $validData = false;
                }
                if (!timeChecker($_POST['timeIn'])){
                    echo "<p>".$_POST['timeIn']." is not a valid time</p>";
                    $validData = false;
                }
                if (!timeChecker($_POST['timeOut'])){
                    echo "<p>".$_POST['timeOut']." is not a valid time</p>";
                    $validData = false;
                }
//make sure valid Time and date were submitted
/*IN PROGRESS*/ if ($validData == true){
                    //make sure the date and time can be parsed

                    //
                    $timeIn  = date("Y/m/d H:i", strtotime ($_POST['dateIn'] ." ".$_POST['timeIn'] ." ".$_POST['ampmIn']));
                    $timeOut = date("Y/m/d H:i", strtotime ($_POST['dateOut']." ".$_POST['timeOut']." ".$_POST['ampmOut']));
                    $hoursDiff = floor((strtotime($timeOut) - strtotime($timeIn)) / 3600);
                    $minutesDiff = ((strtotime($timeOut) - strtotime($timeIn)) / 60) % 60;
                    $timeStamps = $timeIn.",".$timeOut;

                    $projectID = 0;
                    $taskId = 0;
                    // Check if file exists, and find selected project
                    $file = "projects.xml";
                    if (file_exists($file)) {
                        $xml = simplexml_load_file("projects.xml");
                        $i = 0;
                        foreach($xml->project as $project)
                        {
                            if($project['name'] == $projectName)
                            {
                                $projectID = $i;
                                break;
                            }
                            ++$i;
                        }
                    }
                    else{
                        // If the file does not exist do this
                    }
                    // Check if task already exists
                    if (count($xml->project[$projectID]->task) > 0) {
                        $i = 0;
                        foreach ($xml->project[$projectID]->task as $node) {
                            if ($node->attributes()->name == $taskName) {
                                $taskId = $i;
                                break;
                            }
                            ++$i;
                        }
                    }
                    $interval = $xml->project[$projectID]->task[$taskId]->addChild("interval", $timeStamps);
                    //$xml->asXML("projects.xml"); // Would use instead of DOM code below if didn't care about indenting
                    //Using DOM just to save XML with indent tree rather than one line
                        $dom = new DOMDocument('1.0');
                        $dom->preserveWhiteSpace = false;
                        $dom->formatOutput = true;
                        $dom->loadXML($xml->asXML());
                        //Echo XML - remove this and following line if echo not desired
                        //echo $dom->saveXML();
                        //Save XML to file - remove this and following line if save not desired
                        $dom->save('projects.xml');
                    //END Using DOM just to save XML with indent tree rather than one line
                    echo"<table><tr><th>Task</th><th>Project</th><th>Time In</th><th>Time Out</th><th>Total Time</th></tr>";
                    echo "<tr><td>".$taskName."</td><td>".$projectName."</td><td>".$timeIn."</td><td>".$timeOut."</td><td>".$hoursDiff."h ".$minutesDiff."m</td></tr></table>";
                    echo"<p><a href='timeSheet.php'>Return to TimeSheet</a></p>";
                }else{
                echo"<p>Please enter correct date and time information:</p>";
                echo"<p>Eg. mm/dd/yyyy, and ##:##</p>";
                echo"<p><a href='timeSheet.php'>Return to TimeSheet</a></p>";
                }
            }else{
                echo"<p>Error Loading project or Task data</p>";
                echo"<p><a href='timeSheet.php'>Return to TimeSheet</a></p>";
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
