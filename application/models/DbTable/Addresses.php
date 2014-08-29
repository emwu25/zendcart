<?php

class Application_Model_DbTable_Addresses extends Zend_Db_Table_Abstract
{

    protected $_name = 'addresses';
	
	public function addAddress($company, $address1, $address2, $city, $state, $zip, $country, $phone, $email, $customer_id) {
		$row = $this->createRow();
		
		$row->company = $company; 
		$row->address1 = $address1;
		$row->address2 = $address2;
		$row->city = $city;
		$row->state = $state;
		$row->zip = $zip;
		$row->country = $country;
		$row->phone = $phone;
		$row->email = $email;
		$row->customer_id = $customer_id;
		$id = $row->save();
		return $id;
	}
	public function getAddressById($id) {
		
		$select = $this->select();
		$select->where('lp = ?', $id);
		$result = $this->fetchRow($select);	
		return $result;
	}

}



//$input["company"], $input["address1"], $input["address2"], $input["city"], $input["state"], $input["zip"], $input["country"], $input["phone"], $input["email"], $input["customer_id"]