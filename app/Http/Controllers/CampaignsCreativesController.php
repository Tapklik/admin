<?php namespace App\Http\Controllers;

class CampaignsCreativesController extends Controller
{
    public function show($id) {
    	$creatives = ['id' => $id];

    	return view('campaigns.creatives.index', compact('creatives'));
    }
}
