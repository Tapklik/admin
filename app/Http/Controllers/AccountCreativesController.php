<?php namespace App\Http\Controllers;


class AccountCreativesController extends Controller
{
    public function show($uuid, $creativeUuId)
    {
        return view('accounts.creatives.show', compact('creativeUuId'));
    }
}