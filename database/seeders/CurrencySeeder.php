<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('currencies')->truncate();
        Schema::enableForeignKeyConstraints();

        $csvToArray = csvToArray('resources\\views\\frontend\\seeders\\currencies.csv');
        if (isset($csvToArray[0])) {
            $currencies = [];
            $now = Carbon::parse(now())->format('Y-m-d H:i:s');
            foreach ($csvToArray as $currency) {
                $currency['id'] = (!isset($currency['id']) ? reset($currency) : $currency['id']);
                if (
                    !arrayValueExists($currency, 'id')
                    || !arrayValueExists($currency, 'name')
                ) {
                    continue;
                }
                $currencies[] = [
                    'id' => $currency['id'],
                    'name' => $currency['name'] ,
                    'short_name' => $currency['short_name'],
                    'symbol' => $currency['symbol'],
                    'created_at' => arrayValueExists($currency, 'created_at') ? dbDate($currency['created_at']) : $now,
                    'updated_at' => arrayValueExists($currency, 'updated_at') ? dbDate($currency['updated_at']) : $now,

                ];
            }
            foreach (array_chunk($currencies, 500) as $currenciesChunk) {
                Currency::insert($currenciesChunk);
            }
        }
    }
}
