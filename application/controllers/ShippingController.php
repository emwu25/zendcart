<?php

class ShippingController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function upsQuoteAction()
    {
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
        $cart_obj = new Application_Model_Cart();
		$cart_obj->getItems();
		
		$validators = null;
		$filters = array(
    		'zip'   =>	'StripTags',
			'state' => 	'StripTags'
		);
		$data = $this->_request->getParams();
		$input = new Zend_Filter_Input($filters, $validators, $data);		 
		
		$input->isValid();
		
		if($input->state == "IL") {
			$cart_obj->tax = 0.095;	
		} else {
			$cart_obj->tax = 0;	
		}
		
		$cart_obj->shipping_dest = $input->zip;
				
		foreach($cart_obj->items_collection as $item) {
		
			if($item->fs == "NFS") {
				//$total_nfs_weight += $item->weight * $item->qty;
					$rate = new Application_Model_Ups;
					$rate->upsProduct("GND"); // See upsProduct() function for codes
					$rate->origin("60616", "US"); // Use ISO country codes!
					$rate->dest($input->zip, "US"); // Use ISO country codes!
					$rate->rate("RDP"); // See the rate() function for codes
					$rate->container("CP"); // See the container() function for codes
					$rate->weight($item->weight);
					$rate->rescom("RES"); // See the rescom() function for codes
					$quote = $rate->getQuote();
					$item->shipping_quote = $quote;
				
			}		
		}
		$cart_obj->setShipping();
		$cart_obj->Save();
		
		$this->view->cart = $cart_obj;
		$string = $this->view->render("cart/cart-subtotals.phtml");
		
		$json = Zend_Json::encode(array(
        	'html' => $string,
    	 ));

    	echo $json;
    }


}



