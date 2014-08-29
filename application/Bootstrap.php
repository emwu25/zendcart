<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initInitHelpers() { 
		Zend_Controller_Action_HelperBroker::addPrefix('Customcart_Controller_Action_Helper');
	}
	protected function _initSessions() {
		
		Zend_Session::start();	
	}
	
	protected function _initCustomPlugin() {
		$front = Zend_Controller_Front::getInstance();
		$front->registerPlugin(new Application_Plugin_Identity());
		$front->registerPlugin(new Application_Plugin_Website());	
	}

}

