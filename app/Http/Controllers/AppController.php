<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Segment;

class AppController extends Controller
{
    function all_segment() {
        return Segment::all();
    }
}
