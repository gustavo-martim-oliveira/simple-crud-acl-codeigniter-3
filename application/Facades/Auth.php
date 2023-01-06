<?php
/**
 * 
 * Create a helper
 * to Authentication class
 * 
 */

namespace Application\Facades;

class Auth {
	
	public static function user(){
		return $_SESSION['Auth'] ?? null;		
	}

	public static function check(){
		return isset($_SESSION['Auth']) && isset($_SESSION['Auth']->id) ? true : false;
	}

	public static function id(){
		return $_SESSION['Auth']->id;
	}
}
