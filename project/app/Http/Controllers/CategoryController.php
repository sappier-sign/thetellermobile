<?php
/**
 * Created by PhpStorm.
 * User: MEST
 * Date: 5/10/2017
 * Time: 2:49 PM
 */

namespace App\Http\Controllers;


use App\Category;

class CategoryController extends Controller
{
	public function index()
	{
		return Category::getCategories();
	}

	public function show( $id )
	{
		return Category::getCategories($id);
	}
}