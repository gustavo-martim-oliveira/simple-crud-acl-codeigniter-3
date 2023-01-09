<?php
/**
 * 
 * @author Gustavo Martim <gustavo@spdev.com.br>
 * @version 1.0.0
 * 
 * ACL - Access Control List for CodeIgniter 3.1
 * 
 * This class is responsible to select and return
 * all tables data in a responsible and orderly manner
 * 
 */

class Permission extends CI_Model {

	// Set the roles table
	protected $roles = 'roles';

	//Set the permissions table
	protected $permissions = 'permissions';

	//Set the roles & permissions table
	protected $roles_permission = 'roles_permissions';

	//set the user & roles table
	protected $users_role = 'users_role';

	//set the user & permissions table
	protected $users_permission = 'users_permission';

	/**
	 * Retrieve all or one data
	 * of table roles
	 *
	 * @param integer|null $role_id
	 * @return void
	 */
	public function roles(int $role_id = null){
		if($role_id != null){
			$this->db->where('id', $role_id);
			return $this->db->get($this->roles)->result()[0] ?? false;
		}
		return $this->db->get($this->roles)->result() ?? false;
	}

	/**
	 * Retrieve all or one data
	 * of table permissions
	 *
	 * @param integer|null $permission_id
	 * @return void
	 */
	public function permissions(int $permission_id = null){
		if($permission_id != null){
			$this->db->where('id', $permission_id);
			return $this->db->get($this->permissions)->result()[0] ?? false;
		}
		return $this->db->get($this->permissions)->result() ?? false;
	}

	/**
	 * Retrieve all or a determinate
	 * roles and permissions data
	 *
	 * @param integer|null $role_id
	 * @param integer|null $permission_id
	 * @return void
	 */
	public function role_permissions(int $role_id = null, int $permission_id = null){
		if($role_id != null){
			$this->db->where('role_id', $role_id);
			if($permission_id != null){
				$this->db->where('permission_id', $permission_id);
				return $this->db->get($this->roles_permission)->result()[0] ?? false;
			}
		}
		return $this->db->get($this->roles_permission)->result() ?? false;
	}

	/**
	 * Retrive all or a determinate
	 * user and permissions data
	 *
	 * @param integer|null $user_id
	 * @param integer|null $permission_id
	 * @return void
	 */
	public function user_permission(int $user_id = null, int $permission_id = null){
		if($user_id != null){
			$this->db->where('user_id', $user_id);
			if($permission_id != null){
				$this->db->where('permission_id', $permission_id);
				return $this->db->get($this->users_permission)->result()[0] ?? false;
			}
		}
		return $this->db->get($this->users_permission)->result() ?? false;
	}

	/**
	 * Retrieve all or one data
	 * of table users & roles
	 *
	 * @param integer|null $user_id
	 * @param boolean $onlySuperAdmins
	 * @return void
	 */
	public function user_role(int $user_id = null, $onlySuperAdmins = false){

		if($onlySuperAdmins){
			$this->db->where('role_id', 1);
			return $this->db->get($this->users_role)->result() ?? false;
		}

		if($user_id != null){
			$this->db->where('user_id', $user_id);
			return $this->db->get($this->users_role)->result()[0] ?? false;
		}else{
			return $this->db->get($this->users_role)->result() ?? false;
		}
	}

	/**
	 * Retrieve all data 
	 * of table permission by
	 * the name of permission
	 *
	 * @param string $permission
	 * @return void
	 */
	public function permissionByName(string $permission){
		$this->db->where('title', $permission);
		return $this->db->get($this->permissions)->result()[0] ?? false;
	}

	public function setUserRole(int $user_id, int $role_id){

		$this->db->where('user_id', $user_id);
		$result = $this->db->get($this->users_role)->result()[0];

		if($result){
			$this->db->update($this->users_role, [
				'user_id' => $user_id,
				'role_id' => $role_id
			], array('id' => $result->id));
		}else{
			$data = [
				'user_id' => $user_id,
				'role_id' => $role_id
			];
			return $this->db->insert($this->users_role, $data);
		}

		
	}

	public function unsetUserRoles(int $user_id){
		$this->db->where('user_id', $user_id);
		return $this->db->delete($this->users_role);
	}

	public function unsetUserPermission(int $user_id){
		$this->db->where('user_id', $user_id);
		return $this->db->delete($this->users_permission);
	}

	public function unsetRolesPermission(int $role_id){
		$this->db->where('role_id', $role_id);
		return $this->db->delete($this->roles_permission);
	}

	public function storeRole(string $role){
		$this->db->insert($this->roles, ['title' => $role]);
		return $this->db->insert_id();
	}

	public function storeRolePermission(int $role_id, int $permission_id){
		return $this->db->insert($this->roles_permission, ['role_id' => $role_id, 'permission_id' => $permission_id]);
	}

	public function updateRole(string $title, int $id){
		return $this->db->update($this->roles, ['title' => $title], array('id' => $id));
	}

	public function destroyRole(int $role){
		
		try{
			$this->db->where('role_id', $role);
			$this->db->delete($this->roles_permission);

			$this->db->where('role_id', $role);
			$this->db->delete($this->users_role);

			$this->db->where('id', $role);
			$this->db->delete($this->roles);

			return true;
		}catch(Exception $e){
			return false;
		}
		

	}

	public function syncPermissions(int $role_id, array $permissions){
		$this->unsetRolesPermission($role_id);
		foreach($permissions as $key => $value){
			$permission = $this->permissionByName($key);
			$this->storeRolePermission($role_id, $permission->id);
		}
	}
}
