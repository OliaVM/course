<?php
namespace oliavm\Course;

abstract class Site 
{
	/**
	* Get url for parsing 
	*
	* @param string $day
	* @param string $valute
	* @return string
	*/
	abstract public function getUrl($day, $valute);

	/**
	* Get string with course valute from api
	*
	* @param string $url
	* @param string $valute
	* @return mixed
	*/
	public function getDataFromApi($url, $valute) { 
		if  (!in_array('curl', get_loaded_extensions())) {
		    exit("CURL is NOT installed on this server");
		}
		$connection = curl_init();
		curl_setopt_array($connection, array(
			CURLOPT_URL => $url,
		    CURLOPT_RETURNTRANSFER => 1,
		));
		$responseString = curl_exec($connection);
		curl_close($connection);
		try {
			if ($responseString == null || empty($responseString)) {
				throw new Exception('API connection error');
			}
		} catch (Exception $e) {
		    return  [$msg => $e->getMessage(). "\n", $status => false];
		}
		
		return $this->getCourseFromSite($valute, $responseString);
			
	}

	/**
	* Parse string from api and get course valute from site
	*
	* @param string $responseString
	* @param string $valute
	* @throws Exception
	* @return mixed
	*/
	abstract public function getCourseFromSite($valute, $responseString);

}

