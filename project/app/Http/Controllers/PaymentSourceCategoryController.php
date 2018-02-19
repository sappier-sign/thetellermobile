<?php
/**
 * Created by PhpStorm.
 * User: MEST
 * Date: 5/10/2017
 * Time: 10:41 AM
 */

namespace App\Http\Controllers;


use App\PaymentSourceCategory;

class PaymentSourceCategoryController extends Controller
{
	public function index()
	{
		return PaymentSourceCategory::getPaymentSource();
	}

	public function show( $id )
	{
		return PaymentSourceCategory::getPaymentSource($id);
	}

}