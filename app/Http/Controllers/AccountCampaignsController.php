<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountCampaignsController extends Controller
{
	public function index ($id)
	{
		$account   = ['id' => $id];
		$campaigns = [];
		return view('frontend.accounts.campaigns.index', compact('campaigns', 'account'));
	}

	public function show ($id, $cid) {

		return view('frontend.accounts.campaigns.show', compact('cid'));
	}
}
