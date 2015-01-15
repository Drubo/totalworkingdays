<?php 
require("totalworkingdays.php"); 

//initialize the class
$twd = new totalWorkingDays();
//set Holiday by its name (optional)
$twd->setHoliday(array('Friday','Saturday'));
//set Dates as Holiday (optional) 
$twd->setHolidate(array('1st January 2015', '2015-01-12', '21-01-2015'));
//Calculate to find total working days 
echo $twd->calculate("2015-01-01", "2015-01-31") . " Working days."; 

?>