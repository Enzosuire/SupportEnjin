@extends('emails/user/layouts/system')

@section('content')
<!-- max-width: 900px; margin: 0 auto; -->
<div style="text-align: left; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333333; line-height: 1.6; background-color: #24578E;">

    <!-- En-tête avec bannière bleue -->
    <div style="background-color: #24578E; padding: 30px 20px; text-align: center;">
        <h1 style="color: #ffffff; font-size: 24px; margin: 0;">
            {{ __("Authentication to :portal_name", ['portal_name' => $portal_name]) }}
        </h1>
    </div>
    <div style="background-color: #ffffff; padding: 30px; border-radius: 0 0 8px 8px;">
        <!-- Introduction -->
        <div style="background-color: #f8f9fa; padding: 20px; border-radius: 6px; margin-bottom: 30px; border-left: 4px solid #24578E;">
            <h3 style="color: #24578E; font-size: 18px; margin: 0 0 15px 0;">
                Accédez directement à l'outil de ticketing en cliquant sur le bouton ci-dessous :
            </h3>
            <div style="text-align: center; margin: 20px 10px;">
                <a href="{{ $auth_link }}" style="background-color: #24578E; color: #ffffff; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-weight: bold; display: inline-block;" target="_blank">
                    {{ __('Log In') }}
                </a>
            </div>
        </div>

        <!-- Signature -->
        <div style="text-align: center; margin-bottom: 30px; padding: 20px; background-color: #f8f9fa; border-radius: 6px;">
            <p style="margin: 0 0 10px 0;">
                À bientôt,<br>
                <strong style="color: #24578E;">L'équipe Enjin</strong>
            </p>
        </div>

        <!-- Footer -->
        <div style="text-align: center; border-top: 1px solid #e9ecef; padding-top: 20px; color: #6c757d; font-size: 14px;">
            <p style="margin: 0 0 10px 0;">
                Enjin<br>
                24 Bd Pierre Lecoq, 49300 Cholet
            </p>

            <p style="margin: 0; font-size: 12px;">
                {{ __("If the 'Log In' button does not work, open the following URL in your browser:") }}<br>
                <small>{{ $auth_link }}</small>
            </p>
        </div>
    </div>
</div>
@endsection



@section('footer')
	&copy; {{ date('Y') }} {{ $portal_name }}
@endsection



