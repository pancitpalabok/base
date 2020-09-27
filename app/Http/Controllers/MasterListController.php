<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterListController extends Controller
{
    public function index()
    {
        return view("master.index");
    }
}
