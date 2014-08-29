<?php
class Customcart_Validator_EmailExists extends Zend_Validate_Abstract
{
	const EXISTS = 'EmailExists';
 
    protected $_messageTemplates = array(

		self::EXISTS => "Email %value% already exists."
    );
 
    public function isValid($value)
    {
        $this->_setValue($value);
 
        $isValid = true;
		
			
		if(Application_Model_Customer::checkIfExists("username", $value)) {
			$this->_error(self::EXISTS);
			$isValid = false;
				
		}
 
        return $isValid;
    }
}
?>