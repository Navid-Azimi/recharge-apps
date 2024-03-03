<?php
namespace App\Http\Controllers\Traits;
use PragmaRX\Countries\Package\Services\Countries;

trait GetCountries
{
    protected function getCountries()
    {
        $countries = new Countries();
        return $countries->all();
    }
}
