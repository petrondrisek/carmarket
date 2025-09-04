<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Requests\CarFilterRequest;

class SearchMapController extends Controller
{
    /** Render Inertia Search page with SearchMap view. */
    public function index(CarFilterRequest $request) : Response
    {
        return Inertia::render('SearchMap', ['queryParams' => $request->all()]);
    }
}
