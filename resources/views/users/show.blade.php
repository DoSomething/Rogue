@extends('layouts.master')

@section('main_content')
    @include('layouts.header', ['header' => 'User', 'subtitle' => ''])

    <div class="container -padded">
        <div id="app" class="wrapper">
            Loading...
        </div>
    </div>
@stop
