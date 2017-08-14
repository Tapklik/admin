<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreativesController extends Controller
{
	public function index ()
	{
		return view('frontend.creatives.index');
	}

	public function show ($id)
    {
        return view('frontend.creatives.show', compact('id'));
    }

	public function create ($id)
    {

        return view('frontend.creatives.upload', compact('id'));
    }

    public function upload (Request $request, $id) {

	    $file = $request->file('creative');
        $tempFile = $file->move(public_path('/temp'), sha1(time()) . '.' . $file->getClientOriginalExtension());

	    $request = $this->http->request('POST', $this->API . 'creatives', [
            'multipart' => [
                [
                    'name'     => 'creative',
                    'contents' => file_get_contents(public_path('temp/') . $tempFile->getFilename()),
                    'filename' => $tempFile
                ],
                [
                    'name' => 'campaign',
                    'contents' => $id
                ]
            ]
        ]);



    }
}
