<?php
namespace App\Http\Controllers;

use App\Models\Brewer;
use App\Http\Resources\Brewer as BrewerResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BrewerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $brewers = Brewer::paginate(20);
        
        return BrewerResource::collection($brewers);
    }
}