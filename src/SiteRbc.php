<?php
namespace oliavm\Course;


class SiteRbc extends Site
{
	/**
	* Get url for parsing 
	*
	* @param string $day
	* @param string $valute
	* @return string
	*/
	public function getUrl($day, $valute) {
		$day = date("Y-m-d", strtotime($day));  
		$url = "https://cash.rbc.ru/cash/json/converter_currency_rate/?currency_from=" . $valute ."&currency_to=RUR&source=cbrf&sum=1&date=" . $day;
		return $url;
	}

	/**
	* Parse string from api and get course valute from site
	*
	* @param string $responseString
	* @param string $valute
	* @throws Exception
	* @return mixed
	*/
	public function getCourseFromSite($valute, $responseString) {
		$course = $this->getCourseFromRbc($responseString);
		try {
			if ($course == null) {
				throw new Exception('Rbc API data is changed');
			} else {
				return $course;
			}
		} catch (Exception $e) {
		    return  [$msg => $e->getMessage(). "\n", $status => false];
		}
	}
	
	/**
	* from rbc
	*
	* @param string $responseString
	* @return string
	*/
	public function getCourseFromRbc($responseString) {
	    $responseArray = json_decode($responseString);
	    return $responseArray->data->sum_result;
	}
}


