<?php
function dateChecker($date){
    //Looking for month, date, year format i.e. "02/28/2007";
    $results = preg_match('/[\/]/', $date);
    if ($results > 0)
        {
            $dateArray = explode("/", $date);// exploding into array
            $mm=$dateArray[0]; // first element of the array is month
            $dd=$dateArray[1]; // second element is date
            $yy=$dateArray[2]; // third element is year
            If(!checkdate($mm,$dd,$yy)){
                return false;
            }else {
                return true;
            }
        }
        else{return false;}

}
function timeChecker($time){
    if (preg_match('/(0[1-9]|1[0-2])|^[0-9]:[0-5][0-9]/',$time)) {
        return true;
    } else {
        return false;
    }
}
?>
