@extends('layouts.app')

@section('title', __('Créer un projet'))

@section('content')
    <div class="container-fluid">

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('projet.store') }}" method="post" class="form-creation">
            {{ csrf_field() }}

            <h2>Création du projet</h2>
            <hr class="soustitres">

            {{-- Sélecteur Type de projet en premier --}}
            <div class="form-line-1">
                <div class="form-group form-line-item champ-list">
                    <label for="type_projet">Type de projet :</label>
                    <select name="type_projet" id="type_projet" class="form-control" required onchange="toggleFields()">
                        <option value="">Choisir le type de projet</option>
                        <option value="web">Web</option>
                        <option value="print">Print</option>
                    </select>
                </div>
            </div>

            {{-- Sélecteur d'entreprises --}}
            <div class="form-line-1">
                <div class="form-group form-line-item champ-list">
                    <label for="company">Entreprise :</label>
                    <select name="company" id="company" class="form-control" required>
                        <option value="">Choisir une entreprise</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->company }}">
                                {{ $customer->company }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-line-1">
                {{-- sélecteur client --}}
                <div class="form-group form-line-item champ-list">
                    <label for="customers">Clients :</label>
                    <select class="form-control" id="customers">
                        <option value="">Sélectionnez un client</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" class="option-value">
                                {{ $customer->company }} ({{ $customer->first_name }} {{ $customer->last_name }})
                            </option>
                        @endforeach
                    </select>
                    <div id="selected-customers" class="mt-2"></div>
                    <div id="hidden-inputs-container"></div>
                </div>
            </div>

            <div class="form-line-2">
                <div class="form-group form-line-item-1 champ-input-txt">
                    <label for="nom">Nom du Projet:</label>
                    <input type="text" name="nom" class="form-control" placeholder="Ex : Enjin" required>
                </div>
                
                <div class="form-group form-line-item-2 champ-input-txt web-only">
                    <label for="date_sortie_site">Date sortie site :</label>
                    <input type="date" name="date_sortie_site" class="form-control">
                </div>
            </div>

            <div class="form-line-3 web-only">
                <div class="form-group form-line-item-1 champ-input-txt">
                    <label for="maintenance_preventive">Maintenance Préventive:</label><br>

                    <div class="radio-center">
                        <input type="radio" id="maintenance_oui" name="maintenance_preventive" value="oui" required>
                        <label for="maintenance_oui">Oui</label>
                        
                        <input type="radio" id="maintenance_non" name="maintenance_preventive" value="non">
                        <label for="maintenance_non">Non</label>
                    </div>
                </div>

                <div class="form-group form-line-item-2 champ-input-txt">
                    <label for="duree_garantie">Durée de Garantie (mois):</label>
                    <input type="number" name="duree_garantie" class="form-control" placeholder="Ex : 12 ">
                </div>
            </div>

            <!-- Champ Créasite -->
            <div class="form-line-4 web-only">
                <div class="form-group form-line-item-1 champ-input-txt">
                    <label for="creasite">Créasite :</label><br>

                    <div class="radio-center">
                        <input type="radio" id="creasite_oui" name="creasite" value="oui" required>
                        <label for="creasite_oui">Oui</label>

                        <input type="radio" id="creasite_non" name="creasite" value="non">
                        <label for="creasite_non">Non</label>
                    </div>
                </div>
            </div>

            {{-- Sélecteurs de référents pour chaque pôle --}}
            <div class="form-line-4 web-only">
                <div class="form-group form-line-item champ-list">
                    <label for="referent_web">Référent Web :</label>
                    <select name="referent_web" id="referent_web" class="form-control">
                        <option value="">Choisir un référent pour le pôle Web</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->first_name }} {{ $user->last_name }}
                            </option>
                        @endforeach
                    </select>

                </div>

                <div class="form-group form-line-item champ-list">
                    <label for="referent_seo">Référent SEO :</label>
                    <select name="referent_seo" id="referent_seo" class="form-control">
                        <option value="">Choisir un référent pour le pôle SEO</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->first_name }} {{ $user->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group form-line-item champ-list">
                    <label for="referent_commercial">Référent Commercial :</label>
                    <select name="referent_commercial" id="referent_commercial" class="form-control">
                        <option value="">Choisir un référent pour le pôle Commercial</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->first_name }} {{ $user->last_name }}
                            </option>
                        @endforeach
                    </select>
                    
                </div>

        
            </div>

            <div class="line-button">
                <button type="submit" class="btn btn-primary">Créer le projet</button>
            </div>

        </form>
    </div>

       
@endsection

@section('javascript')
initializeCustomerSelect();
filterCustomerscompany();
toggleFields();
@endsection