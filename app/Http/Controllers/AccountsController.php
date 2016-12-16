<?php

namespace App\Http\Controllers;

use App\Account;

class AccountsController extends Controller
{
	public function index ()
	{
		$accounts = [];
		return view('frontend.accounts.index', compact('accounts'));
	}

	public function show ($id)
	{
		$accounts = Account::all();

		return response([]);
	}

	public function noroute() {

		return view('frontend.accounts.noroute');
	}
}
