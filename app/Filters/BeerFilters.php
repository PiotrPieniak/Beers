<?php

namespace App\Filters;

use Illuminate\Http\Request;

class BeerFilters
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        if ($this->request->has('brewer_id')) {
            $builder->where('beers.brewer_id', $this->request->get('brewer_id'));
        }

        if ($this->request->has('name')) {
            $builder->where('beers.name', 'LIKE', '%'.$this->request->get('name').'%');
        }

        if ($this->request->has('country_code')) {
            $builder->join('countries', 'beers.country_id', '=', 'countries.id');
            $builder->where('countries.alpha2code', $this->request->get('country_code'));
        }

        if ($this->request->has('price_from')) {
            $builder->where('beers.price', '>=', $this->request->get('price_from'));
        }

        if ($this->request->has('price_to')) {
            $builder->where('beers.price', '<=', $this->request->get('price_to'));
        }

        if ($this->request->has('type')) {
            $builder->where('beers.type', $this->request->get('type'));
        }

        return $builder;
    }
}