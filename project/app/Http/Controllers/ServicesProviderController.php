<?php


namespace App\Http\Controllers;

use App\ServicesProvider;

class ServicesProviderController extends Controller
{
	public function index()
	{
		return ServicesProvider::getServices();
	}

	public function show( $id )
	{
		return ServicesProvider::getServices($id);
	}
}