<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountCampaignsController extends Controller
{
	public function index ($id)
	{
		$account   = ['id' => $id];
		$campaigns = [];
		return view('accounts.campaigns.index', compact('campaigns', 'account'));
	}

	public function show ($id, $cid) {

		return view('accounts.campaigns.show', compact('cid'));
	}
	public function display ($id, $cid) {

		return view('accounts.campaigns.display', compact('cid'));
	}
}
