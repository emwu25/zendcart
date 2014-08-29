<?php

class Application_Model_DbTable_Customers extends Zend_Db_Table_Abstract
{

    protected $_name = 'customers';

	public function addCustomer($name, $address_id, $username, $password, $mailing_list) {
		$row = $this->createRow();
		
		$row->name = $name; 
		$row->username = $username;
		$row->password = $password;
		$row->mailing_list = $mailing_list;
		$id = $row->save();
		return $id;
	}
	
	public function checkIfExists($db_field, $db_value) {
		$field = $db_field;
		$value = $db_value;
		
		$select = $this->select();
		$select->where($field .' = ?', $value);
		$select->limit(1);
		$result = $this->fetchAll($select);	
		if(is_null($result->current())){ 
			return false;
		}
			//var_dump($result);
			return true;
			
	}
	
	public function setAddress($addr_id, $customer) {
			
		$data = array(
			'address_id'      => $addr_id,
				);
		$where = $this->getAdapter()->quoteInto('lp = ?', $customer);
		$this->update($data, $where);
		 
	}
	
	public function getCustomerById($id) {
		$select = $this->select();
		$select->where('lp = ?', $id);
		$select->from($this,array('name','address_id','username'));
		$result = $this->fetchRow($select);	
		return $result;
	}


	public function getCustomerByLogin($username) {
		$select = $this->select();
		$select->where('username = ?', $username);
		$select->from($this,array('lp','name','address_id','username'));
		$result = $this->fetchRow($select);	
		return $result;
	}
	
	public function updatePassword($customer_id, $pass) { 
		$data = array(
				'password' => $pass
				);
		$where = $this->getAdapter()->quoteInto('lp = ?', $customer_id);
		return $this->update($data, $where);
	}

}

