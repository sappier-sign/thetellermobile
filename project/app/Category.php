<?php
/**
 * Created by PhpStorm.
 * User: MEST
 * Date: 5/10/2017
 * Time: 2:45 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table	= 'tlr_categories';
	protected $primaryKey	= 'categoryKey';
	public $incrementing	= false;

	public function services()
	{
		return $this->hasMany(Service::class, 'categoryKey');
	}

	public static function getCategories($id = null)
	{
		return (is_null($id))? Category::all() : Category::where('categoryKey', $id)->with('services')->first();
	}

}