<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Jekyll v4.0.1">
        <title>Mascotas Perdidas Py · Dashboard</title>

        <!-- <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/"> -->

        <!-- Bootstrap core CSS -->
        <link href="<?=base_url('/assets/dist/css/bootstrap.css');?>" rel="stylesheet">
        <link href="<?=base_url('/assets/fontawesome-free-5.14/css/all.css');?>" rel="stylesheet">
        <style>
          .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
          }

          @media (min-width: 768px) {
            .bd-placeholder-img-lg {
              font-size: 3.5rem;
            }
          }
        </style>
        <!-- Custom styles for this template -->
        <link href="<?=base_url('/assets/dashboard.css');?>" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="<?=base_url();?>">
                Mascotas Perdidas Py
            </a>
            
            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <input class="form-control form-control-dark w-100" type="text" placeholder="Buscar" aria-label="Buscar">

            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a class="nav-link" href="<?=base_url('cerrar_sesion');?>">Cerrar Sesion</a>
                </li>
            </ul>
        </nav>

        <div class="container-fluid">
            <div class="row">
                
                <?= view('dashboard_navbarmenu'); ?>

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <?= $this->renderSection('content') ?>

                    </div>
                </main>
            </div>
        </div>
        

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script>
        <script src="<?=base_url('assets/dist/js/bootstrap.bundle.js');?>"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script> -->
        <!-- <script src="<?=base_url('/assets/dashboard.js');?>"></script> -->
    </body>
</html>