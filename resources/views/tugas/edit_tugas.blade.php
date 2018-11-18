@extends('layout')
@section('judul')
Edit Tugas
@endsection
@section('konten')
<form action="{{ url('tugas/'.$data->id) }}" method="post">
	<input type="hidden" name="_method" value="PUT">
	{{ csrf_field() }}
	<label>Judul</label>
	<input type="text" name="judul" value="{{$data->judul}}" class="form-control">
	<label>Deskripsi</label>
	<input type="text" name="deskripsi" value="{{$data->deskripsi}}" class="form-control">
	<input type="submit" class="btn btn-success" value="Simpan">
</form>
 
@endsection