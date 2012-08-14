// JavaScript Clock
// Created by Alan Johnson
function curTime(){
    var dayArray=new Array("Sun", "Mon","Tue","Wed","Thu","Fri","Sat");
    var dateObject = new Date();

    //setting Date
    var curDate = "";
    var dayValue = dateObject.getDay(); // day of week value
    var dateValue = dateObject.getDate();
    var monthValue = dateObject.getMonth()+1;
    var yearValue = dateObject.getFullYear();
    curDate = dayArray[dayValue] + " " + monthValue + "/" + dateValue + "/" + yearValue;
    //document.forms[0].readOutDate.value = curDate;
    
    //Setting Time
    var curTime = "";
    var secondValue = dateObject.getSeconds();
    var minuteValue = dateObject.getMinutes();
    var hourValue = dateObject.getHours();
    if(secondValue < 10){
        secondValue = "0" + secondValue;
    }
    if(minuteValue < 10){
        minuteValue = "0" + minuteValue;
    }
    if(hourValue < 12){
        curTime = hourValue + ":" + minuteValue + ":" + secondValue + "AM"; 
    }
    else if (hourValue == 12){
            curTime = hourValue + ":" + minuteValue + ":" + secondValue + "PM"; 
    }
    else{
        curTime = (hourValue-12) + ":" + minuteValue + ":" + secondValue + "PM";
    }
    //document.forms[0].readOutTime.value = curTime;
	document.getElementById("Clock").innerHTML = curDate + " | " + curTime;
}
var tick = setInterval("curTime()", 1000);
