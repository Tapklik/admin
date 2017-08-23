<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampaignsController extends Controller
{
	public function index ()
	{
		$campaigns = [];

		return view('campaigns.index', compact('campaigns'));
	}

	public function show ($id)
	{
		return view('campaigns.show', compact('id'));
	}

	public function create () {

		return view('campaigns.create');
	}
}
