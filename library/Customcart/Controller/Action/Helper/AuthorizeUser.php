<?php
class Customcart_Controller_Action_Helper_AuthorizeUser extends Zend_Controller_Action_Helper_Abstract { 

	public function direct($login, $password) { 
		
			$db = Zend_Db_Table::getDefaultAdapter();
			$authadapter = new Zend_Auth_Adapter_DbTable($db, 'customers','username', 'password');
			$authadapter->setIdentity($login);
			$authadapter->setCredential($password);
			
			$auth = Zend_Auth::getInstance();
			$result = $auth->authenticate($authadapter);
					
			
			if($result->isValid()) { 
				
				$user = $authadapter->getResultRowObject(array('name','lp','username','password'));
			 	$auth->getStorage()->write($user);
				return true;
			 } else { 
				return false; 
			 }
	}


}

?>