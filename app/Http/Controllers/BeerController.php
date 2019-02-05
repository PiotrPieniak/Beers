<?php

namespace App\Http\Controllers;

use App\Filters\BeerFilters;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Beer;
use App\Http\Resources\Beer as BeerResource;
use App\Http\Resources\Country as CountryResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BeerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param BeerFilters $filters
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request, BeerFilters $filters)
    {
        if(!empty($request->getQueryString())) {

            $validator = Validator::make($request->all(), [
                'brewer_id' => 'int|nullable',
                'name' => 'string|max:100|nullable',
                'type' => 'string|max:100|nullable',
                'country' => 'string|max:100|nullable',
                'price_from' => 'numeric|nullable',
                'price_to' => 'numeric|nullable',
            ]);

            if ($validator->fails()) {
                return new JsonResponse(['errors' => $validator->errors()]);
            }
        }

        $beers = $filters->apply(Beer::query())->get();

        return BeerResource::collection($beers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return BeerResource
     */
    public function show($id)
    {
        $beer = Beer::findOrFail($id);

        return new BeerResource($beer);
    }

    public function types()
    {
        $types = DB::table('Beers')
            ->select('type')
            ->distinct()
            ->get();

        return new JsonResponse($types);
    }

    public function countries()
    {
        $countries = DB::table('Countries')
            ->orderByRaw('name ASC')
            ->get();

        return CountryResource::collection($countries);
    }
}
