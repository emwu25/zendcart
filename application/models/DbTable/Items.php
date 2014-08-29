<?php

class Application_Model_DbTable_Items extends Zend_Db_Table_Abstract
{

    protected $_name = 'items';
	
	   			// 		keys to data array for item 
			//				hashcode - >   id of the item ? not sure if needed. 
			// 				sku - > item sku
			//				desc - > item description
			//				qty -> item qty
			//				price -> item price
			// 				fs - > free shipping.
			//				options -> item options
			// 				weight -> weight of an item 
			// 				shiping_quote -> quote for shipping PER 1 item
			//				order_id 	
			
	public function addItem($data) {
		$row = $this->createRow();
		$row->sku = $data["sku"];
		$row->desc	= $data["desc"];
		$row->qty = $data["qty"];
		$row->price = $data["price"];
		$row->fs = $data["fs"];
		//$row->options = $data["options"];
		$row->weight = $data["weight"];
		$row->shipping = $data["shipping"];
		$row->order_id = $data["order_id"];
		
		
		
		return $row->save();
	}
	
	public function getItems($order_id) { 
		$select = $this->select(); 
		$select->where('order_id = ?', $order_id);
		$result = $this->fetchAll($select);
		//var_dump($result->toArray());
		return $result;
	}


}

