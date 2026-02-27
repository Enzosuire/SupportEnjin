{{-- il faut include dans le view conversations/view.blade.php le sélécteur projet  --}}

    <div class="container-fluid mt-4"> 
                                        <!-- $conversation->id  -->
        <form action="{{ route('conversationpro.update', $conversation) }}" method="POST" id="projectForm"> 
            {{ csrf_field() }}
            <div class="form-group">
                <label for="id_projet">Projet :</label>
                <select class="form-control" name="id_projet" id="projectSelector">
                    <option value="">Tous les projets</option>
                    @foreach ($projetsDuClient as $projet)
                        <option value="{{ $projet->id }}" {{ $conversation->id_projet == $projet->id ? 'selected' : '' }}>{{ $projet->nom }}</option>
                    @endforeach
                </select>
            </div>
            
        </form>
            @if ($conversation->projet)
                <h4>Projet actuel : {{ $conversation->projet->nom }}</h4>
            @endif
    </div>



