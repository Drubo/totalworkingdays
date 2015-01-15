<?php
class totalWorkingDays
{
	private $_holidays = array();
	private $_holidates = array();
	private $_tWDays = 0;
	
	public function __construct() {
		date_default_timezone_set("UTC");
		$this->_tWDays = 0;
	}
	
	public function setHoliday($daysArray) {
		$this->_holidays = $daysArray;
	}
	
	public function setHolidate($datesArray) {
		foreach ($datesArray as $k=>$v) {
			$datesArray[$k] = strtotime($v);
		}
		$this->_holidates = $datesArray;
	}
	
	public function calculate($startDate, $endDate) {
		$dtInfo = date_parse($startDate);
		if ($dtInfo['warning_count'] != 0 || $dtInfo['error_count'] != 0) {
			return 'Start Date is not a valid date';
		}
		
		$dtInfo = date_parse($endDate);
		if ($dtInfo['warning_count'] != 0 || $dtInfo['error_count'] != 0) {
			return 'End Date is not a valid date';
		}
		$diff = floor((strtotime($endDate)-strtotime($startDate))/(60*60*24));
		$checkDate = $startDate;
		
		for($i=1;$i<=$diff;$i++) {
			if (count($this->_holidays) > 0) {
				if (!in_array(date('l', strtotime($checkDate)), $this->_holidays)) {
					if (count($this->_holidates) > 0) {
						if (!in_array(strtotime($checkDate), $this->_holidates)) {
							$this->_tWDays += 1;
						}
					} else {
						$this->_tWDays += 1;
					}
				}
				
			} elseif (count($this->_holidates) > 0) {
				if (!in_array(strtotime($checkDate), $this->_holidates)) {
					$this->_tWDays += 1;
				}
			} else {
				$this->_tWDays += 1;
			}
			$checkDate = date("d-m-Y", (strtotime($startDate)+($i*24*60*60)));
		}
		
		return $this->_tWDays;
	}
}
?>