<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportRequest;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function import(ImportRequest $request) {
        dd($request);
    }
}
