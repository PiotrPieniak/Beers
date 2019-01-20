<?php

namespace App\Console\Commands;

use App\Models\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CountryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get countries';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $results = json_decode(file_get_contents('countries.json'));

            foreach ($results as $alpha => $name)
            {
                $country = new Country();

                $country->name = $name;
                $country->alpha2code = $alpha;
                $country->save();
            }

            $this->info('Countries table filled');
        } catch (\Exception $e) {
            $this->error('Cannot get countries database, check if you have countries.json in root directory');
        }
    }
}
