<?php
class Customcart_Validator_PasswordMatch extends Zend_Validate_Abstract
{
	const MATCH = 'match';
 
    protected $_messageTemplates = array(

		self::MATCH => "Passwords do not match"
    );
 
    public function isValid($value)
    {
        $this->_setValue($value);
 
        $isValid = true;
 		
		$keys = array_keys($value);
 				
		
		if($value[$keys[0]] != $value[$keys[1]]) {
			$this->_error(self::MATCH);
			$isValid = false;	
		}
 
        return $isValid;
    }
}
?>