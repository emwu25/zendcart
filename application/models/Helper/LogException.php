<?php 

class Application_Model_Helper_LogException { 
	
	public static function logToFile($exception_msg, $stack_trace, $ip, $code = null) {
		$file = "../logs/Exceptions.html";
		$string = "";
		$date= new DateTime();
		$string .= $date->format('U = Y-m-d H:i:s') . "-------- IP : " . $ip ."----------- Code: " . $code . "<br><br>";
		$string .= "Error: " . $exception_msg . "<br><br>";
		$string .= "Trace: " . $stack_trace . "<br><br><hr><br>";
		
		$res = file_put_contents($file, $string, FILE_APPEND | LOCK_EX);
	}
}

?>