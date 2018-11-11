@extends('layouts.app')

@section('content')

<div id="map" class="fullSize"></div>

<div class="search-toggle"></div>
<div class="search-panel">
    <form method="POST" action="">
        @csrf
    <div class="search-panel-header first-header">Origin</div>
    <div class="search-panel-content">
        <div class="form-group row">
            <label for="from_country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>
            <div class="col-md-6">
                <select id="from_country" name="from_country" class="select">
                @include('select.country')
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="from_city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>
            <div class="col-md-6">
                <select id="from_city" name="from_city" class="select disabled"></select>
            </div>
        </div>
        <div class="form-group row">
            <label for="from_broadcaster" class="col-md-4 col-form-label text-md-right">{{ __('Broadcaster') }}</label>
            <div class="col-md-6">
                <select id="from_broadcaster" name="from_broadcaster" class="select"></select>
            </div>
        </div>
    </div>
    <div class="search-panel-header">Destination</div>
    <div class="search-panel-content">
        <div class="form-group row">
            <label for="to_country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>
            <div class="col-md-6">
                <select id="to_country" name="to_country" class="select">
                @include('select.country')
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="to_city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>
            <div class="col-md-6">
                <select id="to_city" name="to_city" class="select"></select>
            </div>
        </div>
        <div class="form-group row">
            <label for="to_broadcaster" class="col-md-4 col-form-label text-md-right">{{ __('Broadcaster') }}</label>
            <div class="col-md-6">
                <select id="to_broadcaster" name="to_broadcaster" class="select"></select>
            </div>
        </div>
    </div>
    <div class="search-panel-header">Layer</div>
    <div class="search-panel-content">
        <div class="form-group row">
            <div class="col-md-6 offset-md-4">
                <input type="checkbox" name="layer_fiber" id="layer_fiber" checked> Fiber</br></br>
                <input type="checkbox" name="layer_satellite" id="layer_satellite" checked> Satellite</br></br>
                <input type="checkbox" name="layer_cloud" id="layer_cloud" checked> Cloud
            </div>
        </div>
    </div>
    </form>
</div>
@endsection

