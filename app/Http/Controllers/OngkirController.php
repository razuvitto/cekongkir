<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OngkirController extends Controller
{
    public function index(){
        $data = RajaOngkir::Cost([
            'origin' 		=> 501, // id kota asal
            'destination' 	=> 114, // id kota tujuan
            'weight' 		=> 1700, // berat satuan gram
            'courier' 		=> 'jne', // kode kurir pengantar ( jne / tiki / pos )
        ])->get();
        var_dump($data);
    }
}
