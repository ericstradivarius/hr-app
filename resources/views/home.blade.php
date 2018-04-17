@extends('layouts.app')

@section('content')

    <div class="fluid-container">

        <left-menu-directive></left-menu-directive>
        <header-directive></header-directive>
        <add-campaign-directive></add-campaign-directive>
        <add-candidate-directive></add-candidate-directive>
        <div ui-view="content"></div>

    </div>

@endsection
