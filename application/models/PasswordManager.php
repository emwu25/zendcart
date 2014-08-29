<?php 

class Application_Model_PasswordManager { 

	private $data; 

	public function  __get($name) {  
        // check if the named key exists in our array  
        if(array_key_exists($name, $this->data)) {  
            // then return the value from the array  
            return $this->data[$name];  
        }  
        return null;  
    } 
	
	public function  __set($name, $value) {  
        // use the property name as the array key  
        $this->data[$name] = $value;  
    }
	
	
	public function verifyAndReset($reset_data, $website) { 
		$user_id = $reset_data["u"];
		$user_token = $reset_data["s"];
		$temp_customer = new Application_Model_Customer();
		$temp_customer->getCustomer($user_id);
		$generated_token = $this->generateSecretString($temp_customer);
		if($user_token != $generated_token) { 
			throw new Exception("Unauthorized attempt to change password for user " . $user_id .". Tokens do not match. <br> Supplied token: ". $user_token." <br>Actual token: " .$generated_token );
		} else { 
			$pass = $this->generateRandomPassword();
			$result = $temp_customer->changePassword($pass); 
			if($result != 1) {
				throw new Exception("Password change failed. Variable result returned " . $result. " rows changed.");  	
			} 
			$email = new Application_Model_NewPassEmail($temp_customer, $website, $pass);
			$email->sendEmail();
			
			
		}
		
	}
	
	private function generateSecretString($customer) { 
		
		$string = $customer->id . "" . $customer->username . "" . $customer->address->address1 . "" . $customer->address->zip . "" . "This is some random salt for the security string that has to be long bla bla bla terefere";
		$string = hash("sha512", $string);
		return $string; 
	} 
	
	private function generateRandomPassword() {
  		//Initialize the random password
  		$password = '';

  		//Initialize a random desired length
  		$desired_length = rand(8, 12);

		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    	$password = substr( str_shuffle( $chars ), 0, $desired_length );
  		return $password;
	}

}

?>