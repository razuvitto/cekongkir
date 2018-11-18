@extends('layout')
@section('judul')
Buat Tugas
@endsection
@section('konten')
<form action="{{ url('tugas') }}" method="post">
	{{ csrf_field() }}
	<label>Judul</label> <input type="text" name="judul" class="form-control">
	<label>Deskripsi</label>
	<input type="text" name="deskripsi" class="form-control">
	<input type="submit" class="btn btn-success" value="Simpan">
</form>
 
@endsection