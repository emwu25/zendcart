<?php
class Customcart_Validator_EmailNotExists extends Zend_Validate_Abstract
{
	const EXISTS = 'EmailExists';
 
    protected $_messageTemplates = array(

		self::EXISTS => "Email %value% does not exist."
    );
 
    public function isValid($value)
    {
        $this->_setValue($value);
 
        $isValid = true;
		
			
		if(!Application_Model_Customer::checkIfExists("username", $value)) {
			$this->_error(self::EXISTS);
			$isValid = false;
				
		}
 
        return $isValid;
    }
}
?>