<!DOCTYPE html>
<html>
<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>CuisineFlow</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet">
  
  <!-- Nice Select -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css">
  
  <!-- Slick Slider -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css">
  
  <!-- Custom styles -->
  <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/responsive.css') }}" rel="stylesheet" />
  
  <!-- Stack styles -->
  @stack('styles')
</head>

<body>
  @yield('content')

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <!-- Bootstrap Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Axios -->
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  
  <!-- Slick Slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
  
  <!-- Nice Select -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
  
  <!-- Custom Scripts -->
  <script src="{{ asset('js/custom.js') }}"></script>

  <!-- Setup Axios CSRF -->
  <script>
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
    
    // Définition des fonctions globales
    window.aimer = function(recetteId) {
      axios.post(`/recettes/${recetteId}/aimer`)
        .then(response => {
          const button = document.querySelector(`button[onclick="aimer(${recetteId})"]`);
          const icon = button.querySelector('i');
          const countSpan = document.getElementById(`likes-count-${recetteId}`);
          
          if (response.data.liked) {
            button.classList.remove('btn-outline-primary');
            button.classList.add('btn-primary');
            icon.classList.remove('far');
            icon.classList.add('fas');
          } else {
            button.classList.remove('btn-primary');
            button.classList.add('btn-outline-primary');
            icon.classList.remove('fas');
            icon.classList.add('far');
          }
          
          countSpan.textContent = response.data.count;
        })
        .catch(error => {
          if (error.response?.status === 401) {
            window.location.href = '{{ route("login") }}';
          } else {
            console.error('Erreur:', error);
            alert('Une erreur est survenue. Veuillez réessayer.');
          }
        });
    };

    window.ajouterFavori = function(recetteId) {
      axios.post(`/recettes/${recetteId}/favori`)
        .then(response => {
          const button = document.querySelector(`button[onclick="ajouterFavori(${recetteId})"]`);
          const icon = button.querySelector('i');
          const countSpan = document.getElementById(`favoris-count-${recetteId}`);
          
          if (response.data.favorited) {
            button.classList.remove('btn-outline-warning');
            button.classList.add('btn-warning');
            icon.classList.remove('far');
            icon.classList.add('fas');
          } else {
            button.classList.remove('btn-warning');
            button.classList.add('btn-outline-warning');
            icon.classList.remove('fas');
            icon.classList.add('far');
          }
          
          countSpan.textContent = response.data.count;
        })
        .catch(error => {
          if (error.response?.status === 401) {
            window.location.href = '{{ route("login") }}';
          } else {
            console.error('Erreur:', error);
            alert('Une erreur est survenue. Veuillez réessayer.');
          }
        });
    };
  </script>

  <!-- Stack scripts -->
  @stack('scripts')
</body>
</html>