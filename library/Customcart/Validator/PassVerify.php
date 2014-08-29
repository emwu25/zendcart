<?php
class Customcart_Validator_PassVerify extends Zend_Validate_Abstract
{
	const WRONG_PASS = 'WrongPass';
	protected $_pass;
	
	 
    protected $_messageTemplates = array(

		self::WRONG_PASS => "Invalid Password Supplied."
    );
	

	
	public function __construct($pass) {
		$this->_pass = $pass;	
	}
 
    public function isValid($value)
    {
        $this->_setValue($value);
 
        $isValid = true;
		
			
		if($value != $this->_pass) {
			$this->_error(self::WRONG_PASS);
			$isValid = false;
				
		}
 
        return $isValid;
    }
}
?>