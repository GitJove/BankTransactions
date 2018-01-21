<?php 

namespace App\Repositories\Eloquent;

/**
 * Simple Crud operations are more than enough in this case
 *
 * RepositoryInterface provides the standard functions to be expected of ANY 
 * repository.
 */
interface RepositoryInterface {
	
	public function create(array $attributes);

	public function all($columns = array('*'));

	public function find($id, $columns = array('*'));

	public function destroy($ids);

	// For far more complex structures I use: https://github.com/andersao/l5-repository
}