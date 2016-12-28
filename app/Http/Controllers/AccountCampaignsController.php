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
}
