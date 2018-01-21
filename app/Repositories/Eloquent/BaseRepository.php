<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\RepositoryInterface;

/**
 * Laravel 5 Repositories is used to abstract the data layer, making our application more flexible to maintain.
 *
 * The Abstract Repository provides default implementations of the methods defined
 * in the base repository interface. These simply delegate static function calls 
 * to the right eloquent model based on the $modelClassName.
 *	
 * I usually use something more complex(package) : https://github.com/andersao/l5-repository
 *
 */
abstract class BaseRepository implements RepositoryInterface
{
    protected $modelClassName;

	public function create(array $attributes)
	{
		return call_user_func_array("{$this->modelClassName}::create", array($attributes));
	}

	public function all($columns = array('*'))
	{
		return call_user_func_array("{$this->modelClassName}::all", array($columns));
	}
	
	public function find($id, $columns = array('*'))
	{
		return call_user_func_array("{$this->modelClassName}::find", array($id, $columns));
	}
	
	public function destroy($ids)
	{
		return call_user_func_array("{$this->modelClassName}::destroy", array($ids));
	}
}
