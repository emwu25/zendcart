<?php 

Class Application_Plugin_Website extends Zend_Controller_Plugin_Abstract {
	
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	   {
     			$layout = Zend_Layout::getMvcInstance();
      			$view = $layout->getView();
				$env = getenv("website");
				$view->website = new Application_Model_Website($env);
				
	   }
	
}

?>