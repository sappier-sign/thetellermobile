<?php
/**
 * Created by PhpStorm.
 * User: MEST
 * Date: 5/10/2017
 * Time: 1:03 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class Service extends Model
{
	protected $table 		= 'tlr_services';
	protected $primaryKey 	= 'serviceKey';
	public $incrementing 	= false;

	public function servicesProvider()
	{
		return $this->belongsToMany(ServiceProvider::class, 'tlr_services_providers', 'providerKey');
	}

	public function category()
	{
		
	}
}