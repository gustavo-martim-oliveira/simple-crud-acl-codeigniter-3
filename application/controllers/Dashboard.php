<?php

use Application\Facades\Auth;

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {


	public function index()
	{

		if(!Auth::check()){
			redirect('login');
		}
		
		$this->load->model('user');
		$users = $this->user->getUsers(false);

		$this->view('pages/dashboard', compact('users'));
	}
}
