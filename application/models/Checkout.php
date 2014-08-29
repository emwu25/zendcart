<?php

class Application_Model_Checkout
{
	private $data;
						//			Keys for the checkout model
						//
						//	customer -> Application_Model_Customer at the checkout.
						//	order -> Application_Model_Order that will be placed. 
						//	cart -> Application_Model_Cart that will be checked out. 
						//

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

	public function generateCheckout() {
		$cart_obj = new Application_Model_Cart();
		$cart_obj->getItems();	
		$this->data["cart"] = $cart_obj;
	}
	
	public function hasItems() {
		if($this->cart->hasItems())
			return true;
			return false;
	}
	
	public function getCustomer($id) {
		 $customer_obj = new Application_Model_Customer();
		 $customer_obj->getCustomer($id);
		 $this->data["customer"] = $customer_obj;
	}
	
	public function generateOrder() {
		$order_obj = new Application_Model_Order();
		$order_obj->items_collection = $this->data["cart"]->items_collection;
		$order_obj->customer = $this->data["customer"];
		$order_obj->customer_id = $this->data["customer"]->id;
		$order_obj->address_id = $this->data["customer"]->address_id;
		$order_obj->subtotal = $this->data["cart"]->subtotal;
		$order_obj->tax = $order_obj->calculateTax();
		$order_obj->ip_adddress = "some ip";
		$order_obj->shipping = $order_obj->recalculateShipping();
		$order_obj->total = $order_obj->calculateTotals();
		$order_obj->date_of_purchase = null;
		$order_obj->payment_id = null;
		$order_obj->storeOrder();
		$this->data["order"] = $order_obj;
			
	}
	

}

