<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreativesController extends Controller
{
	public function index ()
	{
		return view('frontend.creatives.index');
	}
}
