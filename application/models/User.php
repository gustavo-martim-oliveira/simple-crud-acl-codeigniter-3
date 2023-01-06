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

	public function auth($email, $password){
		$this->db->where('email', $email);
		$user = $this->db->get($this->table)->result()[0];
		if(isset($user->password) && !empty($user->password) && password_verify($password, $user->password)){
			return $user;
		}
		return false;
	}

}
