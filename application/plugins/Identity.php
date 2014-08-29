<?php 

Class Application_Plugin_Identity extends Zend_Controller_Plugin_Abstract {
	
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	   {
     			$layout = Zend_Layout::getMvcInstance();
      			$view = $layout->getView();
				$view->identity = $this->getIdentity();
				$cart_obj = new Application_Model_Cart();
				$cart_obj->getItems();
				$view->hasitems = $cart_obj->hasItems();
				
				
				$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
				$all_view = $viewRenderer->view;
				$all_view->ref = $this->getReferer();
				
	   }
	
	private function getIdentity() {
			$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()) {
			return $auth->getIdentity();
				
		}
		
		return null; 	
	}
	
	private function getReferer() {
		$ref_ns = new Zend_Session_Namespace('ref');
		//$ref_ns->ref = $this->data;	
		$referer = $this->getRequest()->getHeader('referer');
		if(!preg_match("#//cart#",$referer)) { 
			$ref_ns->ref = $referer;
			return $referer;
		}
			$referer = $ref_ns->ref;
			return $referer;
	}
}

?>