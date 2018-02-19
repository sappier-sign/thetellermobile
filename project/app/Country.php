<?php
/**
 * Created by PhpStorm.
 * User: MEST
 * Date: 5/2/2017
 * Time: 5:34 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
	protected $table = 'tlr_country';
	protected $primaryKey = 'countryID';
}