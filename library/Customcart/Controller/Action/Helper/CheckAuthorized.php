<?php
class Customcart_Controller_Action_Helper_CheckAuthorized extends Zend_Controller_Action_Helper_Abstract { 

	public function direct() { 
		
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()) {
			return true; 
				
		}
		
		return false; 
	}


}
?>