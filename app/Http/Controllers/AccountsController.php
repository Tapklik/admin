<?php namespace App\Http\Controllers;

use App\Account;

class AccountsController extends Controller
{
	public function index ()
	{
		
	}

	public function show ($id)
	{

		
	}

	public function noroute() {

		return view('frontend.accounts.noroute');
	}
}
