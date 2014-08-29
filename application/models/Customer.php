<?php

class Application_Model_Customer
{
	
	private $data;
	
		   	// 		keys to data array for item 
			//				name -> customer Name
			//				address-> Application_Model_Address
			//				past_orders -> array of Application_Model_Order
			//				id -> id of customer in the database			
			//				address_id -> id of addresses in the database. 
			//				username-> 	email address, used as username;
			//				password -> password for the customer. 
			//				mailing_list_add -> true or false. 

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
		
		$customer_adapter = new Application_Model_DbTable_Customers();
		
		$customer_id = $customer_adapter->addCustomer($input["name"], null, $input["email"], $input["password"], $input["mail_list"]);	
		$this->data["id"] = $customer_id;
		$input["customer_id"] = $customer_id;
		$address_obj = new Application_Model_Address();
		$address_id = $address_obj->createFromInput($input);
		$this->setAddressById($address_id);
	}
	
	public static function checkIfExists($field,$value) {
		$customer_adapter = new Application_Model_DbTable_Customers();
		return $customer_adapter->checkIfExists($field,$value);	
	
	}
	
	public function setAddressById($id, $customer = null) {
		
		$customer_adapter = new Application_Model_DbTable_Customers();
		
		if(is_null($customer)) {
			$customer = $this->data["id"];	
		}
		$customer_adapter->setAddress($id, $customer);
	}
	
	public function getCustomer($id) {
		
		$customer_adapter = new Application_Model_DbTable_Customers();
		$result_row = $customer_adapter->getCustomerById($id);
		$this->data["id"] = $id;
		$this->data["name"] = $result_row->name;
		$shipping_addr = new Application_Model_Address();
		$shipping_addr->getAddressById($result_row->address_id);
		$this->data["address"] = $shipping_addr;
		$this->data["address_id"] = $shipping_addr->id;
		$this->data["username"] = $result_row->username;
	}
	
	public function changePassword($new_pass) { 
		$customer_adapter = new Application_Model_DbTable_Customers();
		$result_row = $customer_adapter->updatePassword($this->data["id"], $new_pass);
		return $result_row;
	}
	
	public function getByLogin($username) {
		$customer_adapter = new Application_Model_DbTable_Customers();
		$result_row = $customer_adapter->getCustomerByLogin($username);
		$this->data["id"] = $result_row->lp;
		$this->data["name"] = $result_row->name;
		$shipping_addr = new Application_Model_Address();
		$shipping_addr->getAddressById($result_row->address_id);
		$this->data["address"] = $shipping_addr;
		$this->data["address_id"] = $shipping_addr->id;
		$this->data["username"] = $result_row->username;
	}
	

}
