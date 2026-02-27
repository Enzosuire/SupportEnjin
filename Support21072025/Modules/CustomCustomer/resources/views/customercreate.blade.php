@extends('layouts.app')

@section('title', __('Créer un clients'))


@section('content')
    <div class="container-fluid">

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->has('email'))
            <div class="alert alert-danger">
                {{ $errors->first('email') }}
            </div>
        @endif



        <form action="{{ route('customers.store') }}" method="post" class="form-creation">
            {{ csrf_field() }}

            <h2>Création d'un client</h2>
            <hr class="soustitres">

            <!-- Première ligne : Prénom et Nom -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group champ-input-txt ">
                        <label for="first_name">Prénom :</label>
                        <input type="text" name="first_name" class="form-control" placeholder="Ex : Julien">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group champ-input-txt">
                        <label for="last_name">Nom :</label>
                        <input type="text" name="last_name" class="form-control" placeholder="Ex : Dechamps">
                    </div>
                </div>
            </div>

            <!-- Deuxième ligne : Entreprise et N° Siret -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group champ-input-txt">
                        <label for="company">Entreprise :</label>
                        <input type="text" name="company" class="form-control" placeholder="Ex : Kaptitude" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group champ-input-txt">
                        <label for="numero_siret">N° Siren :</label>
                        <input type="number" name="numero_siret" class="form-control" placeholder="Ex : 301639290">
                    </div>
                </div>
            </div>

            <!-- Troisième ligne : Téléphone et Site Web -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group champ-input-txt">
                        <label for="phones">Téléphone :</label>
                        <input type="text" name="phones" class="form-control" placeholder="Ex : 06875435*5" >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group champ-input-txt">
                        <label for="websites">Site Web :</label>
                        <input type="url" name="websites[]" placeholder="Ex : https://www.enjin.fr " class="form-control">
                    </div>
                </div>
            </div>

           
            <!-- Quatrième ligne : Email -->
            <div class="row">
                <div class="col-md-12">
                    <div class="multi-container form-group champ-input-txt">
                        @php
                            $emails = old('emails', []); // Récupère les emails soumis en cas d'erreur, sinon un tableau vide
                        @endphp

                        @if (empty($emails))
                            <!-- Affichage d'un champ vide si aucun email n'existe -->
                            <div class="multi-item">
                                <label for="emails" class="col-sm-2 control-label">Email :</label>
                                <div>
                                    <input type="email" class="form-control input-sized-lg" name="emails[]" maxlength="191" placeholder="exemple@domain.com">
                                    <a href="#" class="multi-remove" tabindex="-1"><i class="glyphicon glyphicon-remove"></i></a>
                                </div>
                            </div>
                        @else
                            <!-- Pré-remplir avec les anciens emails -->
                            @foreach ($emails as $i => $email)
                                <div class="multi-item {{ $errors->has('emails.' . $i) ? ' has-error' : '' }}">
                                    <div>
                                        <input type="email" class="form-control input-sized-lg" name="emails[]" value="{{ $email }}" maxlength="191">
                                        <a href="#" class="multi-remove" tabindex="-1"><i class="glyphicon glyphicon-remove"></i></a>
                                    </div>
                                    @include('partials/field_error', ['field' => 'emails.' . $i])
                                </div>
                            @endforeach
                        @endif

                        <p class="block-help"><a href="#" class="multi-add" tabindex="-1">{{ __('Add an email address') }}</a></p>
                    </div>
                </div>
            </div>


            <!-- Bouton de soumission -->
            <div class="line-button">
                <button type="submit" class="btn btn-primary">Créer</button>
            </div>

            
        </form>

    </div>
@endsection


@section('javascript')
multiInputInit();
@endsection
