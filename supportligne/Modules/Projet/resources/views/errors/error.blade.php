@extends('layouts.app')

@section('title', 'Error')

@section('content')
    <div class="container text-center">
        <div class="alert alert-danger ">
            <strong>Erreur!</strong> Une erreur s'est produite lors de la création.
        </div>
        <p>Veuillez contacter l'administrateur du système pour obtenir de l'aide.</p>
        <br/><br/><h2>{{ __('Go to') }} <a href="{{ \Helper::urlHome() }}">{{ __('Homepage') }}</a></h2>
    </div>
@endsection
