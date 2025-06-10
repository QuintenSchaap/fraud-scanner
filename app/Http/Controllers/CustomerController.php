<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class CustomerController extends Controller
{
    public function index()
    {
        try {
            $response = Http::get('http://localhost:8080/api/v1/customers');

            if ($response->successful()) {
                $data = $response->json();
                $customers = $data['customers'] ?? [];
                return view('customers.index', compact('customers'));
            } else {
                return response()->json(['error' => 'API returned error'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not connect to API: '.$e->getMessage()], 500);
        }
    }
}
