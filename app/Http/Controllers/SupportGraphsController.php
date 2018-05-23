<?php 

namespace App\Http\Controllers;

class SupportGraphsController extends Controller
{
    public function index () {

        return view('support.graphs.index');
    }
}