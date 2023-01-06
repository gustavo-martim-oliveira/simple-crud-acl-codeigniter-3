<?php

use Application\Facades\Auth;

class Users extends CI_Controller {

	public function __construct(){
		Parent::__construct();
		if(!auth_check()){
			redirect('login');
		}
	}

	public function index(){
		if(cannot('users_view')) redirect('dashboard');
		$this->load->model('user');
		$users = $this->user->getUsers();	
		return $this->view('pages/users/index', compact('users'));
	}

}
