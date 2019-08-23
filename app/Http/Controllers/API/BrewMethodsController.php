<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use APP\Models\BrewMethod;


class BrewMethodsController extends Controller
{
    //

    /**
     * Get all brew methods and numbers of cafes have that brew methods
     * 
     */
    public function getBrewMethods()
    {
        $brewMethods = BrewMethod::withCount('cafes')->get();
        return response()->json($brewMethods);
    }
}
