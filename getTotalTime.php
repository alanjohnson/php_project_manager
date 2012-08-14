<?php
function getTotalTime($projectID, $taskID){
    $totalHours = 0;
    $totalMinutes = 0;

    $file = "projects.xml";
    if (file_exists($file)) {
        $xml = simplexml_load_file("projects.xml");
        if (count($xml->project[$projectID]->task[$taskID]->interval) > 0) {
            foreach ($xml->project[$projectID]->task[$taskID]->interval as $interval) {
                $interval = explode(",", $interval);
                $timeIn = $interval[0];
                $timeOut = $interval[1];
                $hoursDiff = floor((strtotime($timeOut) - strtotime($timeIn)) / 3600);
                $totalHours+=$hoursDiff;
                $minutesDiff = ((strtotime($timeOut) - strtotime($timeIn)) / 60) % 60;
                $totalMinutes+=$minutesDiff;
            }
        }
    }
    return $totalHours."h ".$totalMinutes."m";
}
?>
