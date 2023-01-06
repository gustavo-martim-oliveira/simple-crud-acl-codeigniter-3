<?php

use Application\Facades\RolePermission;

function can(string $permission){
	$can = new RolePermission;
	return $can->can((string) $permission);
}

function cannot(string $permission){
	$cannot = new RolePermission;
	return $cannot->cannot((string) $permission);
}

function getRole(){
	$role = new RolePermission;
	return $role->getRole();
}
