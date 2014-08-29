<?php

class Application_Model_Cart
{
	
   private $data;
   
   			// 		keys to data array for cart 
			//		items_collection -> array of Application_Model_Item
			//		subtotal
			//		shipping_total -> quote for each item * its quantity summed up for all items. 
			//		shipipng_dest -> zipcode where stuff ships. 
			// 		tax -> Tax rate of destination. 
			
   public function __construct() {
		$this->data =  Array();   
   }
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
	
	public function addItem($item_input, $item_options) { 
		
		$this->getItems();	
		$item_obj = new Application_Model_Item();
		$item_obj->createItem($item_input, $item_options);
			if(!$this->checkAndAdd($item_obj)) { 
				if((!is_null($this->data["shipping_dest"])) && ($item_obj->fs == "NFS")) {
				$item_obj->shipping_quote = Application_Model_Helper_UpsQuote::getQuote($item_obj, $this->data["shipping_dest"]);
				}
				$this->data["items_collection"][] = $item_obj;
			}
		$this->setShipping();
		$this->updateSubtotal();	
		$cart_namespace = new Zend_Session_Namespace('cart');
		$cart_namespace->cart_data = $this->data;
		//echo "<hr>";
		//var_dump($this->data);
	
	}
	
	public function getItems() {
	
		$cart_namespace = new Zend_Session_Namespace('cart');
		if(!is_null($cart_namespace->cart_data)) {
			$this->data = $cart_namespace->cart_data;
		}
		return $this->data;
	}
	
	private function checkAndAdd($item) {
		
		for($i=0; $i < count($this->data["items_collection"]); $i++) {
			if($this->data["items_collection"][$i]->hashcode == $item->hashcode) {
				$this->data["items_collection"][$i]->qty += $item->qty;
				$this->updateSubtotal();
				return true;	
			}
		}
			return false; 
	
	}
	
	public function updateAll($update_items) { 
		$useful_stuff = array_slice($update_items, 3);
		var_dump($useful_stuff);
		
		foreach($this->data["items_collection"] as $key => $item) {
			
			foreach($update_items as $hash => $qty) {
				if($item->hashcode == $hash) {
					$item->qty = $qty;	
				} 
				if($item->qty == 0) {					// remove if 0.
					unset($this->data["items_collection"][$key]);
				}
			}
			
		}
		$cart_namespace = new Zend_Session_Namespace('cart');
		$cart_namespace->Items = $this->data;
	}
	
	public function updateSingleItem($update_item) { 
	 	//$useful_stuff = array_slice($update_item, 3);
		//var_dump($update_item);

		foreach($this->data["items_collection"] as $key => $item) {
			
			foreach($update_item as $hash => $qty) {
				if($item->hashcode == $hash) {
					$item->qty = $qty;	
				} 
				if($item->qty == 0) {					// remove if 0.
					unset($this->data["items_collection"][$key]);
				}
			}
		}
		$this->updateSubtotal();
		$this->setShipping();
		$cart_namespace = new Zend_Session_Namespace('cart');
		$cart_namespace->cart_data = $this->data;
	}
	
	private function updateSubtotal() {
		$subtotal = 0; 
		foreach($this->data["items_collection"] as $item) {
			$subtotal = $subtotal + ( $item->price * $item->qty);	
		}
		$this->data["subtotal"] = $subtotal;
	}
	
	public function getNFS() {
		$total_nfs_weight = 0; 
		
		$this->getItems();
		foreach( $this->data["items_collection"] as $item) {
			if($item->fs == "NFS") {
				$total_nfs_weight += $item->weight * $item->qty;
			}
		}
		
		return $total_nfs_weight;
	}
	
	public function Save() { 
		$cart_namespace = new Zend_Session_Namespace('cart');
		$cart_namespace->cart_data = $this->data;	
	}
	
	public function setShipping() { 
		$shipping_total = 0;
		foreach( $this->data["items_collection"] as $item ) {
			if($item->fs == "NFS") { 
				$shipping_total += ($item->shipping_quote * $item->qty);
			}
		}
		$this->data["shipping_total"] = $shipping_total;
	}
	
	public function hasItems() {
		if(count($this->data["items_collection"]) > 0) {
			return true;
		}
		
		return false;
	}


}

