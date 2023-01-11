<?php

use Application\Facades\Image;

class Articles extends CI_Controller {

	public function __construct(){
		Parent::__construct();
		if(!auth_check()){
			redirect('login');
		}
	}

	public function index(){
		if(cannot('articles_view')) redirect('dashboard');
		$this->load->model('article');
		$articles = $this->article->get();	
		return $this->view('pages/articles/index', compact('articles'));
	}

	public function create(){
		if(cannot('articles_view')) redirect('dashboard');
		return $this->view('pages/articles/create');
	}

	public function store(){

		if(cannot('articles_view')){
			$this->session->set_flashdata('error', 'Você não tem permissão para realizar esta ação');
			return redirect('articles');
		}

		#Store a old form data
		$this->session->set_flashdata('__formOld', $_POST);

		$image = $this->filterFiles($_FILES['photo']);
		$images = [];
		foreach($image as $key => $img){
			
			$path = FCPATH . 'assets/uploads';

			$sendImage = new Image($img);
			$sendImage->upload($path, true);

			if($sendImage->errors()){
				$this->session->set_flashdata('error', $sendImage->messages()[0]);
				return redirect('articles/create');
			}

		}

	

		#Load model
		$this->load->model('category');

		#filter all inputs data
		$request = $this->dataFilter($_POST);

		#store
		$this->category->store($request);

		#unset old session
		$this->session->unset_userdata('__formOld');

		#return with success
		$this->session->set_flashdata('success', 'Aritgo cadastrado com sucesso');
		return redirect('articles');

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

	protected function filterFiles($file_post){
		$isMulti    = is_array($file_post['name']);
		$file_count = $isMulti?count($file_post['name']):1;
		$file_keys  = array_keys($file_post);

		$file_ary    = [];
		for($i=0; $i<$file_count; $i++)
			foreach($file_keys as $key)
				if($isMulti)
					$file_ary[$i][$key] = $file_post[$key][$i];
				else
					$file_ary[$i][$key]    = $file_post[$key];

		return $file_ary;
	}

}
