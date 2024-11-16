@extends('layouts.entete')

@section('content')
<section class="login_section layout_padding">
  <div class="container">
    <div class="col-md-6 mx-auto">
      <div class="heading_container heading_center">
        <h2>Connexion</h2>
      </div>
      <div class="box">
        <form action="{{ route('login') }}" method="POST">
          @csrf
          <div class="form-group">
            <input type="email" name="mail" class="form-control" id="mail" placeholder="Votre email" value="{{ old('mail') }}" required>
            @error('mail')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <input type="password" name="password" class="form-control" id="password" placeholder="Votre mot de passe" required>
            @error('password')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group d-flex justify-content-between align-items-center">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="remember" name="remember">
              <label class="form-check-label" for="remember">Se souvenir de moi</label>
            </div>
            <a href="" class="text-primary">Mot de passe oublié ?</a>
          </div>
          <div class="btn-box">
            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
          </div>
          <div class="text-center mt-3">
            <p>Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a></p>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
