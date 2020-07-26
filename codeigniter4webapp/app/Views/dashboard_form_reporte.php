<?php $this->extend('dashboard_layout');
echo $this->section('content') ?>
<script type="text/javascript">
    var HOSTNAME = '<?=base_url();?>';
    var HOSTNAME_API = HOSTNAME + '/api/';

    // Map.
    var DEFAULT_ZOOM_MAP = 6;
    var DEFAULT_ZOOM_MARKER = 16;
    var DEFAULT_MIN_ZOOM_MAP = 6;
    var DEFAULT_MAX_ZOOM_MAP = 20;

    // Villa Hayes - Paraguay.
    var DEFAULT_LNG = -57.623807;
    var DEFAULT_LAT = -23.299114;
</script>
<link rel="stylesheet" href="<?=base_url('assets/leaflet/leaflet.css');?>" />
<script src="<?=base_url('assets/leaflet/leaflet.js');?>"></script>
<style type="text/css">
    
.form-signin {
  width: 100%;
  max-width: 680px;
  padding: 15px;
  /*margin: auto;*/
}

.form-label-group {
  position: relative;
  margin-bottom: 1rem;
}

.form-label-group > input,
.form-label-group > label {
  height: 3.125rem;
  padding: .75rem;
}

.form-label-group > label {
  position: absolute;
  top: 0;
  left: 0;
  display: block;
  width: 100%;
  margin-bottom: 0; /* Override default `<label>` margin */
  line-height: 1.5;
  color: #495057;
  pointer-events: none;
  cursor: text; /* Match the input under the label */
  border: 1px solid transparent;
  border-radius: .25rem;
  transition: all .1s ease-in-out;
}

.form-label-group input::-webkit-input-placeholder {
  color: transparent;
}

.form-label-group input:-ms-input-placeholder {
  color: transparent;
}

.form-label-group input::-ms-input-placeholder {
  color: transparent;
}

.form-label-group input::-moz-placeholder {
  color: transparent;
}

.form-label-group input::placeholder {
  color: transparent;
}

.form-label-group input:not(:placeholder-shown) {
  padding-top: 1.25rem;
  padding-bottom: .25rem;
}

.form-label-group input:not(:placeholder-shown) ~ label {
  padding-top: .25rem;
  padding-bottom: .25rem;
  font-size: 12px;
  color: #777;
}

/* Fallback for Edge
-------------------------------------------------- */
@supports (-ms-ime-align: auto) {
  .form-label-group > label {
    display: none;
  }
  .form-label-group input::-ms-input-placeholder {
    color: #777;
  }
}

/* Fallback for IE
-------------------------------------------------- */
@media all and (-ms-high-contrast: none), (-ms-high-contrast: active) {
  .form-label-group > label {
    display: none;
  }
  .form-label-group input:-ms-input-placeholder {
    color: #777;
  }
}

#map-container { height: 400px; width: 100%; }
</style>
<script src="<?=base_url('assets/Utilities.js');?>" type="text/javascript"></script>
<script src="<?=base_url('assets/Map.js');?>" type="text/javascript" charset="utf-8"></script>
<script  id="loadMap" data_load_map=marker src="<?=base_url('assets/onLoadScripts.js');?>" type="text/javascript" charset="utf-8"></script>

<h1 class="h2">Dashboard - Nuevo reporte</h1>
</div>
<div class="row">
<!-- <div class="container"> -->
    <!-- <div class="row"> -->
        <form id="demo-form" method="POST" class="form-signin needs-validation accordion" action="<?=base_url('cuenta/reporte/nuevo');?>" >
        <?= csrf_field() ?>
        <?php if($session->getFlashdata('error')){
            ?>
            <div class="alert-warning"><?= $session->getFlashdata('error'); ?></div>

            <?php
        } ?>

        <?php 
            if(isset($success)){
                if($success){
                    ?>
                    <div class="alert-info">
                        Se ha guardado correctamente su reporte!
                    </div>
                    <?php
                }else{
                    ?>
                    <div class="alert-warning">
                        Se ha producido un error al guardar sus datos.
                        Favor escribanos un email a <?=env('email_soporte');?> con los datos que ha cargado en el formulario.
                    </div><?php
                }
            }
        ?>

        <div class="col-md-11 mb-3">
             <label for="tipo_reporte">Tipo de reporte</label>
            <select name="tipo_reporte" id="tipo_reporte" class="custom-select d-block w-100">
                <option value="Perdido">Mascota Perdida</option>
                <option value="Encontrado">Mascota Encontrada</option>
            </select>
            <!-- <input name="usuario_nombre" type="text" id="nombre" class="form-control" placeholder="Nombre Completo" required autofocus> -->
            
            <?php 
                if (isset($validation) && $validation->hasError('usuario_nombre'))
                {
                    echo '<div class="alert-danger">'.$validation->getError('usuario_nombre').'</div>';
                }
            ?>
        </div>

        <div class="col-md-11 mb-3">
            <label for="reporte_mascota_nombre">Nombre de la mascota</label>
            <input name="reporte_mascota_nombre" type="text" id="reporte_mascota_nombre" class="form-control" placeholder="Si es un rescate puede dejar en blanco" required autofocus>
            
            <?php 
                if (isset($validation) && $validation->hasError('reporte_mascota_nombre'))
                {
                    echo '<div class="alert-danger">'.$validation->getError('reporte_mascota_nombre').'</div>';
                }
            ?>
        </div>
        <div class="col-md-11 mb-3">
            <label for="reporte_descripcion">Descripci&oacute;n</label>
            <textarea id="reporte_descripcion" class="form-control" required></textarea>
            <?php 
                if (isset($validation) && $validation->hasError('reporte_descripcion'))
                {
                    echo '<div class="alert-danger">'.$validation->getError('reporte_descripcion').'</div>';
                }
            ?>
        </div>
        <div>
            <label for="mascota_nombre">Ubicaci&oacute;n</label>
            <button type="button" class="btn btn-dark btn-lg btn-block" onclick="send_marker()">Marcar posici&oacute;n en el mapa</button>
            
                <input class="form-control" type="hidden" name="latitud" id="latitud" value="" placeholder="click en el mapa"/>
                <input class="form-control" type="hidden" name="longitud" id="longitud" value="" placeholder="click en el mapa"/>
            

            
            <div id="map-container"></div>
        </div>
        <div class="col-md-11 mb-3">
            <label for="reporte_direccion">Direcci&oacute;n</label>
            <input name="reporte_direccion" type="text" id="reporte_direccion" class="form-control" placeholder="Si lo desea puede escribir una direccion precisa aqui" required autofocus>
            
            <?php 
                if (isset($validation) && $validation->hasError('reporte_direccion'))
                {
                    echo '<div class="alert-danger">'.$validation->getError('reporte_direccion').'</div>';
                }
            ?>
        </div>
    </form>
    <!-- </div> -->
<!-- </div> -->
<script type="text/javascript">
//     var map = L.map('mapid').setView([51.505, -0.09], 13);
//     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//     attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
// }).addTo(map);
function send_marker ()
        {
            marker_point_map(event, ((gps_active)? DEFAULT_ZOOM_MARKER : DEFAULT_ZOOM_MAP))
        }
</script>
<?php echo $this->endSection() ?>