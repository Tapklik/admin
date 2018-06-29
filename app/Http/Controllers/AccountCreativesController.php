<?php namespace App\Http\Controllers;


class AccountCreativesController extends Controller
{
    public function index($uuid, $creativeUuId)
    {
        return view('accounts.creatives.index', compact('creativeUuId'));
    }
    public function show($uuid, $creativeUuId)
    {
        return view('accounts.creatives.show', compact('creativeUuId'));
    }
}