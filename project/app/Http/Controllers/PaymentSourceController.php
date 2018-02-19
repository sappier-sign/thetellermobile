<?php
/**
 * Created by PhpStorm.
 * User: MEST
 * Date: 5/10/2017
 * Time: 10:57 AM
 */

namespace App\Http\Controllers;


use App\PaymentSource;

class PaymentSourceController
{
	public function show()
	{
		return PaymentSource::all();
	}
}