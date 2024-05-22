<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\User;

class UserController extends Controller
{
    public function getUsersByCountry($countryName)
    {
        $country = Country::where('name', $countryName)->first();

        if (!$country) {
            return response()->json(['message' => 'Country not found'], 404);
        }

        $users = User::whereHas('companies', function($query) use ($country) {
            $query->where('country_id', $country->id);
        })->with(['companies' => function($query) {
            $query->select('companies.id', 'companies.name');
        }])->get();

        return response()->json($users);
    }
}
