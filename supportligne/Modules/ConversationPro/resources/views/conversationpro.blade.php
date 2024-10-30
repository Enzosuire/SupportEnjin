{{-- il faut include dans le view conversations/view.blade.php le sélécteur projet  --}}
{{-- @include('conversationpro::conversationpro') --}}

    <div class="container-fluid mt-4"> 
        <form action="{{ route('conversationpro.update', $conversation->id) }}" method="POST" id="projectForm">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="id_projet">Projet :</label>
                <select class="form-control " name="id_projet" id="projectSelector" onchange="document.getElementById('projectForm').submit();">
                    <option value="">Tous les projets</option>
                    @foreach ($projetsDuClient as $projet)
                        <option value="{{ $projet->id }}" {{ $conversation->projet_id == $projet->id ? 'selected' : '' }}>{{ $projet->nom }}</option>
                    @endforeach
                </select>
            </div>
        </form>
        @if ($conversation->projet)
            <h4>Projet actuel : {{ $conversation->projet->nom }}</h4>
        @endif
    </div>


