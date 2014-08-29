<?php

class CartController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }
	
	public function preDispatch() {
		//$response = $this->getResponse();
		//$response->prepend('referer', $this->getRequest()->getHeader('referer'));
	
	}

    public function indexAction()
    {
        // action body
    }

    public function viewAction()
    {
		//var_dump($this->getRequest()->getHeader('referer'));
		 
		//var_dump($layout);
        $cart_obj = new Application_Model_Cart(); 
		$cart_obj->getItems();
		$this->view->cart = $cart_obj;
		$subtotals = $this->view->render("cart/cart-subtotals.phtml");
		$cart_content = $this->view->render("cart/cart-items.phtml");
		$this->view->cart_content = $cart_content;
		$this->view->subtotals = $subtotals;
		if(!is_null($user_info = $this->_helper->getIdentity())) {
		$this->view->username = $user_info->name;
		}
    }

    public function updateAction()
    {
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
		
        $cart_obj = new Application_Model_Cart();
		$cart_obj->getItems(); 
		$validators = null;
		$filters = array(
    		'*'   =>	'StripTags',
		);
		$data = $this->_request->getParams();
		$input = new Zend_Filter_Input($filters, $validators, $data);		 
		
		$input->isValid();
		
		$input_values = $input->getEscaped();
		
		$cart_obj->updateSingleItem($input_values);
		
		$this->view->cart = $cart_obj;
		$cart_items = $this->view->render("cart/cart-items.phtml");
		$cart_subtotals = $this->view->render("cart/cart-subtotals.phtml");
		
		$json = Zend_Json::encode(array(
        	'html' => $cart_items,
			'subtotals' => $cart_subtotals
    	 ));

    	echo $json;
		
    }



}







