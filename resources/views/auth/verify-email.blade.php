@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5 text-center">
                    <h2 class="mb-3">Vérification de votre compte</h2>
                    <p class="text-muted mb-4">
                        Un lien de validation a été envoyé à votre adresse e-mail. Veuillez vérifier votre boîte de réception et cliquer sur le bouton pour activer votre compte.
                    </p>

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success" role="alert">
                            Un nouveau lien de validation a été envoyé.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Renvoyer le lien de validation</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
