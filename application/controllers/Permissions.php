<?php

use Application\Facades\Auth;

class Permissions extends CI_Controller {

	public function __construct(){
		Parent::__construct();
		if(!auth_check()){
			redirect('login');
		}
	}

	public function index(){
		if(cannot('permissions_view')) redirect('dashboard');
		$this->load->model('permission');
		$roles = $this->permission->roles();	
		$roles = array_filter((array) $roles, function($role){
			//Not show the super admin
			return $role->id != 1;
		});
		return $this->view('pages/permissions/index', compact('roles'));
	}

	public function create(){
		if(cannot('permissions_create')) redirect('dashboard');
		$this->load->model('permission');
		$roles = $this->permission->roles();
		$roles_count = count((array)$roles);

		//Check if roles are been created
		if(!$roles or $roles_count < 2 && getRole()->id != 1){
			$this->session->set_flashdata('error', 'Para criar um usuário, você deve criar as permissões.');
			return redirect('users');
		}

		return $this->view('pages/permissions/create', compact('roles'));
	}

	public function store(){

		if(cannot('permissions_create')){
			$this->session->set_flashdata('error', 'Você não tem permissão para realizar esta ação');
			return redirect('permissions');
		}

		#Store a old form data
		$this->session->set_flashdata('__formOld', $_POST);

		#Load model
		$this->load->model('permission');

		#filter all inputs data
		$request = $this->dataFilter($_POST);

		#set level
		$role_id = $this->permission->storeRole($request['title']);
		$this->permission->syncPermissions($role_id, $_POST['permission']);

		#unset old session
		$this->session->unset_userdata('__formOld');

		#return with success
		$this->session->set_flashdata('success', 'Permissão cadastrada com sucesso');
		return redirect('permissions');

	}

	public function edit($id){
		if(cannot('permissions_update')){
			$this->session->set_flashdata('error', 'Você não tem permissão para realizar esta ação');
			return redirect('permissions');
		}
		$this->load->model('permission');

		$role = $this->permission->roles($id);
		$permissions = $this->permission->role_permissions($id);

		$filter = $this->permission;
		$permissions = array_map( function($permission) use ($filter){
			return $filter->permissions($permission->permission_id);
		}, (array) $permissions);


		$this->view('pages/permissions/edit', compact('permissions', 'role'));
	}

	public function update($id){
		if(cannot('permissions_update')){
			$this->session->set_flashdata('error', 'Você não tem permissão para realizar esta ação');
			return redirect('permissions');
		}

		#Store a old form data
		$this->session->set_flashdata('__formOld', $_POST);

		#Load model
		$this->load->model('permission');

		#filter all inputs data
		$request = $this->dataFilter($_POST);

		#set level
		$role_id = $this->permission->updateRole($request['title'], (int) $id);
		$this->permission->syncPermissions($id, $_POST['permission']);

		#unset old session
		$this->session->unset_userdata('__formOld');

		#return with success
		$this->session->set_flashdata('success', 'Permissão atualizada com sucesso');
		return redirect('permissions');

	}

	public function destroy($id){

		if(cannot('permissions_delete')){
			$this->session->set_flashdata('error', 'Você não tem permissão para realizar esta ação');
			return redirect('permissions');
		}

		$request = $_POST;
		$id = (int) $id ?? $request['id'];
		$this->load->model('permission');
		$this->permission->destroyRole($id);

		$this->session->set_flashdata('success', 'Permissão excluída com sucesso!');
		return redirect('permissions');

	}

	protected function dataFilter($post){
		$data = [];
		foreach($post as $key => $value){
			if(!is_array($value)){
				$data[$key] = htmlspecialchars(stripslashes(trim($value)));
			}			
		}
		return $data;
	}

}
