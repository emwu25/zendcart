<?php
class Application_Model_Helper_UpsQuote { 
	
    public static function getQuote($item, $zip) {
		
					$rate = new Application_Model_Ups;
					$rate->upsProduct("GND"); // See upsProduct() function for codes
					$rate->origin("60616", "US"); // Use ISO country codes!
					$rate->dest($zip, "US"); // Use ISO country codes!
					$rate->rate("RDP"); // See the rate() function for codes
					$rate->container("CP"); // See the container() function for codes
					$rate->weight($item->weight);
					$rate->rescom("RES"); // See the rescom() function for codes
					$quote = $rate->getQuote();
					return $quote;
    }
}

?>