<?php
/**
 * Total Working Days Finder Class
 *
 * @category Class
 * @package  PHPClasses
 * @author   Md. Tariqul Islam <tareq@webkutir.net>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://webkutir.net
 */
class totalWorkingDays
{
	private $_holidays = array();
	private $_holidates = array();
	private $_tWDays = 0;

	/**
	 * Class Constructor
	 */
	public function __construct() {
		date_default_timezone_set("UTC");
		$this->_tWDays = 0;
	}

	/**
	 * Method to set Holidays i.e. Friday, Saturday, Sunday etc
	 * 
	 * @param array $daysArray Array of Day Names which will be set as Holidays Generally
	 * 
	 * @return void
	 */
	public function setHoliday($daysArray) {
		$this->_holidays = $daysArray;
	}

	/**
	 * Method to set specific Dates as Holiday
	 * 
	 * @param array $datesArray Array of specific Dates which will be considered as Holidays
	 * 
	 * @return void
	 */
	public function setHolidate($datesArray) {
		foreach ($datesArray as $k=>$v) {
			$datesArray[$k] = strtotime($v);
		}
		$this->_holidates = $datesArray;
	}

	/**
	 * Method to Calculate Total Working Days in a specified Date Range
	 * 
	 * @param date $startDate Start Date of the Range
	 * @param date $endDate   End Date of the Range
	 * 
	 * @return integer
	 */
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