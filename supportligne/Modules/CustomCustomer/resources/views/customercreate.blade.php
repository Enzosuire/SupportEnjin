@extends('layouts.app')

@section('title', __('Créer un clients'))


@section('content')
    <div class="container-fluid">

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif


        <form action="{{ route('customers.store') }}" method="post" class="form-creation">
            {{ csrf_field() }}

            <h2>Création d'un client</h2>
            <hr class="soustitres">


            <div class="form-line-2">
                <div class="form-group form-line-item-1 champ-input-txt">
                    <label for="first_name">Prénom :</label>
                    <input type="text" name="first_name" class="form-control" required>
                </div>
            </div>
            <div class="form-line-3">
                <div class="form-group form-line-item-2 champ-input-txt">
                    <label for="last_name">Nom :</label>
                    <input type="text" name="last_name" class="form-control" required>
                </div>
            </div>

            <div class="form-line-4">
                <div class="form-group form-line-item-2 champ-input-txt">
                    <label for="company">Entreprise :</label>
                    <input type="text" name="company" class="form-control" required>
                </div>
            </div>

            <div class="form-line-5">
                <div class="form-group form-line-item-2 champ-input-txt">
                    <label for="numero_siret">N° Siret :</label>
                    <input type="number" name="numero_siret" class="form-control" required>
                </div>
            </div>

            <div class="form-line-6">
                <div class="line-button d-flex justify-content-start">
                    <button type="submit" class="btn btn-primary">Créer</button>
                </div>
            </div>


        </form>
    </div>
@endsection


@section('javascript')
@endsection
