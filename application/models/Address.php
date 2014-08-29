<?php

class Application_Model_Address
{
	private $data;
	   		// 		keys to data array for item 
			//				company -> customers company ?
			//				address 1 - >   First Line of Address 
			// 				address 2  - > 2nd Line of Address
			//				city - > City of customer
			//				state -> state / province
			//				zip -> zip code
			//				country -> country of customer
			// 				email - > customer_email.
			//				phone -> customer phone
			//
			//				id -> id of the address in db 
			// 				customer_id -> id of the customer 
			
	
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

	public function createFromInput($input) {
		$address_adapter = new Application_Model_DbTable_Addresses();
		$address_id = $address_adapter->addAddress($input["company"], $input["address1"], $input["address2"], $input["city"], $input["state"], $input["zip"], $input["country"], $input["phone"], $input["email"], $input["customer_id"]);	
		return $address_id;
	}
	
	public function getAddressById($id) { 
		$address_adapter = new Application_Model_DbTable_Addresses();
		$res_row = $address_adapter->getAddressById($id);
		$this->company = $res_row->company;
		$this->address1 = $res_row->address1;
		$this->address2 = $res_row->address2;
		$this->city = $res_row->city;
		$this->state = $res_row->state;
		$this->zip = $res_row->zip;
		$this->country = $res_row->country;
		$this->email = $res_row->email;
		$this->phone = $res_row->phone;
		$this->id = $res_row->lp;
	}

}
