<?php
namespace oliavm\Course;
use \XMLReader;

class SiteCbr extends Site
{
	/**
	* Get url for parsing 
	*
	* @param string $day
	* @param string $valute
	* @return string
	*/
	public function getUrl($day, $valute) {
		$day = date("d/m/Y", strtotime($day));  
		$url = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . $day;
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
		$course = $this->getCourseFromCbr($valute, $responseString);
		try {
			if ($course == null) {
				throw new Exception('Cbr API data is changed');
			} else {
				return $course;
			}
		} catch (Exception $e) {
		    return  [$msg => $e->getMessage(). "\n", $status => false];
		}
	}

	/**
	* From cbr
	*
	* @param string $responseString
	* @param string $valute
	* @return mixed
	*/
	public function getCourseFromCbr($valute, $responseString) {
		$reader = new XMLReader();
		if (!$reader->xml($responseString)) {
			return "API connection error";
		} 

		$doc = new \DOMDocument;
		while ($reader->read()) {
    		if ($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'ValCurs') {
    			while ($reader->read()) {
            		if ($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'Valute') {
            			$id = $reader->getAttribute('ID');
            			if ($id == $valute) {
            				 $node = simplexml_import_dom($doc->importNode($reader->expand(), true));
            				 return $node->Value;
            			}
            			
            		}
            	}
    		} 
    	}
	}

}

