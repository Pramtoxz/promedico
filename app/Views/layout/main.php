
<!doctype html>

<html
  lang="en"
  class="layout-menu-fixed layout-compact"
  data-assets-path="<?php base_url() ?>/assets/"
  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />

    <title>Demo: Dashboard - Analytics | Materio - Bootstrap Dashboard FREE</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php base_url() ?>/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="<?php base_url() ?>/assets/vendor/fonts/iconify-icons.css" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css -->

    <link rel="stylesheet" href="<?php base_url() ?>/assets/vendor/libs/node-waves/node-waves.css" />

    <link rel="stylesheet" href="<?php base_url() ?>/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="<?php base_url() ?>/assets/css/demo.css" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="<?php base_url() ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- endbuild -->

    <link rel="stylesheet" href="<?php base_url() ?>/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="<?php base_url() ?>/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

    <script src="<?php base_url() ?>/assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
        <?= $this->include('layout/sidebar') ?>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          <?= $this->include('layout/navbar') ?>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
        </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <?= $this->include('layout/footer') ?>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <div class="buy-now">
      <a
        href="https://themeselection.com/item/materio-dashboard-pro-bootstrap/"
        target="_blank"
        class="btn btn-danger btn-buy-now"
        >SULEEEE</a
      >
    </div>

    <!-- Core JS -->

    <script src="<?php base_url() ?>/assets/vendor/libs/jquery/jquery.js"></script>

    <script src="<?php base_url() ?>/assets/vendor/libs/popper/popper.js"></script>
    <script src="<?php base_url() ?>/assets/vendor/js/bootstrap.js"></script>
    <script src="<?php base_url() ?>/assets/vendor/libs/node-waves/node-waves.js"></script>

    <script src="<?php base_url() ?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="<?php base_url() ?>/assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="<?php base_url() ?>/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->

    <script src="<?php base_url() ?>/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="<?php base_url() ?>/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async="async" defer="defer" src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
