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
        echo"<h1>Your Projects</h1>";
        // Check if file exists, if so list any existing projects
        $file = "projects.xml";
        if (file_exists($file) && '' != file_get_contents($file)) {
            $xml = simplexml_load_file($file);
            if (count($xml->project) > 0) {
                echo"<table class='projectTable'><tr><th class='td1'>Project</th><th class='td1'>Client</th><th class='td3'>Bid</th><th class='td3'>Last Payment</th><th class='td3'>Payment Due</th><th class='td3'>Status</th><th class='td4'>Notes</th></tr>";
                foreach ($xml->project as $node) {
                    // This prints out each of the projects information
                    $project = $node->attributes()->name;
                    $client = (string)$node->attributes()->client;
                    $bid = (string)$node->attributes()->bid;
                    $pmade = (string)$node->attributes()->pMade;
                    $pdue = (string)$node->attributes()->pDue;
                    $status = (string)$node->attributes()->status;
                    $notes = (string)$node->attributes()->notes;
                    echo"<tr><td>".$project."</td><td>".$client."</td><td>$".$bid."</td><td>".$pmade."</td><td>".$pdue."</td>";
                    if ($status == 'In Progress') {
                        echo"<td><img src='../images/statusInProgress.gif' alt='status' title='In Progress' style='display: block; margin:auto;' /></td>";
                    }
                    else if ($status == 'Complete') {
                        echo"<td><img src='../images/statusCompleted.gif' alt='status' title='Completed' /></td>";
                    }
                    else if ($status == 'Cancelled') {
                        echo"<td><img src='../images/statusCancelled.gif' alt='status' title='Cancelled' /></td>";
                    }
                    else {
                        echo"<td></td>";
                    }
                    if($notes == "n/a") {
                        echo"<td></td></tr>";
                    }
                    else {
                        echo"<td><img src='../images/notepad.gif' alt='notepad' title='".$notes."' /></td></tr>";
                    }
                }
                echo"</table>";
            }
            else {
        //If the file exists but there are no projects in it
        echo "<p>You currently have no projects.</p>";
    }
}
else { // If file does not exist
    echo "<p>You currently have no projects.</p>";
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

