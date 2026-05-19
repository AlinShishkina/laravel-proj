<?php

namespace App\Http\Controllers;

use App\Models\ApiRecord;

class ApiRecordsController extends Controller
{
    public function index()
    {
        $records = ApiRecord::orderBy('created_at', 'desc')->get();
        return response()->json($records);
    }
}