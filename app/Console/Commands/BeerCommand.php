<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Beer;
use App\Models\Brewer;
use App\Models\Country;
use App\Services\BeerApi;
use App\Services\PriceCounter;

class BeerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:beers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get beers and brewers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(BeerApi $beerApi, PriceCounter $priceCounter)
    {
        try {
            $results = $beerApi->getBeers();

            foreach ($results as $result) {
                $brewer = Brewer::where('name', $result['brewer'])->get()->first();

                if (!$brewer) {
                    $brewer = new Brewer();
                    $brewer->name =  $result['brewer'];
                    $brewer->save();
                }

                $beer = new Beer();
                $beer->name = $result['name'];
                $beer->size = $result['size'];
                $beer->price = $result['price'];
                $beer->country_id = Country::where('name', $result['country'])->first()->id;
                $beer->image_url = $result['image_url'];
                $beer->type = $result['type'];
                $beer->brewer_id = $brewer->id;
                $beer->price_per_litre = $priceCounter->getPrice($result['price'], $result['size']);

                $beer->save();
            }
        } catch (\Exception $e) {
            $this->error('Cannot download beers database');
            return $e->getMessage();
        }

        $this->info('Brewers and beers table filled');
    }
}
