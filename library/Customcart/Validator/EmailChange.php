<?php
class Customcart_Validator_EmailChange extends Zend_Validate_Abstract
{
	const EXISTS = 'EmailExists';
	protected $_customer;
	
	 
    protected $_messageTemplates = array(

		self::EXISTS => "Email %value% already exists."
    );
	

	
	public function __construct($customer_obj) {
		$this->_customer = $customer_obj;	
	}
 
    public function isValid($value)
    {
        $this->_setValue($value);
 
        $isValid = true;
		
			
		if(Application_Model_Customer::checkIfExists("username", $value) && ($this->_customer->address->email != $value)) {
			$this->_error(self::EXISTS);
			$isValid = false;
				
		}
 
        return $isValid;
    }
}
?>