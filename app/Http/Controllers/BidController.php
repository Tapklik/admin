<?php 

namespace App\Http\Controllers;

class BidController extends Controller
{
    public function index ($id) {

        return view('bid.index', compact('id'));
    }
}
