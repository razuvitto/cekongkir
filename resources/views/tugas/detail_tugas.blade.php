@extends('layout')
@section('judul')
Detail Tugas
@endsection
@section('konten')
<table class="table table-hover">
	<thread>
		<tr>
			<th>Judul</th>
			<th>Deskripsi</th>
			<th>Dibuat Pada</th>
		<tr>
	</thread>
	<tbody>
		<tr>
			<td>{{$data->judul}}</td>
			<td>{{$data->deskripsi}}</td>
			<td>{{$data->created_at}}</td>
		</tr>
	</tbody>
</table>
@endsection