@extends('layouts.app')

@section('title', 'Teacher Dashboard')

@section('content')
<main class="">
    Hello, {{ Auth::user()->name }}
</main>
@endsection