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
        <form id="form-reporte" method="POST" enctype="multipart/form-data" class="form-signin needs-validation accordion" action="<?=base_url('cuenta/reportes/nuevo');?>" >
        <?= csrf_field() ?>
        <?php if($session->getFlashdata('error')){
            ?>
            <div class="alert alert-warning"><?= $session->getFlashdata('error'); ?></div>

            <?php
        } ?>

        <?php 
            if(isset($success)){
                if($success){
                    ?>
                    <div class="alert alert-info">
                        Se ha guardado correctamente su reporte!
                    </div>
                    <?php
                }else{
                    ?>
                    <div class="alert alert-warning">
                        Se ha producido un error al guardar sus datos.
                        Favor escribanos un email a <?=env('email_soporte');?> con los datos que ha cargado en el formulario.
                    </div><?php
                }
            }
        ?>

        <div class="col-md-11 mb-3">
             <label for="tipo_reporte"><strong>Tipo de reporte*</strong></label>
            <select name="tipo_reporte" id="tipo_reporte" class="custom-select d-block w-100">
                <option value="Perdido">Mascota Perdida</option>
                <option value="Encontrado">Mascota Encontrada</option>
            </select>
            
            
            <?php 
                if (isset($validation) && $validation->hasError('tipo_reporte'))
                {
                    echo '<div class="alert-danger">'.$validation->getError('tipo_reporte').'</div>';
                }
            ?>
        </div>
        <div class="col-md-11 mb-3">
             <label for="tipo_reporte"><strong>Tipo de animal*</strong></label>
             
            <select name="id_tipo_animal" id="id_tipo_animal" class="custom-select d-block w-100">
                <?php 
                    foreach($tipos_animales as $tipo_animal){
                        echo "<option value=\"$tipo_animal->id_tipo_animal\">$tipo_animal->tipo_animal_descripcion</option>";
                    }
                ?>
            </select>
            <!-- <input name="usuario_nombre" type="text" id="nombre" class="form-control" placeholder="Nombre Completo" required autofocus> -->
            
            <?php 
                if (isset($validation) && $validation->hasError('id_tipo_animal'))
                {
                    echo '<div class="alert alert-danger">'.$validation->getError('id_tipo_animal').'</div>';
                }
            ?>
        </div>

        <div class="col-md-11 mb-3">
            <label for="reporte_fecha"><strong>Fecha en la que se extravi&oacute;/Encontr&oacute; al animal*</strong></label><br/>
            <input type="text" style="border:1px solid #ced4da;padding: 6px 12px; border-radius: 0.25rem;" name="reporte_fecha" id="reporte_fecha">
        </div>


        <div class="col-md-11 mb-3">
            <label for="reporte_mascota_nombre"><strong>Nombre de la mascota</strong></label>
            <input name="reporte_mascota_nombre" type="text" id="reporte_mascota_nombre" class="form-control" placeholder="Si es un rescate puede dejar en blanco" required autofocus>
            
            <?php 
                if (isset($validation) && $validation->hasError('reporte_mascota_nombre'))
                {
                    echo '<div class="alert alert-danger">'.$validation->getError('reporte_mascota_nombre').'</div>';
                }
            ?>
        </div>
        <div class="col-md-11 mb-3">
            <label for="reporte_descripcion"><strong>Descripci&oacute;n*</strong></label>
            <textarea placeholder="Describa datos del animal, caracteristicas únicas, donde se perdió/encontró" name="reporte_descripcion" id="reporte_descripcion" class="form-control" required></textarea>
            <?php 
                if (isset($validation) && $validation->hasError('reporte_descripcion'))
                {
                    echo '<div class="alert alert-danger">'.$validation->getError('reporte_descripcion').'</div>';
                }
            ?>
        </div>
        <div>
            <label for=""><strong>Ubicaci&oacute;n*</strong></label>
            <button type="button" class="btn btn-dark btn-lg btn-block" onclick="send_marker()">Marcar posici&oacute;n en el mapa</button>
            
                <input class="form-control" type="hidden" name="latitud" id="latitud" value="" placeholder="click en el mapa"/>
                <input class="form-control" type="hidden" name="longitud" id="longitud" value="" placeholder="click en el mapa"/>
            

            
            <div id="map-container"></div>
        </div>
        <div class="col-md-11 mb-3">
            <label for="reporte_direccion">Direcci&oacute;n</label>
            <input name="reporte_direccion" type="text" id="reporte_direccion" class="form-control" placeholder="Si lo desea puede escribir aquí calle y número, sino deje en blanco" required autofocus>
            
            <?php 
                if (isset($validation) && $validation->hasError('reporte_direccion'))
                {
                    echo '<div class="alert alert-danger">'.$validation->getError('reporte_direccion').'</div>';
                }
            ?>
        </div>
        <div class="col-md-11 mb-3">
            <label>Hasta 3 Im&aacute;genes</label> <br/>
            <input class="form-control-file" type="file" name="imagenes[]" multiple="multiple" /> 
        </div>
        <div>
            <div class="alert alert-warning d-none" id="errores"></div>
            <button type="button" class="btn btn-primary btn-lg btn-block" onclick="validarYGuardar();">Guardar</button>
        </div>
    </form>
    <!-- </div> -->
<!-- </div> -->
<script type="text/javascript">
//     var map = L.map('mapid').setView([51.505, -0.09], 13);
//     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//     attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
// }).addTo(map);
function send_marker (){
    marker_point_map(event, ((gps_active)? DEFAULT_ZOOM_MARKER : DEFAULT_ZOOM_MAP))
}

function validarYGuardar(){
    var esValido = true;
    var tipo_reporte = $('#tipo_reporte').val();
    var tipo_animal = $('#id_tipo_animal').val();
    var reporte_mascota_nombre = $('#reporte_mascota_nombre').val();
    var reporte_descripcion = $('#reporte_descripcion').val();
    var latitud = $('#latitud').val();
    var longitud = $('#longitud').val();

    var reporte_fecha = $('#reporte_fecha').val();

    var errores = []
    if(tipo_reporte==null || tipo_reporte ==""){
        esValido = false;
        errores.push('<li>Debe elegir un tipo de reporte</li>');
    }

    if(tipo_animal==null || tipo_animal ==""){
        esValido = false;
        errores.push('<li>Debe elegir un tipo de animal</li>');
    }

    if(reporte_descripcion==null || reporte_descripcion ==""){
        esValido = false;
        errores.push('<li>Debe cargar una descripción</li>');
    }

    if(reporte_fecha==null || reporte_fecha ==""){
        esValido = false;
        errores.push('<li>Debe cargar la fecha en la que se encontró/perdió el animal</li>');
    }

    if(latitud==null || latitud == "" || longitud == null || longitud == ""){
        esValido = false;
        errores.push("<li>Debe elegir un punto en el mapa</li>");
    }

    var $fileUpload = $("input[type='file']");
    if (parseInt($fileUpload.get(0).files.length)>3){
        esValido = false;
        errores.push("<li>3 Imágenes es el límite de imágenes a subir</li>");
    }

    if(!esValido){
        $('#errores').html('<ul>'+(errores.join(' '))+'</ul>');
        $('#errores').removeClass('d-none');
    }else{
        $('#errores').addClass('d-none');
        $('#form-reporte').submit();
    }


}
$( document ).ready(function() {
    $('#reporte_fecha').Zebra_DatePicker({
        months:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
        format:'Y-m-d',
        first_day_of_week:0,
        default_position:'below',
        days: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
    });
});
</script>
<?php echo $this->endSection() ?>