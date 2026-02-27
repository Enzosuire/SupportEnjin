@extends('enduserportal::layouts.portal')

@section('title', __('My Tickets'))

@section('content')

    <div id="eup-container">

        <div class="eup-container-padded">
            <div class="heading margin-bottom text-center">{{ __('My Tickets') }}</div>

            <!-- Formulaire de filtre par statut -->
            <form id="filter-form" method="GET" action="{{ route('enduserportal.tickets', ['mailbox_id' => \EndUserPortal::encodeMailboxId($mailbox->id)]) }}" class="margin-bottom">
                <div class="form-group champ-list">
                    <label for="status">{{ __('Filtre Statut') }}</label>
                    <select name="status" id="status" class="form-control status ">
                        <option value="">{{ __('All') }}</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>{{ __('Nouveau') }}</option>
                        <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>{{ __('Ouvert') }}</option>
                        <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>{{ __('Closed') }}</option>
                    </select>
                </div>
            </form>

            @if (count($tickets))
                <a href="{{ route('enduserportal.submit', ['id' => \EndUserPortal::encodeMailboxId($mailbox->id)]) }}" class="btn btn-primary margin-bottom eup-btn-create">{{ \EndUserPortal::getMailboxParam($mailbox, 'text_submit') }}</a>
            @endif
        </div>

        {{-- Modification de la vue des tickets pour inclure le filtre --}}
        @include('enduserportal::partials/tickets_table', ['conversations' => $tickets])

    </div>

@endsection

@section('eup_javascript')
submitFilterOnStatusChange();
@endsection