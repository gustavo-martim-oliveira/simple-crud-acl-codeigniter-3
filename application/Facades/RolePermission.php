<?php

namespace Application\Facades;

class RolePermission extends Auth{
	//User data getting of Auth Class
	protected $user;

	//Set the model name of Permission ACL
	protected $model = 'permission';
	
	public function __construct() {
		//Retrieve the authenticated user data
		$this->user = Self::user();
	}

	/**
	 * 
	 * Verify if the user has the
	 * correct permission to target module
	 * 
	 * @param string $permission
	 * @return boolean
	 */
	public function can(string $permission) : bool {
		#Retrieve the permission information
		$permission = $this->getPermissionByName($permission);

		#Retrieve the user role if exists
		$role = $this->getUserRole();

		if(!$role){
			return false;
		}

		#Set super admin mode
		if((int) $role->role_id === 1){
			return true;
		}
		
		#check if the rule are setted
		if(is_bool($role) && !$role){
			return false;
		}

		#Check if permission and role is false
		if(!$permission && $role or !$permission && !$role){
			return false;
		}

		#Verify the permissions
		if($this->hasRolePermission($role->role_id,$permission->id) or $this->hasUserPermission($permission->id)){
			return true;
		}

		#else return false
		return false;
	}

	/**
	 * verify if the user not has the
	 * correct permission to target module
	 * 
	 * Attention: this is the inverse of can
	 *
	 * @param string $permission
	 * @return boolean
	 */
	public function cannot(string $permission) : bool {
		if($this->can($permission)) return false;
		return true;
	}

	/**
	 * Check if user has role
	 * to access the module
	 *
	 * @param integer $role_id
	 * @param integer $permission_id
	 * @return boolean
	 */
	protected function hasRolePermission(int $role_id, int $permission_id) {
		$CI = get_instance();
		$CI->load->model($this->model);
		return $CI->permission->role_permissions($role_id, $permission_id);
	}

	/**
	 * Check if user has permission
	 * to access the module
	 *
	 * @param integer $permission_id
	 * @return boolean
	 */
	protected function hasUserPermission(int $permission_id) {
		$CI = get_instance();
		$CI->load->model($this->model);
		return $CI->permission->user_permission($this->user->id, $permission_id) ?? false;
	}

	/**
	 * Retrieve the permission by name
	 *
	 * @param string $permission
	 * @return void
	 */
	public function getPermissionByName($permission) {
		$CI = get_instance();
		$CI->load->model($this->model);
		return $CI->permission->permissionByName($permission) ?? false;
	}

	/**
	 * Retrieve the Role data
	 *
	 * @return void
	 */
	public function getUserRole(int $user_id = null){
		$CI = get_instance();
		$CI->load->model($this->model);

		$id = $this->user->id;
		if($user_id != null){
			$id = (int) $user_id;
		}
		return $CI->permission->user_role($id) ?? false;
	}

	/**
	 * Retrieve the role information
	 *
	 * @return void
	 */
	public function getRole(int $user_id = null){
		$id = $this->getUserRole($user_id);
		$CI = get_instance();
		$CI->load->model($this->model);
		if($id != false){
			return $CI->permission->roles($id->role_id) ?? null;
		}
		return 0;
	}

}
