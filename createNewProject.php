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
        echo"<h1>New Project</h1>";
        date_default_timezone_set('America/Chicago'); // set default date to avoid warnings if php.ini does nto have default time zone set.
        // Create variables
        $newClient=trim($_POST['clientName']);
        $newProject=trim($_POST['projectName']);
        $projectBid=trim($_POST['projectBid']);
        if (is_numeric ($projectBid) || $projectBid == "") {
            //make sure valid data was entered first (and not just spaces were entered)
            $clientNameCheck = preg_replace('/\s*/m', '', $newClient);
            $newProjectCheck = preg_replace('/\s*/m', '', $newProject);
            if ($clientNameCheck != "" && $newProjectCheck != ""){
                if ($projectBid == "") {
                    $projectBid = "noBid";
                }
                $projectNotes=$_POST['projectNotes'];
                if ($projectNotes == "") {
                    $projectNotes = "n/a";
                }
                $Duplicate = "false";
                // Check if file exists, if so, make sure the project does not already exist
                $file = "projects.xml";
                if (file_exists($file) && '' != file_get_contents($file)) {
                    $xml = simplexml_load_file("projects.xml");
                    if (count($xml->project) > 0) {
                        foreach ($xml->project as $node) {
                            if ($node->attributes()->name == $newProject)
                            {
                                $Duplicate = "true";
                                echo "<p>This Project already exists</p>";
                                echo "<p>Back to <a href=\"newProject.php\">Create Project</a> Page</p>";
                            }
                        }
                    }
                }
                else { // If file does not exist, create one for all projects to be placed in
                    $fp = fopen($file, "a+");
                    fclose($fp);
                    $xml = new SimpleXMLElement("<projects></projects>");
                }
                if ($Duplicate == "false") {
                    $project = $xml->addChild("project");
                    $project->addAttribute('name',htmlspecialchars(utf8_encode($newProject)));
                    $project->addAttribute('client',htmlspecialchars(utf8_encode($newClient)));
                    $project->addAttribute('bid',htmlspecialchars(utf8_encode($projectBid)));
                    $project->addAttribute('pDue','n/a');
                    $project->addAttribute('pMade','n/a');
                    $project->addAttribute('status','In Progress');
                    $project->addAttribute('notes',htmlspecialchars(utf8_encode($projectNotes)));
                    //$xml->asXML("projects.xml"); // Would use instead of DOM code below if didn't care about indenting
                    //Using DOM just to save XML with indent tree rather than one line
                        $dom = new DOMDocument('1.0');
                        $dom->preserveWhiteSpace = false;
                        $dom->formatOutput = true;
                        $dom->loadXML($xml->asXML());
                        //Save XML to file - remove this and following line if save not desired
                        $dom->save('projects.xml');
                    //END Using DOM just to save XML with indent tree rather than one line
                    echo "<p>Project added</p>";
                }
             }else {
                echo "<p>Please be sure to enter both Client and Project Names.</p>";
                echo "<p>Back to <a href=\"newProject.php\">Create Project</a> Page</p>";
             }
        }else {
                echo "<p>Please be sure to enter a number for the bid value.</p>";
                echo "<p>Back to <a href=\"newProject.php\">Create Project</a> Page</p>";
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
