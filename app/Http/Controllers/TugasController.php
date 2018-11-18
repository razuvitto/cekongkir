<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http;

use App\Tugas;

class TugasController extends Controller
{
    public function index(){
    	//select * from tugas
    	$data = Tugas::all();
    	return view('tugas.daftar_tugas')->with('data', $data);
    }

    public function create(){
    	return view('tugas.buat_tugas');
    }

    public function store(Request $request){
    	//insert into tugas(...) value(...)
    	Tugas::create($request->all());
    	return redirect('tugas');
    }

    public function show($id){
    	//select * from tugas where id = $id
    	$data = Tugas::find($id);
    	return view('tugas.detail_tugas')->with('data', $data);
    }

    public function edit($id){
    	$data = Tugas::find($id);
    	return view('tugas.edit_tugas')->with('data', $data);
    }

    public function update(Request $request, $id){
    	//update tugas set ... = .... where id = $id
    	Tugas::find($id)->update($request->all());
    	return redirect('tugas');
    }

    public function destroy($id){
    	Tugas::find($id)->delete();
    	return redirect('tugas');
    }
}
