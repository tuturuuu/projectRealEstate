<!DOCTYPE html>
<html lang="en">

<?php
   include_once("./dao/propertyDao.php");
?>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>EstateAgency Bootstrap Template - Index</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Property Search Section ======= -->
  <div class="click-closed"></div>
  <!--/ Form Search Star /-->
  <div class="box-collapse">
    <div class="title-box-d">
      <h3 class="title-d">Search Property</h3>
    </div>
    <span class="close-box-collapse right-boxed bi bi-x"></span>
    <div class="box-collapse-wrap form">
      <form class="form-a">
        <div class="row">
          <div class="col-md-12 mb-2">
            <div class="form-group">
              <label class="pb-2" for="Type">Keyword</label>
              <input type="text" class="form-control form-control-lg form-control-a" placeholder="Keyword">
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group mt-3">
              <label class="pb-2" for="Type">Type</label>
              <select class="form-control form-select form-control-a" id="Type">
                <option>All Type</option>
                <option>For Rent</option>
                <option>For Sale</option>
                <option>Open House</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group mt-3">
              <label class="pb-2" for="city">City</label>
              <select class="form-control form-select form-control-a" id="city">
                <option>All City</option>
                <option>Alabama</option>
                <option>Arizona</option>
                <option>California</option>
                <option>Colorado</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group mt-3">
              <label class="pb-2" for="bedrooms">Bedrooms</label>
              <select class="form-control form-select form-control-a" id="bedrooms">
                <option>Any</option>
                <option>01</option>
                <option>02</option>
                <option>03</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group mt-3">
              <label class="pb-2" for="garages">Garages</label>
              <select class="form-control form-select form-control-a" id="garages">
                <option>Any</option>
                <option>01</option>
                <option>02</option>
                <option>03</option>
                <option>04</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group mt-3">
              <label class="pb-2" for="bathrooms">Bathrooms</label>
              <select class="form-control form-select form-control-a" id="bathrooms">
                <option>Any</option>
                <option>01</option>
                <option>02</option>
                <option>03</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group mt-3">
              <label class="pb-2" for="price">Min Price</label>
              <select class="form-control form-select form-control-a" id="price">
                <option>Unlimite</option>
                <option>$50,000</option>
                <option>$100,000</option>
                <option>$150,000</option>
                <option>$200,000</option>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <button type="submit" class="btn btn-b">Search Property</button>
          </div>
        </div>
      </form>
    </div>
  </div><!-- End Property Search Section -->>

  <?php
   include_once 'nav.inc';
  ?>


  <main id="main">

    <!-- ======= Intro Single ======= -->
    <section class="intro-single">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-lg-8">
            <div class="title-single-box">
              <h1 class="title-single">Our Amazing Properties</h1>
              <span class="color-text-a">Grid Properties</span>
            </div>
          </div>
          <div class="col-md-12 col-lg-4">
            <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  Properties Grid
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </section><!-- End Intro Single-->

    <!-- ======= Property Grid ======= -->
    <section class="property-grid grid">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="grid-option">
            <form action="property-grid.php" method="GET">
              <select class="custom-select" name="sort" onchange="this.form.submit()">
                  <option value="" selected>All</option>
                  <option value="new_to_old">New to Old</option>
                  <option value="pending">Pending</option>
                  <option value="active">Active</option>
                  <option value="sold">Sold</option>
              </select>
            </form>
            </div>
            
          </div>

          <?php
          $iteration = 1;

          if(isset($_GET["pagenum"])){
            $value = $_GET["pagenum"];
            if($value > 0){
              $pagenum = $value;
            } else {
              $pagenum = 1;
            }
          } else{
            $pagenum = 1;
          }
    
          $limit = 6; // You can change this limit as needed

          $sort = isset($_GET["sort"]) ? $_GET["sort"] : 'all';

          if(isset($_GET['sort'])){
            switch ($_GET['sort']){
              case "new_to_old":
                $properties = getPropertyByRecentOffset(($pagenum-1)*6, $limit);
                break;
              case "all":
                $properties = getPropertyByRecentOffset(($pagenum-1)*6, $limit);
                break;
              case "pending":
                $properties = getPropertyByRecentOffsetByStatus(($pagenum-1)*6, $limit, "pending");
                break;
              case "active":
                $properties = getPropertyByRecentOffsetByStatus(($pagenum-1)*6, $limit, "active");
                break;
              case "sold":
                $properties = getPropertyByRecentOffsetByStatus(($pagenum-1)*6, $limit, "sold");
                break;
              default: 
                $properties = getPropertyByRecentOffset(($pagenum-1)*6, $limit);
                break;
            }
          } else {
            $properties = getPropertyByRecentOffset(($pagenum-1)*6, 6);
          }

          if(count($properties) < 6){
            $end_of_db = true;
          } else {
            $end_of_db = false;
          }

          foreach ($properties as $property): ?>
            <div class="col-md-4">
              <div class="card-box-a card-shadow">
                <div class="img-box-a">
                  <img src=" ./assets/img/property-<?php echo "$iteration"; $iteration++; ?>.jpg" alt="" class="img-a img-fluid">
                </div>
                <div class="card-overlay">
                  <div class="card-overlay-a-content">
                    <div class="card-header-a">
                      <h2 class="card-title-a">
                        <a href="#"><?php echo $property['list_date']; ?> <?php echo $property['city']; ?>
                          <br /> <?php echo $property['property_type']; ?></a>
                      </h2>
                    </div>
                    <div class="card-body-a">
                      <div class="price-box d-flex">
                        <span class="price-a"><?php echo $property['status']; ?> | $ <?php echo $property['price']; ?></span>
                      </div>
                      <a href="property-single.php?property-id=<?php echo $property["property_id"]; ?>" class="link-a">Click here to view
                        <span class="bi bi-chevron-right"></span>
                      </a>
                    </div>
                    <div class="card-footer-a">
                      <ul class="card-info d-flex justify-content-around">
                      <li>
                          <h4 class="card-info-title">Area</h4>
                          <span><?php echo $property['square_footage']; ?>m
                            <sup>2</sup>
                          </span>
                        </li>

                        <li>
                          <h4 class="card-info-title">Beds</h4>
                          <span><?php echo $property['bedrooms']; ?>
                            beds
                          </span>
                        </li>

                        
                        <li>
                          <h4 class="card-info-title">Baths</h4>
                          <span><?php echo $property['bathrooms']; ?>
                            baths
                          </span>
                        </li>

                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>

        </div>  
      </div>

        <div class="row">
          <div class="col-sm-12">
            <nav class="pagination-a">
              <ul class="pagination justify-content-end">
                
                <?php if ($pagenum - 1 > 0): ?>
                  <a class="page-link" href="property-grid.php?pagenum=<?php echo $pagenum - 1; ?>&sort=<?php echo $sort; ?>">
                   <span class="bi bi-chevron-left"></span>
                  </a>
                  <li class="page-item">
                    <a class="page-link" href="property-grid.php?pagenum=<?php echo $pagenum - 1; ?>&sort=<?php echo $sort; ?>"><?php echo $pagenum - 1; ?></a>
                  </li>
                <?php endif; ?>
                <li class="page-item active">
                  <a class="page-link" href="property-grid.php?pagenum=<?php echo $pagenum; ?>&sort=<?php echo $sort; ?>"><?php echo $pagenum; ?></a>
                </li>

                <?php if (!$end_of_db): ?>
                  <li class="page-item">
                    <a class="page-link" href="property-grid.php?pagenum=<?php echo $pagenum + 1; ?>&sort=<?php echo $sort; ?>"><?php echo $pagenum + 1; ?></a>
                  </li>

                  <li class="page-item next">
                    <a class="page-link" href="property-grid.php?pagenum=<?php echo $pagenum + 1; ?>&sort=<?php echo $sort; ?>">
                      <span class="bi bi-chevron-right"></span>
                    </a>
                  </li>
                <?php endif; ?>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </section><!-- End Property Grid Single-->

  </main><!-- End #main -->


  <?php
   include_once 'footer.inc';
  ?>

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>