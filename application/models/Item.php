<?php

class Application_Model_Item
{
   private $data = array();

   
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
	
	public function createItem($item_input_string, $item_options) { 
		
		//NFS^123DJM2ULT^Rack Case with Laptop Tray^219.99^1^^^^41^
		
		$item_array = explode("^", $item_input_string);
		var_dump($item_array);
		$price_array = explode("+",$item_array[3]);
		$price = $price_array[0];
		
		$this->data["sku"] = $item_array[1];
		$this->data["desc"] = $item_array[2];
		$this->data["price"] = $price;
		$this->data["qty"] = $item_array[4];
		$this->data["fs"] = $item_array[0];
		$this->data["weight"] = $item_array[8];
		//var_dump($this);
		
		foreach($item_options as $each_option) {
			$this->data["options"][] = $each_option;
			$option_array = explode(" - $", $each_option);
			//var_dump($option_array);
			$this->data["desc"] = $this->data["desc"] ." - ". $option_array[0];
			$this->data["price"] = $this->data["price"] + $option_array[1];	
		}
		$this->generateHashCode();
		//var_dump($this);
		echo "<br>";
		
		
	}
	
	private function generateHashCode() { 
		
	
		$string = $this->sku . $this->price . $this->fs;
		if(isset($this->data["options"])){
			//echo "i'm here";
			foreach($this->options as $each_option) {
				$string = $string . $each_option;	
			}
		}
		//echo "hashi " . $string;
		$hashed = hash("md5",$string);
		$this->hashcode = $hashed;
		
	}
	
	public function updateQuantity($new_qty) { 
		$this->data["qty"] = $new_qty;
	}
	
	public function storeDb() {
		$item_adapter = new Application_Model_DbTable_Items();
		$res_id = $item_adapter->addItem($this->data);	
		return $res_id;
	}
	
	
//	public function saveItem() {
//		$cart_namespace = new Zend_Session_Namespace('cart');
//		$cart_namespace->Item = $this;
//	}
	
//	public function getItem() {
//		$cart_namespace = new Zend_Session_Namespace('cart');
//		$item = $cart_namespace->Item;
//		echo "<hr>";
//		var_dump($item);
//	}

	public static function getItems($order_id) { 
		$items = array();
		$items_adapter = new Application_Model_DbTable_Items();
		$items_rows = $items_adapter->getItems($order_id);

		foreach($items_rows as $each_row) { 
			$item = new Application_Model_Item();
			$item->lp = $each_row->lp;
			$item->sku = $each_row->sku;
			$item->desc = $each_row->desc;
			$item->qty = $each_row->qty;
			$item->price = $each_row->price;
			$item->fs = $each_row->fs;
			$item->options = $each_row->options;
			$item->weight = $each_row->weight;
			$item->shipping_quote = $each_row->shipping;
			$item->order_id = $each_row->order_id;
			array_push($items, $item);
		}
		
			return $items;
	
	}
	

}
