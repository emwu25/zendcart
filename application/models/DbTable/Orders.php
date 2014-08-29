<?php

class Application_Model_DbTable_Orders extends Zend_Db_Table_Abstract
{

    protected $_name = 'orders';
							//  Application_Model_Order
							//
							//	id -> id from database
							//	customer_id -> id of customer that the order belongs to
							//	address_id -> id of the address this order is shipped to. 
							//	subtotal -> subtotal of this order 
							//	ip_address -> IP address of where order was placed from
							//	tax - > tax from the order;
							//	shipping  -> shipping cost of this order
							//	total -> total of this order
							// 	date_of_purchase -> when the order was placed. 
							// 	payment_id -> id of the payment for this order
							//  instructions
	
	public function addOrder($customer_id, $address_id, $subtotal, $ip_address, $tax, $shipping, $total, $date_of_purchase, $payment_id, $instructions) {
		$row = $this->createRow();
		
		$row->customer_id = $customer_id; 
		$row->address_id = $address_id;
		$row->subtotal = $subtotal;
		$row->ip_address = $ip_address;
		$row->tax = $tax;
		$row->shipping = $shipping;
		$row->total = $total;
		$row->payment_id = $payment_id;
		$row->instructions = $instructions;
		$id = $row->save();
		return $id;
	}
	
	public function getOrder($order_id) { 
		$select = $this->select();
		$select->setIntegrityCheck(false);
		$select->where('o.lp = ?', $order_id);
		$select->from(array("o" => "orders"));
		//This join will not be used here... leaving it for future reference. 
		//$select->join(array("p" => "payments"),'o.lp = p.order_id',array("payment_id"=>"lp","payment_type" => "payment_type", "name_on_card"=>"name_on_card", "card_number"=>"card_number","month"=>"month", "year"=>"year","ccv"=>"ccv","order_id"=>"order_id","payment_date"=>"date_created","payment_total"=>"total"));
		//echo $select;
		$result = $this->fetchRow($select);  
		return $result;
	}
	
	public function getOrders($customer_id) {
		$select = $this->select();
		$select->where('customer_id = ?', $customer_id);
		$res = $this->fetchAll($select);
		return $res->toArray();	
	}

}

