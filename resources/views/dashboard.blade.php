@extends('layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-4 border p-4 rounded">
            <h1 class="h3 mb-3 fw-normal text-center">Halaman Dashboard {{ $user->name }}</h1>

            <div class="d-flex justify-content-between">
                <div class="w-50">
                    <p class="fw-bold">Nama Lengkap</p>
                    <p class="fw-bold">Email</p>
                    <p class="fw-bold">Jenis Kelamin</p>
                    <p class="fw-bold">Umur</p>
                    <p class="fw-bold">Tanggal Lahir</p>
                    <p class="fw-bold">Alamat</p>
                </div>
                <div class="w-50">
                    <p>: {{ $user->nama }}</p>
                    <p>: {{ $user->email }}</p>
                    <p>: {{ $user->gender }}</p>
                    <p>: {{ $user->umur }}</p>
                    <p>: {{ $user->tgl_lahir }}</p>
                    <p>: {{ $user->alamat }}</p>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('logout') }}" class="w-100 btn btn-lg btn-danger">Logout</a>
            </div>
        </div>
    </div>
@endsection
