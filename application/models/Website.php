<?php 


class Application_Model_Website { 
	
	private $data; // Website data 

	public function  __get($name) {  
			// check if the named key exists in our array  
			if(array_key_exists($name, $this->data)) {  
				// then return the value from the array  
				return $this->data[$name];  
			}  
			return null;  
		} 
		
	public function  __set($name, $value) {  
			// use the property name as the array key  
			$this->data[$name] = $value;  
		}	
	public function __construct($website) { 
		$this->populateSiteData($website);
	}
	
	private function populateSiteData($website_name) { 
		switch($website_name) { 
			case "123dj":
				$this->data["site_name"] = "123Dj.com";
				$this->data["logo"] = "123Dj";
				$this->data["footer_address"] = "<p>MiniMax Electronics Inc.<br>
    2201 S. Union • Chicago, IL 60616<br>
	Phone: 312-846-6192 • Fax: 312-492-8949<br>
	Toll Free 1-800-856-8397</p>";
				$this->data["email"] = "info@123dj.com";
				$this->data["phone"] = "1-800-856-8397";
				$this->data["cart_mail"] = "cart@cart.123dj.com";
				$this->data["cart_mail_subject"] = "123DJ Order Confirmation.";
				$this->data["cart_base"] = "http://cart.chicagodjstore.com";
				$this->data["contact_us"] = "http://www.123dj.com/contact/service.php";
				break;
				
			case "turntable":
				$this->data["site_name"] = "turntable.com";
				$this->data["logo"] = "turntable";
				$this->data["footer_address"] = "<p>HOO HA!<br>
    2201 S. Union • Chicago, IL 60616<br>
	Phone: 312-846-6192 • Fax: 312-492-8949<br>
	Toll Free 1-800-856-8397</p>";
				$this->data["email"] = "info@123dj.com";
				$this->data["phone"] = "1-888-856-8397";
				$this->data["cart_mail"] = "cart@cart.123dj.com";
				$this->data["cart_mail_subject"] = "123DJ Order Confirmation.";
				$this->data["cart_base"] = "http://cart.chicagodjstore.com";
				$this->data["contact_us"] = "http://www.123dj.com/contact/service.php";
				break;	
		}
	}
	
	public function getSite() {
		return $this->data;
	}

}

?>