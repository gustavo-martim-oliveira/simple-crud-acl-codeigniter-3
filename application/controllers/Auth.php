<?php

use Application\Facades\Auth as FacadeAuth;

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function login()
	{
		$this->verifyAuth();
		$this->load->view('pages/login');
	}

	/**
	 * Request the POST and set
	 * the user login and redirect
	 * to the dashboard if needed
	 *
	 * @return void
	 */
	public function auth(){
		$email = trim($_POST['email']);
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->session->set_flashdata('error', 'Este email não parece ser válido!');
			redirect('login');
		}

		if(strlen($email) <= 4 or strlen($email) > 191){
			$this->session->set_flashdata('error', 'O tamanho do email deve ser maior que 4 e menor que 191 caracteres');
			redirect('login');
		}

		$password = htmlspecialchars(stripslashes(trim($_POST['password'])));
		$auth = $this->setLoginAuth($email, $password);
		if(!$auth){
			$this->session->set_flashdata('error', 'Usuário não encontrado!');
			redirect('login');
		}else{
			$this->session->set_userdata("Auth", $auth);
			redirect("dashboard");
		}
		
	}


	/**
	 * Unset session active 
	 * and redirect user to login
	 *
	 * @return void
	 */
	public function logout(){
		$this->session->unset_userdata('Auth');
		redirect('login');
	}

	/**
	 * Verify if user already
	 * has a session
	 *
	 * @return void
	 */
	private function verifyAuth(){
		if(FacadeAuth::check()){
			redirect('dashboard');
		}
	}
	
	/**
	 * Set the connection with model
	 * and return all user data
	 *
	 * @param string $email
	 * @param string $password
	 * @return void
	 */
	private function setLoginAuth(string $email, string $password){
		$this->load->model('User');
		$user = $this->User->auth($email, $password);
		return $user;
	}
}
