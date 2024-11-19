<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>CuisineFlow</title>


  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet">

  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <!-- nice select -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha256-mLBIhmBvigTFWPSCtvdu6a76T+3Xyt+K571hupeFLg4=" crossorigin="anonymous" />
  <!-- slidck slider -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha256-UK1EiopXIL+KVhfbFa8xrmAWPeBjMVdvYMYkTAEv/HI=" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css.map" integrity="undefined" crossorigin="anonymous" />


  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />

</head>

<body>

  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand" href="index.html">
            <span>
              CuisineFlow
            </span>
          </a>
          <div class="" id="">
            <div class="User_option">
              <a href="">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span>Login</span>
              </a>
              <form class="form-inline ">
                <input type="search" placeholder="Search" />
                <button class="btn  nav_search-btn" type="submit">
                  <i class="fa fa-search" aria-hidden="true"></i>
                </button>
              </form>
            </div>
            <div class="custom_menu-btn">
              <button onclick="openNav()">
                <img src="images/menu.png" alt="">
              </button>
            </div>
            <div id="myNav" class="overlay">
              <div class="overlay-content">
                <a href="index.html">Home</a>
                <a href="about.html">About</a>
                <a href="blog.html">Blog</a>
                <a href="testimonial.html">Testimonial</a>
              </div>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->

    <!-- slider section -->
    <section class="slider_section ">
  <div class="container ">
    <div class="row">
      <div class="col-lg-10 mx-auto">
        <div class="detail-box">
          <h1>Découvrez nos meilleures recettes</h1>
          <p>Venez découvrir une sélection de nos meilleures recettes maison, idéales pour régaler vos papilles !</p>
        </div>
        <div class="find_container ">
          <div class="container">
            <div class="row">
              <div class="col">
                <form>
                  <div class="form-row ">
                    <div class="form-group col-lg-4">
                      <select class="form-control" id="inputCategory">
                        <option value="">Toutes les catégories</option>
                        <option value="entrees">Entrées</option>
                        <option value="plats">Plats</option>
                        <option value="desserts">Desserts</option>
                        <option value="boissons">Boissons</option>
                      </select>
                    </div>
                    <!-- <div class="form-group col-lg-4">
                      <select class="form-control" id="inputCuisine">
                        <option value="">Tous les types de cuisine</option>
                        <option value="francaise">Française</option>
                        <option value="italienne">Italienne</option>
                        <option value="asiatique">Asiatique</option>
                        <option value="vegetarienne">Végétarienne</option>
                      </select>
                    </div> -->
                    <div class="form-group col-lg-3">
                      <div class="btn-box">
                        <button type="submit" class="btn ">Rechercher</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
      <div class="slider_container">
        <div class="item">
          <div class="img-box">
            <img src="images/slider-img1.png" alt="" />
          </div>
        </div>
        <div class="item">
          <div class="img-box">
            <img src="images/slider-img2.png" alt="" />
          </div>
        </div>
        <div class="item">
          <div class="img-box">
            <img src="images/slider-img3.png" alt="" />
          </div>
        </div>
        <div class="item">
          <div class="img-box">
            <img src="images/slider-img4.png" alt="" />
          </div>
        </div>
        <div class="item">
          <div class="img-box">
            <img src="images/slider-img1.png" alt="" />
          </div>
        </div>
        <div class="item">
          <div class="img-box">
            <img src="images/slider-img2.png" alt="" />
          </div>
        </div>
        <div class="item">
          <div class="img-box">
            <img src="images/slider-img3.png" alt="" />
          </div>
        </div>
        <div class="item">
          <div class="img-box">
            <img src="images/slider-img4.png" alt="" />
          </div>
        </div>
        
      </div>
    </section>
    <!-- end slider section -->
  </div>


  <!-- recipe section -->

  @include('layouts.recette')

  <!-- end recipe section -->
   

  <!-- app section -->

  <section class="app_section">
    <div class="container">
      <div class="col-md-9 mx-auto">
        <div class="row">
          <div class="col-md-7 col-lg-8">
            <div class="detail-box">
            <h2><span>
              Découvrez</span> notre<br>
              application de recettes
            </h2>
            <p>
              Avec notre application, accédez simplement et rapidement à des milliers de recettes savoureuses, partagées par notre communauté passionnée. Retrouvez vos favoris, découvrez de nouvelles inspirations et simplifiez votre organisation culinaire.
            </p>
              <div class="app_btn_box">
                <a href="" class="mr-1">
                  <img src="images/google_play.png" class="box-img" alt="">
                </a>
                <a href="">
                  <img src="images/app_store.png" class="box-img" alt="">
                </a>
              </div>
              <a href="" class="download_btn">
                Download Now
              </a>
            </div>
          </div>
          <div class="col-md-5 col-lg-4">
            <div class="img-box">
              <img src="images/mobile.png" class="box-img" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>


  <!-- end app section -->

  <!-- about section -->

  <section class="about_section layout_padding">
  <div class="container">
    <div class="col-md-11 col-lg-10 mx-auto">
      <div class="heading_container heading_center">
        <h2>Bienvenue dans notre famille de passionnés de cuisine</h2>
      </div>
      <div class="box">
        <div class="col-md-7 mx-auto">
          <div class="img-box">
            <img src="images/about-img.jpg" class="box-img" alt="Notre communauté en cuisine">
          </div>
        </div>
        <div class="detail-box">
          <p class="mb-4">
            Notre plateforme est née d'une passion commune : l'amour de la cuisine et du partage. Que vous soyez un chef amateur ou expérimenté, notre communauté est l'endroit idéal pour :
          </p>
          <ul class="list-unstyled mb-4">
            <li class="mb-2">
              <i class="fa fa-check text-primary mr-2"></i>
              Partager vos recettes favorites et découvrir celles des autres
            </li>
            <li class="mb-2">
              <i class="fa fa-check text-primary mr-2"></i>
              Échanger des astuces et conseils culinaires
            </li>
            <li class="mb-2">
              <i class="fa fa-check text-primary mr-2"></i>
              Apprendre de nouvelles techniques de cuisine
            </li>
            <li class="mb-2">
              <i class="fa fa-check text-primary mr-2"></i>
              Participer à des défis culinaires mensuels
            </li>
          </ul>
          <p class="mb-4">
            Avec déjà plus de 10 000 membres actifs et 5 000 recettes partagées, notre communauté grandit chaque jour. Rejoignez-nous pour faire partie de cette belle aventure culinaire !
          </p>
          <div class="d-flex justify-content-center mt-4">
            <a href="rejoindre-communaute" class="btn btn-primary w-auto px-5">
              Rejoindre la communauté
              <i class="fa fa-arrow-right ml-2" aria-hidden="true"></i>
            </a>
            <a href="recettes-populaires" class="btn btn-primary w-auto px-5">
              Découvrir les recettes
              <i class="fa fa-utensils ml-2" aria-hidden="true"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="row stats_container mt-5 text-center">
        <div class="col-md-3">
          <div class="stat-box">
            <i class="fa fa-users fa-2x mb-3" aria-hidden="true"></i>
            <h4>10 000+</h4>
            <p>Membres actifs</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat-box">
            <i class="fa fa-book-open fa-2x mb-3" aria-hidden="true"></i>
            <h4>5 000+</h4>
            <p>Recettes partagées</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat-box">
            <i class="fa fa-star fa-2x mb-3" aria-hidden="true"></i>
            <h4>4.8/5</h4>
            <p>Note moyenne</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stat-box">
            <i class="fa fa-comments fa-2x mb-3" aria-hidden="true"></i>
            <h4>15 000+</h4>
            <p>Commentaires</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

  <!-- end about section -->

  <!-- news section -->

  <section class="news_section">
  <div class="container">
    <div class="heading_container heading_center">
      <h2>Dernières actualités culinaires</h2>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="box">
          <div class="img-box">
            <img src="images/n1.jpg" class="box-img" alt="Recette de la semaine">
          </div>
          <div class="detail-box">
            <h4>Recette de la semaine</h4>
            <p>
              Découvrez notre recette coup de cœur de la semaine : un délicieux gâteau au chocolat sans gluten, partagé par Marie D. Cette recette a déjà conquis plus de 100 membres de notre communauté !
            </p>
         
            <a href="recette-semaine" class="btn btn-primary w-auto px-5">
              Voir la recette <i class="fa fa-arrow-right" aria-hidden="true"></i>
            </a>

          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box">
          <div class="img-box">
            <img src="images/n2.jpg" class="box-img" alt="Concours de cuisine">
          </div>
          <div class="detail-box">
            <h4>Concours du mois</h4>
            <p>
              Participez à notre concours mensuel sur le thème "Desserts d'été". Partagez vos meilleures recettes et tentez de gagner un robot pâtissier professionnel !
            </p>
            <a href="concours-cuisine" class="btn btn-primary w-auto px-5">
              Participer <i class="fa fa-arrow-right" aria-hidden="true"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Section Témoignages -->
<section class="client_section layout_padding">
  <div class="container">
    <div class="col-md-11 col-lg-10 mx-auto">
      <div class="heading_container heading_center">
        <h2>Avis de nos membres</h2>
      </div>
      <div id="customCarousel1" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="detail-box">
              <h4>Sophie Martin</h4>
              <p>
                "Grâce à cette communauté, j'ai énormément progressé en cuisine ! Les recettes sont bien détaillées et les conseils des autres membres sont précieux. J'adore particulièrement les vidéos explicatives qui accompagnent certaines recettes."
              </p>
              <i class="fa fa-quote-left" aria-hidden="true"></i>
            </div>
          </div>
          <div class="carousel-item">
            <div class="detail-box">
              <h4>Pierre Dubois</h4>
              <p>
                "Une superbe plateforme pour partager sa passion de la cuisine ! J'ai découvert de nombreuses recettes traditionnelles et les échanges avec les autres passionnés sont toujours enrichissants."
              </p>
              <i class="fa fa-quote-left" aria-hidden="true"></i>
            </div>
          </div>
          <div class="carousel-item">
            <div class="detail-box">
              <h4>Marie Lambert</h4>
              <p>
                "Je suis membre depuis 6 mois et j'ai déjà partagé une dizaine de recettes. Les retours constructifs de la communauté m'ont permis d'améliorer mes recettes. Un vrai plaisir de cuisiner ensemble !"
              </p>
              <i class="fa fa-quote-left" aria-hidden="true"></i>
            </div>
          </div>
        </div>
        <!-- Contrôles du carousel -->
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<div class="footer_container">
  <section class="info_section">
    <div class="container">
      <div class="contact_box">
        <a href="mailto:contact@recettes.com">
          <i class="fa fa-envelope" aria-hidden="true"></i>
        </a>
        <a href="https://www.instagram.com/recettes">
          <i class="fa fa-instagram" aria-hidden="true"></i>
        </a>
        <a href="https://pinterest.com/recettes">
          <i class="fa fa-pinterest" aria-hidden="true"></i>
        </a>
      </div>
      <div class="info_links">
        <ul>
          <li class="active">
            <a href="index.html">Accueil</a>
          </li>
          <li>
            <a href="recettes.html">Recettes</a>
          </li>
          <li>
            <a href="communaute.html">Communauté</a>
          </li>
          <li>
            <a href="astuces-cuisine.html">Astuces cuisine</a>
          </li>
          <li>
            <a href="contact.html">Contact</a>
          </li>
        </ul>
      </div>
      <div class="social_box">
        <a href="https://facebook.com/recettes">
          <i class="fa fa-facebook" aria-hidden="true"></i>
        </a>
        <a href="https://instagram.com/recettes">
          <i class="fa fa-instagram" aria-hidden="true"></i>
        </a>
        <a href="https://youtube.com/recettes">
          <i class="fa fa-youtube" aria-hidden="true"></i>
        </a>
      </div>
    </div>
  </section>

  <footer class="footer_section">
    <div class="container">
      <p>
        &copy; <span id="displayYear"></span> Tous droits réservés - Plateforme de partage de recettes
      </p>
    </div>
  </footer>
</div>
  <!-- jQery -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.js"></script>
  <!-- slick  slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js"></script>
  <!-- nice select -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js" integrity="sha256-Zr3vByTlMGQhvMfgkQ5BtWRSKBGa2QlspKYJnkjZTmo=" crossorigin="anonymous"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>


</body>

</html>