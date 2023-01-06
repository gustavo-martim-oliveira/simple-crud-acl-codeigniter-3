<?php

use Application\Facades\Auth;

function auth_user(){
	return Auth::user();
}

function auth_id(){
	return Auth::id();
}

function auth_check(){
	return Auth::check();
}
