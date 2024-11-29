@extends('layouts.entete')

@section('styles')
<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 20px;
        margin-bottom: 20px;
    }

    .form-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    .success-message {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
        margin-bottom: 5px;
    }

    .error-message {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
    }

    .profile-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 10px;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: 500;
        text-align: center;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        margin-top: 10px;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .divider {
        border-top: 1px solid #ddd;
        margin: 30px 0;
    }

    .password-section {
        margin-top: 30px;
    }

    .password-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="card">
        <h2 class="form-title">Modifier mon profil</h2>

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulaire de modification du profil -->
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Photo de profil -->
            <div class="form-group">
                <label class="form-label">Photo de profil</label>
                @if($user->photo)
                    <div>
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo de profil" class="profile-image">
                    </div>
                @endif
                <input type="file" name="photo" accept="image/*" class="form-control">
                @error('photo')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Nom -->
            <div class="form-group">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" id="nom" value="{{ old('nom', $user->nom) }}" class="form-control">
                @error('nom')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Prénom -->
            <div class="form-group">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $user->prenom) }}" class="form-control">
                @error('prenom')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Nom d'utilisateur -->
            <div class="form-group">
                <label for="nomUtilisateur" class="form-label">Nom d'utilisateur</label>
                <input type="text" name="nomUtilisateur" id="nomUtilisateur" value="{{ old('nomUtilisateur', $user->visiteur->nomUtilisateur) }}" class="form-control">
                @error('nomUtilisateur')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="mail" class="form-label">Adresse email</label>
                <input type="email" name="mail" id="mail" value="{{ old('mail', $user->mail) }}" class="form-control">
                @error('mail')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Téléphone -->
            <div class="form-group">
                <label for="phone" class="form-label">Téléphone</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
                @error('phone')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Adresse -->
            <div class="form-group">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" name="adresse" id="adresse" value="{{ old('adresse', $user->adresse) }}" class="form-control">
                @error('adresse')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

    <!-- Date de naissance -->
                <div class="form-group">
                    <label for="dateNaiss" class="form-label">Date de naissance</label>
                    <input type="date" 
                    name="dateNaiss" 
                    id="dateNaiss" 
                    value="{{ old('dateNaiss', \Carbon\Carbon::parse($user->dateNaiss)->format('Y-m-d')) }}" 
                    class="form-control"> 
                    @error('dateNaiss')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

            <!-- Lieu de naissance -->
            <div class="form-group">
                <label for="lieuNaiss" class="form-label">Lieu de naissance</label>
                <input type="text" name="lieuNaiss" id="lieuNaiss" value="{{ old('lieuNaiss', $user->lieuNaiss) }}" class="form-control">
                @error('lieuNaiss')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-auto px-5">Mettre à jour le profil</button>
        </form>

        <!-- Formulaire de modification du mot de passe -->
        <div class="password-section">
            <div class="divider"></div>
            <h3 class="password-title">Changer le mot de passe</h3>
            
            <form action="{{ route('profile.password') }}" method="POST">
                @csrf

                <!-- Mot de passe actuel -->
                <div class="form-group">
                    <label for="current_password" class="form-label">Mot de passe actuel</label>
                    <input type="password" name="current_password" id="current_password" class="form-control">
                    @error('current_password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Nouveau mot de passe -->
                <div class="form-group">
                    <label for="password" class="form-label">Nouveau mot de passe</label>
                    <input type="password" name="password" id="password" class="form-control">
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirmation du nouveau mot de passe -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary w-auto px-5">Changer le mot de passe</button>
            </form>
        </div>
    </div>
</div>
@endsection