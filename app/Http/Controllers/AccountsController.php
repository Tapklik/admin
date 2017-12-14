<?php namespace App\Http\Controllers;

use App\Account;

class AccountsController extends Controller
{
	public function index ()
	{
		$accounts = [];
		return view('accounts.index', compact('accounts'));
	}

	public function show ($id)
	{	
		return view('accounts.show', compact('id'));
		
	}

	public function noroute() {
		return view('accounts.noroute');
	}
}
