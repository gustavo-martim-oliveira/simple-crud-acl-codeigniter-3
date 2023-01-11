<?php

class Category extends CI_Model {

	/**
	 * Set DB table
	 *
	 * @var string
	 */
	protected $table = 'categories';

	/**
	 * Get the articles
	 *
	 * @var $articles
	 */
	public $articles;

	/**
	 * Return list from DB table
	 * by default returns in object
	 *
	 * @param boolean $object
	 * @return void
	 */
	public function get($object = true) {

		$data = $this->db->get($this->table);

		if(!$object){
			$data = $data->result_array();
		}else{
			$data = $data->result();
		} 

		return $data;
	}

	public function getCategory(int $user_id){
		$this->db->where('id', $user_id);
		return $this->db->get($this->table)->result()[0] ?? false;
	}

	public function store($request){
		$this->db->insert($this->table, $request);
		return $this->db->insert_id();
	}

	public function update(array $request, int $id){
		return $this->db->update($this->table, $request, array('id' => $id));
	}

	public function destroy($id){
		$this->db->where('id', $id);
		return $this->db->delete($this->table);
	}

}
