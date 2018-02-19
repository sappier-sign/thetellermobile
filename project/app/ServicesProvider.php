<?php
/**
 * Created by PhpStorm.
 * User: MEST
 * Date: 5/10/2017
 * Time: 1:06 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class ServicesProvider extends Model
{
	protected $table		= 'tlr_services_providers';
	protected $primaryKey	= 'providerKey';
	public $incrementing	= false;

	public function services()
	{
		return $this->hasMany(Service::class, 'providerKey');
	}

	public static function getServices( $id = null )
	{
		return (is_null($id))? ServicesProvider::with('services')->get() : ServicesProvider::where('providerKey', $id)->with('services')->get();
	}
}
