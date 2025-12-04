<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Password{

	//Number of times to rehash
	private $rotations = 0 ;

	function encrypt_password($password, $username)
	{
		$randomsalt = rand(5, 6);
		$salt = hash('sha256', uniqid(mt_rand(), true) . $randomsalt . strtolower($username));

		$hash = $salt . $password;

		for ( $i = 0; $i < $this->rotations; $i ++ ) {
		  $hash = hash('sha256', $hash);
		}

		return $salt . $hash;
	}


	function is_valid_password($user_password,$dbpassword) {
		$salt = substr($dbpassword, 0, 64);

		$hash = $salt . $user_password;

		for ( $i = 0; $i < $this->rotations; $i ++ ) {
			$hash = hash('sha256', $hash);
		}

		//Sleep a bit to prevent brute force
		time_nanosleep(0, 400000000);
		$hash = $salt . $hash;

		return $hash == $dbpassword;
	}
} 
/* class Password{

	//Number of times to rehash
	private $rotations = 1;

	function encrypt_password($password, $username)
	{
		$randomsalt = rand(5, 6);
		$salt = hash('sha256', uniqid(mt_rand(), true) . $randomsalt . strtolower($username));
		$hash = $salt . $password;
		for ( $i = 0; $i < $this->rotations; $i ++ ) {
			$hash = hash('sha256', $hash);
		}
		return $salt . $hash;
	}


	function is_valid_password($user_password,$dbpassword) {
		$salt = substr($dbpassword, 0, 64);

		$hash = $salt . $user_password;

		for ( $i = 0; $i < $this->rotations; $i ++ ) {
			$hash = hash('sha256', $hash);
		}

		//Sleep a bit to prevent brute force
		time_nanosleep(0, 400000000);
		$hash = $salt . $hash;

		return $hash == $dbpassword;
	}
} */
