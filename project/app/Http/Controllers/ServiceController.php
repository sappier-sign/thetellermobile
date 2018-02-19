<?php
/**
 * Created by PhpStorm.
 * User: MEST
 * Date: 5/10/2017
 * Time: 1:01 PM
 */

namespace App\Http\Controllers;


use App\Service;

class ServiceController extends Controller
{
	public function index()
	{
		return Service::where('serviceStatus', 1)->get();
	}
}