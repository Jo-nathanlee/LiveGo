<?php

namespace App\Http\Controllers;

use App\Entities\Page;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntitiesController extends Controller
{
    public function CreateOrUpdatePage(Request $request)
    {
        $page_id_name = $request->input('id');
        $id_and_name = preg_split("/[,]+/", $page_id_name);
        $page_id = $id_and_name[0];
        $page_name = $id_and_name[1];
        $page = Page::updateOrCreate(
            ['fb_id' => Auth::user()->fb_id],
            [
                'name' => Auth::user()->name,
                'page_id' => $page_id,
                'page_name' => $page_name,
            ]
        );
        return redirect('/home');
    }
}
