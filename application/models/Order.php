<?php

class Application_Model_Order
{
		private $data;

		
							//
							//			Keys for data
							//
							//				db stuff
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
							//
							//
							//				not db stuff
							//
							//
							//	items_collection -> Array of Application_Model_Item in this order.							
							//  customer -> the customer this order belongs to.
							//	payment -> Payment obj belonging to this order. 

	
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
		
		public function recalculateShipping() {
			$zip_code = $this->data["customer"]->address->zip;
		
			$shipping_quote = 0; 
			foreach($this->data["items_collection"] as $each_item) {
				if($each_item->fs == "NFS") {
					$quote = Application_Model_Helper_UpsQuote::getQuote($each_item, $this->data["customer"]->address->zip);
					$shipping_quote += $quote * $each_item->qty;
					$each_item->shipping = $quote;	
				}
			}
			
			return $shipping_quote;
		}
		
		
		public function calculateTax() {
			if($this->data["customer"]->address->state == "IL") {
				return round($this->data["subtotal"] * 0.095, 2);
			} else { return 0; }
		}	
		
		public function calculateTotals() {
			return round($this->data["subtotal"] + $this->data["tax"] + $this->data["shipping"], 2);	
		}
		
		public function storeOrder() {
				$order_namespace = new Zend_Session_Namespace('order');
				$order_namespace->order_data = $this->data;		
		}
		
		public function retrieveOrder() {
				$order_namespace = new Zend_Session_Namespace('order');
				$this->data = $order_namespace->order_data;
				Zend_Session::namespaceUnset('order');
				if(is_null($this->data))
				{ 
					throw new Exception("Trying to access NonExisting Order");
				}
				
				return true;	
		}
		
		public function setPayment($input_variables) {
				$payment_obj = new Application_Model_Payment(); 
				foreach($input_variables as $payment_var => $value) {
					$payment_obj->$payment_var = $value;
					//echo $payment_var . "<br>";
				}
				$payment_obj->total = $this->data["total"];
				$this->data["payment"] = $payment_obj;
				
		}
		
		public function setComments($input_variables) {
				if(!is_null($input_variables["special_instructions"])) {
					$this->data["instructions"] = $input_variables["special_instructions"];	
				}
		}
		
		public function setIpAddress($ip) {
			$this->data["ip_address"] = $ip;	
		}
		
		// USE THIS FUNCTION ONLY ON NEW ORDERS !!!!!!!!!!!!!
		
		public function saveOrder() {
			$order_adapter = new Application_Model_DbTable_Orders();
			
			// INSERT ORDER 
			
			$order_id = $order_adapter->addOrder($this->data["customer_id"], $this->data["address_id"], $this->data["subtotal"], $this->data["ip_address"], $this->data["tax"], $this->data["shipping"], $this->data["total"], null, null, $this->data["instructions"]);
				if($order_id < 1) {
					throw new Exception("Unable to inserto order to db.", "101");	
				}
			$this->data["id"] = $order_id;
			$this->data["payment"]->order_id = $order_id;
			
			// INSERT PAYMENT 
			
			$payment_id = $this->data["payment"]->addPayment();
			if($payment_id < 1) {
				throw new Exception("Unable to insert payment into db.  Order was set fine", "101");
			} else { 
				// Update the order with new Payment info. 
				
			}
			
			// INSERT ITEMS NOW 
			
			foreach($this->data["items_collection"] as $item) {
				$item->order_id = $order_id;
				$id = $item->storeDb();	
				if($id < 1) { 
					throw new Exception("Unable to store item to db.", "101");
				}
			}		
			
		}
		
	public function getOrder($order_id) {
		$order_adapter = new Application_Model_DbTable_Orders();
		$row = $order_adapter->getOrder($order_id);
		$this->data["id"] = $row->lp; 
		$this->data["customer_id"] = $row->customer_id; 
		$this->data["subtotal"] = $row->subtotal;
		$this->data["ip_address"] = $row->ip_address;
		$this->data["tax"] = $row->tax;
		$this->data["shipping"] = $row->shipping;
		$this->data["total"] = $row->total;
		$this->data["date_of_purchase"] = $row->date_of_purchase;
		$this->data["payment_id"] = $row->payment_id;
		$this->data["instructions"] = $row->instructions;
		
		$this->getItems();
		
		$customer_obj = new Application_Model_Customer();
		$customer_obj->getCustomer($this->data["customer_id"]);
		$this->data["customer"] = $customer_obj;
		
		$payment_obj = new Application_Model_Payment();
		//var_dump($this);
		$payment_obj->getPayment($this->data["id"]);
		$this->data["payment"] = $payment_obj;
	}
	
	public function getItems() { 
		$this->data["items_collection"] = Application_Model_Item::getItems($this->data["id"]);
	}
	
	public static function getOrders($customer_id) { 
		$orders_adapter = new Application_Model_DbTable_Orders();
		$orders_array = $orders_adapter->getOrders($customer_id);
		return $orders_array;
	}
	

		
		
		

}

