@extends('layouts.entete')

@section('content')
<section class="register_section layout_padding">
  <div class="container">
    <div class="col-md-8 mx-auto">
      <div class="heading_container heading_center">
        <h2>Créer un compte</h2>
      </div>
      <div class="box">
        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <input type="text" name="prenom" class="form-control" placeholder="Prénom" value="{{ old('prenom') }}" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <input type="text" name="nom" class="form-control" placeholder="Nom" value="{{ old('nom') }}" required>
              </div>
            </div>
          </div>

          <div class="form-group">
            <input type="email" name="mail" class="form-control" placeholder="Email" value="{{ old('mail') }}" required>
          </div>

          <div class="form-group">
            <input type="text" name="adresse" class="form-control" placeholder="Adresse" value="{{ old('adresse') }}" required>
          </div>
          <div class="form-group">
            <input type="text" name="nomUtilisateur" class="form-control" placeholder="Nom d'utilisateur" value="{{ old('nomUtilisateur') }}" required>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <input type="date" name="dateNaiss" class="form-control" placeholder="Date de naissance" value="{{ old('dateNaiss') }}" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <input type="text" name="lieuNaiss" class="form-control" placeholder="Lieu de naissance" value="{{ old('lieuNaiss') }}" required>
              </div>
            </div>
          </div>

          <div class="form-group">
            <input type="text" name="phone" class="form-control" placeholder="Téléphone" value="{{ old('phone') }}" required>
          </div>

          <div class="form-group">
            <input type="file" name="photo" class="form-control" placeholder="Photo" accept="image/*">
          </div>

          <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
          </div>

          <div class="form-group">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmer le mot de passe" required>
          </div>

          <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
            <label class="form-check-label" for="terms">J'accepte les conditions d'utilisation</label>
          </div>

          <div class="btn-box">
            <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
          </div>

          <div class="text-center mt-3">
            <p>Déjà membre ? <a href="{{ route('login') }}">Se connecter</a></p>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
