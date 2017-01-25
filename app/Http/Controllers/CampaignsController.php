<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampaignsController extends Controller
{
	public function index ()
	{
		$campaigns = [];

		return view('frontend.campaigns.index', compact('campaigns'));
	}

	public function show ($id)
	{
		return view('frontend.campaigns.show', compact('id'));
	}
}
