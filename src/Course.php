<?php
namespace oliavm\Course;


class Course 
{
	/**
	* object site rbc.ru
	*
	* @var object
	*/
	public $siteRbc;
	/**
	* object site cbr.ru
	*
	* @var object
	*/
	public $siteCbr;

	function __construct() {
		$this->siteRbc = new SiteRbc();
		$this->siteCbr = new SiteCbr();

	}

	/**
	* @param string $day
	* @return void
	*/
	public function getAverageCourse($day) {

		echo "Средний курс евро " . $this->getAverageEurCourse($day);
		echo "<br>";
		echo "Средний курс доллара США " . $this->getAverageUsdCourse($day);
	}

	/**
	* Get Euro average course
	*
	* @param string $day
	* @return string
	*/
	public function getAverageEurCourse($day) {

		$urlEurCbr = $this->siteCbr->getUrl($day, "R01239");
		$eurCbr = $this->siteCbr->getDataFromApi($urlEurCbr, "R01239");

		$urlEurRbc = $this->siteRbc->getUrl($day, "EUR");
		$eurRbc = $this->siteRbc->getDataFromApi($urlEurRbc, "EUR");

		if (gettype($eurCbr) !== "array" && gettype($eurRbc) !== "array") {
			return ($eurCbr + $eurRbc)/2;
		}
	}


	/**
	* Get USD average course
	*
	* @param string $day
	* @return string
	*/
	public function getAverageUsdCourse($day) {
		
		$urlUsdCbr = $this->siteCbr->getUrl($day, "R01235");
		$usdCbr = $this->siteCbr->getDataFromApi($urlUsdCbr, "R01235");
		
		$urlUsdRbc = $this->siteRbc->getUrl($day, "USD");
		$usdRbc = $this->siteRbc->getDataFromApi($urlUsdRbc, "USD");

		if (gettype($usdCbr) !== "array" && gettype($usdRbc) !== "array") {
			return ($usdCbr + $usdRbc)/2;
		}
	}

}








