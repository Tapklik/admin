<?php 

namespace App\Http\Controllers;

class SupportController extends Controller
{
    public function index () {

        return view('support.index');
    }

    public function graphs() {

        return view('support.graphs');
    }
}