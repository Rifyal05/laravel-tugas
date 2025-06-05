<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http; 

class ApiController extends Controller
{
    public function getApiData()
    {
        try {
            $response = Http::get('https://wilayah.id/api/provinces.json');

            if ($response->successful()) {
                $data = $response->json(); 
                return view('api_view', ['data' => $data]); 
            } else {

                return 'Terjadi kesalahan saat mengambil data dari API.';
            }

        } catch (\Exception $e) {
            return 'Terjadi kesalahan: ' . $e->getMessage();
        }
    }
}