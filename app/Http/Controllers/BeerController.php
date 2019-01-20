<?php

namespace App\Http\Controllers;

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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = DB::table('Beers')
            ->select(
                'beers.id',
                'beers.name',
                'beers.size',
                'beers.image_url',
                'beers.brewer_id',
                'beers.price',
                'beers.type',
                'beers.price_per_litre',
                'beers.country_id'
            );

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

            if(!is_null($request->get('brewer_id'))) {
                $query->where('beers.brewer_id', $request->get('brewer_id'));
            }

            if(!is_null($request->get('name'))) {
                $query->where('beers.name', 'LIKE', '%'.$request->get('name').'%');
            }

            if(!is_null($request->get('country_code'))) {
                $query->join('countries', 'beers.country_id', '=', 'countries.id');
                $query->where('countries.alpha2code', $request->get('country_code'));
            }

            if(!is_null($request->get('price_from'))) {
                $query->where('beers.price', '>=', $request->get('price_from'));
            }

            if(!is_null($request->get('price_to'))) {
                $query->where('beers.price', '<=', $request->get('price_to'));
            }

            if(!is_null($request->get('type'))) {
                $query->where('beers.type', $request->get('type'));
            }
        }

        $beers = $query
            ->paginate(20);

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
