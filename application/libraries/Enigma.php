<?php if ( !defined('BASEPATH')) exit('No direct script access allowed'); 

class Enigma {
	
	
    public function __construct()
    {
    }
    
    private function gen_rand_string($size)
    {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randstring = '';
	for ($i = 0; $i < $size; $i++) 
	    {
		$randstring .= $characters[rand(0, strlen($characters))];
	    }
	return $randstring;
    }    
    
    /* Returns a string array containing hash and a random salt */
    public function Encrypt($pass){
	
	if($pass == "")
		return null;
    	else
	{
		$rand_str = $this->gen_rand_string(14);
		return array(
				"rand_str" => $rand_str,
				"hash" => hash("sha256", $pass.$randStr));
	}
    }
    
    public function checkPass($pass, $hash, $salt)
    {
	if($hash == hash("sha256", $pass.$salt))
	    return true;
	else
	    return false;
    }
    

}
