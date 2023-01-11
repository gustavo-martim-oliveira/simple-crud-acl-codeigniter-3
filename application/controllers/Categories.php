<?php

class Categories extends CI_Controller {

	public function __construct(){
		Parent::__construct();
		if(!auth_check()){
			redirect('login');
		}
	}

	public function index(){
		if(cannot('categories_view')) redirect('dashboard');
		$this->load->model('category');
		$categories = $this->category->get();	
		return $this->view('pages/categories/index', compact('categories'));
	}

	public function create(){
		if(cannot('categories_view')) redirect('dashboard');
		return $this->view('pages/categories/create');
	}

	public function store(){

		if(cannot('categories_view')){
			$this->session->set_flashdata('error', 'Você não tem permissão para realizar esta ação');
			return redirect('categories');
		}

		#Store a old form data
		$this->session->set_flashdata('__formOld', $_POST);

		#Load model
		$this->load->model('category');

		#filter all inputs data
		$request = $this->dataFilter($_POST);

		#store
		$this->category->store($request);

		#unset old session
		$this->session->unset_userdata('__formOld');

		#return with success
		$this->session->set_flashdata('success', 'Categoria cadastrada com sucesso');
		return redirect('categories');

	}

	public function edit($id){

		if(cannot('categories_update')){
			$this->session->set_flashdata('error', 'Você não tem permissão para realizar esta ação');
			return redirect('categories');
		}

		$this->load->model('category');
		$category = $this->category->getCategory($id);
		$this->view('pages/categories/edit', compact('category'));
	}

	public function update($id){
		if(cannot('categories_update')){
			$this->session->set_flashdata('error', 'Você não tem permissão para realizar esta ação');
			return redirect('categories');
		}

		#Store a old form data
		$this->session->set_flashdata('__formOld', $_POST);

		#Load model
		$this->load->model('category');

		#filter all inputs data
		$request = $this->dataFilter($_POST);

		#store
		$this->category->update($request, (int) $id);

		#unset old session
		$this->session->unset_userdata('__formOld');

		#return with success
		$this->session->set_flashdata('success', 'Categoria atualizada com sucesso');
		return redirect('categories');

	}

	public function destroy($id){

		if(cannot('categories_delete')){
			$this->session->set_flashdata('error', 'Você não tem permissão para realizar esta ação');
			return redirect('categories');
		}

		$request = $_POST;
		$id = (int) $id ?? $request['id'];
		$this->load->model('category');
		$this->category->destroy($id);

		$this->session->set_flashdata('success', 'Categoria excluída com sucesso!');
		return redirect('categories');

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
