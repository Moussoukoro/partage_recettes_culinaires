@extends('layouts.entete')

@section('content')
<section class="contact_section layout_padding">
  <div class="container">
    <div class="heading_container heading_center">
      <h2>Contactez-nous</h2>
    </div>
    <div class="row">
      <div class="col-md-8 mx-auto">
        <div class="box">
          <form action="#">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Nom complet">
            </div>
            <div class="form-group">
              <input type="email" class="form-control" placeholder="Email">
            </div>
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Sujet">
            </div>
            <div class="form-group">
              <textarea class="form-control" rows="5" placeholder="Message"></textarea>
            </div>
            <div class="btn-box">
              <button type="submit" class="btn btn-primary">Envoyer</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-md-4">
        <div class="contact_box text-center">
          <i class="fa fa-map-marker fa-2x mb-3"></i>
          <h4>Adresse</h4>
          <p>123 Rue de la Cuisine, 75001 Paris</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="contact_box text-center">
          <i class="fa fa-phone fa-2x mb-3"></i>
          <h4>Téléphone</h4>
          <p>+33 1 23 45 67 89</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="contact_box text-center">
          <i class="fa fa-envelope fa-2x mb-3"></i>
          <h4>Email</h4>
          <p>contact@recettes.com</p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection