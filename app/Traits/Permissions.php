<?php

namespace App\Traits;

trait Permissions
{
	public function permissions() {
      	return $this->belongsToMany('App\Permission');
	}

	public function roles() {
      	return $this->belongsToMany('App\Role');
	}

	public function hasRole( ... $roles ) {
   		foreach($roles as $role) {
      		if($this->roles->contains('slug', $role)) {
         		return true;
      		}
   		}

   		return false;
	}

	protected function hasPermission( $permission ) {
   		return (bool) $this->permissions->where('slug', $permission->slug)->count();
	}

	// Checks if the user has the given permission through his roles
	public function hasRolePermission( $permission ) {
    	foreach($permission->roles as $role) {
      		if($this->roles->contains($role)) {
        		return true;
    		}
   		}
   		
   		return false;
	}

	protected function hasPermissionTo( $permission ) {
   		return $this->hasRolePermission($permission) || $this->hasPermission($permission);
	}
}