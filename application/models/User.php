<?php

class User extends CI_Model {

	/**
	 * Set DB table
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * Return list from DB table
	 * by default returns in object
	 *
	 * @param boolean $object
	 * @return void
	 */
	public function getUsers($object = true) {

		$data = $this->db->get($this->table);

		if(!$object){
			$data = $data->result_array();
		}else{
			$data = $data->result();
		} 

		return $data;
	}

	public function getUser(int $user_id){
		$this->db->where('id', $user_id);
		return $this->db->get($this->table)->result()[0] ?? false;
	}

	public function getUserByEmail(string $email){
		$this->db->where('email', $email);
		return $this->db->get($this->table)->result()[0] ?? false;
	}

	public function getUserByLogin(string $login){
		$this->db->where('login', $login);
		return $this->db->get($this->table)->result()[0] ?? false;
	}

	public function auth($email, $password){
		$this->db->where('email', $email);
		$user = $this->db->get($this->table)->result()[0];
		if(isset($user->password) && !empty($user->password) && password_verify($password, $user->password)){
			return $user;
		}
		return false;
	}

	public function store($request){
		$this->db->insert($this->table, $data);
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
