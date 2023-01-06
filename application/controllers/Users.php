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

	public function create(){
		if(cannot('users_create')) redirect('dashboard');
		$this->load->model('permission');
		$roles = $this->permission->roles();
		$roles_count = count((array)$roles);

		//Check if roles are been created
		if(!$roles or $roles_count < 2 && getRole()->id != 1){
			$this->session->set_flashdata('error', 'Para criar um usuário, você deve criar as permissões.');
			return redirect('users');
		}

		return $this->view('pages/users/create', compact('roles'));
	}

	public function store(){
		#Store a old form data
		$this->session->set_flashdata('__formOld', $_POST);

		#Load model
		$this->load->model('user');

		#filter all inputs data
		$request = $this->dataFilter($_POST);

		#validate the inputs of users created
		$validate = $this->validateStoreRequest($request);
		
		#check if is validated
		if(!$validate){
			return $validate;
		}

		#Check if email exists
		$email_exists = $this->user->getUserByEmail($request['email']);
		if(count((array) $email_exists) >= 1){
			$this->session->set_flashdata('error', 'Este email já está em uso');
			return redirect('users/create');
		}

		#Check if login exists
		$login_exists = $this->user->getUserByLogin($request['login']);
		if(count((array) $login_exists) >= 1){
			$this->session->set_flashdata('error', 'Este login já está em uso');
			return redirect('users/create');
		}

		#separate level from user Array
		$level = (int) $request['level'];
		unset($request['level']);

		#hash password
		$request['password'] = password_hash($request['password'], null);

		#store
		$user_id = $this->user->store($request);

		#set level
		$this->load->model('permission');
		$this->permission->setUserRole($user_id, $level);

		#unset old session
		$this->session->unset_userdata('__formOld');

		#return with success
		$this->session->set_flashdata('success', 'Usuário cadastrado com sucesso');
		return redirect('users');

	}

	public function edit($id){
		$this->load->model('user');
		$user = $this->user->getUser($id);

		$this->load->model('permission');
		$roles = $this->permission->roles();
		$roles_count = count((array)$roles);

		//Check if roles are been created
		if(!$roles or $roles_count < 2 && getRole()->id != 1){
			$this->session->set_flashdata('error', 'Para editar um usuário, você deve criar as permissões.');
			return redirect('users');
		}

		$this->view('pages/users/edit', compact('user', 'roles'));
	}

	public function update($id){
		#Store a old form data
		$this->session->set_flashdata('__formOld', $_POST);

		#Load model
		$this->load->model('user');

		#filter all inputs data
		$request = $this->dataFilter($_POST);
		
		#validate the inputs of users created
		$validate = $this->validateStoreRequest($request, true, 'users/edit/'.$id);
		
		#check if is validated
		if(!$validate){
			return $validate;
		}

		#Check if email exists
		$email_exists = $this->user->getUserByEmail($request['email']);
		if(count((array) $email_exists) >= 1 && $request['email'] != auth_user()->email){
			$this->session->set_flashdata('error', 'Este email já está em uso');
			// return redirect('users/create');
		}

		#Check if login exists
		$login_exists = $this->user->getUserByLogin($request['login']);
		if(count((array) $login_exists) >= 1 && $request['email'] != auth_user()->login){
			$this->session->set_flashdata('error', 'Este login já está em uso');
			// return redirect('users/create');
		}

		#separate level from user Array
		$level = (int) $request['level'];
		unset($request['level']);

		#loadUser before update to keep password
		$user = $this->user->getUser($id);
		if($request['password'] == null or empty($request['password'])){
			$request['password'] = $user->password;
		}else{
			$request['password'] = password_hash($request['password'], null);
		}

		#update user
		$this->user->update($request, $id);

		#set level
		$this->load->model('permission');
		$this->permission->setUserRole($id, $level);

		#unset old session
		$this->session->unset_userdata('__formOld');

		#return with success
		$this->session->set_flashdata('success', 'Usuário modificado com sucesso');
		return redirect('users');

	}

	public function destroy($id){
		$request = $_POST;
		$id = (int) $id ?? $request['id'];
		
		if($id === auth_id()){
			$this->session->set_flashdata('error', 'Você não pode se excluir!');
			return redirect('users');
		}

		$this->load->model('user');
		$this->user->destroy($id);

		$this->session->set_flashdata('success', 'Usuário excluído com sucesso!');
		return redirect('users');

	}

	protected function dataFilter($post){
		$data = [];
		foreach($post as $key => $value){
			$data[$key] = htmlspecialchars(stripslashes(trim($value)));
		}
		return $data;
	}

	protected function validateStoreRequest($request, $nopassword = false, $url = 'users/create'){
		if(empty($request['name'])){
			$this->session->set_flashdata('error', 'O campo nome não pode ser vazio!');
			return redirect($url);
		}

		if(strlen($request['name']) > 100){
			$this->session->set_flashdata('error', 'O campo nome não pode conter mais que 100 caracteres!');
			return redirect($url);
		}

		if(strlen($request['name']) < 4){
			$this->session->set_flashdata('error', 'O campo nome não pode conter menos que 4 caracteres!');
			return redirect($url);
		}

		if(empty($request['login'])){
			$this->session->set_flashdata('error', 'O campo login não pode ser vazio!');
			return redirect($url);
		}

		if(strlen($request['login']) > 64){
			$this->session->set_flashdata('error', 'O campo login não pode conter mais que 64 caracteres!');
			return redirect($url);
		}

		if(strlen($request['login']) < 4){
			$this->session->set_flashdata('error', 'O campo login não pode conter menos que 4 caracteres!');
			return redirect($url);
		}

		if($nopassword != true){
			if(empty($request['password'])){
				$this->session->set_flashdata('error', 'O campo senha não pode ser vazio!');
				return redirect($url);
			}
	
			if(strlen($request['password']) > 191){
				$this->session->set_flashdata('error', 'O campo senha não pode conter mais que 191 caracteres!');
				return redirect($url);
			}
	
			if(strlen($request['password']) < 4){
				$this->session->set_flashdata('error', 'O campo senha não pode conter menos que 4 caracteres!');
				return redirect($url);
			}
		}

		if(empty($request['email'])){
			$this->session->set_flashdata('error', 'O campo email não pode ser vazio!');
			return redirect($url);
		}

		if(!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
			$this->session->set_flashdata('error', 'Este email não parece ser válido!');
			return redirect($url);
		}

		if(strlen($request['email']) > 191){
			$this->session->set_flashdata('error', 'O campo email não pode conter mais que 191 caracteres!');
			return redirect($url);
		}

		if(strlen($request['email']) < 4){
			$this->session->set_flashdata('error', 'O campo email não pode conter menos que 4 caracteres!');
			return redirect($url);
		}


		if(empty($request['level'])){
			$this->session->set_flashdata('error', 'O campo nível do usuário é obrigatório!');
			return redirect($url);
		}

		if(isset($request['status']) && $request['status'] == '' or isset($request['status']) && $request['status'] == null ){
			$this->session->set_flashdata('error', 'O campo status é obrigatório');
			return redirect($url);
		}

		return true;

	}

}
