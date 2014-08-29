<?php

class ItemController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function addAction()
    {
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(); 
		$validators = null;
		$filters = array(
    		'*'   =>	'StripTags',
		);
		$data = $this->_request->getParams();
		$input = new Zend_Filter_Input($filters, $validators, $data);		 
		
		$input->isValid();
		
		$input_values = $input->getEscaped();
		
		$item_input;
		$item_options = Array();
		
		$pattern = "#item#";
		$option_pattern= "#op#";
		
		foreach($input_values as $key => $value) {
			//echo $key . " <br>";
			if(preg_match($pattern, $key)) {
				$item_input = $value;
			}
			if(preg_match($option_pattern, $key)) {
				$item_options[$key] = $value;
			}
		}
		
		$cart_obj = new Application_Model_Cart();
		$cart_obj->addItem($item_input, $item_options);
		//$this->_helper->actionStack('view', 'cart');
		$this->_redirect("/cart/view");
    }


}



