<?php $this->extend('default_layout');

echo $this->section('content') ?>
    <?php if(isset($mensaje)){
        if(isset($error)){
           echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
        }else{
            echo "<div class='alert alert-info' alert-dismissible fade show' role='alert'>";
        }
        echo $mensaje;
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        echo "</div>";
    }?>
    <div class="jumbotron">
        <div class="container">
            <h1 class="display-2">Mascotas Perdidas Py</h1>
            <p>Hola, soy Pablo Ruiz Diaz, creador del sitio, te preguntarás que es este sitio y para que sirve?
        Bueno, la respuesta es sencilla, mi idea es que la gente pueda reportar en esta página cuando pierdan a sus mascotas, de manera a centralizar un poco más los esfuerzos de búsqueda, 
        y también que la gente que los encuentra  puedan anunciarlos aquí, de esa manera quienes rescataron y quienes perdieron puedan coincidir con más facilidad.</p>
            <p>¿Cómo funciona esto?</p>
            <p>Pues no es muy complicado, lo primero que hay que hacer es que te registres con una dirección de correo electrónico válido, y nos dejes un número telefónico donde te podamos encontrar</p>
            <p>Luego de que completes el formulario de registro, te enviaremos un email con un enlace para que confirmes que la dirección de correo es efectivamente tuya, una vez que confirmes tu email 
        ya podras iniciar una sesión y estarás listo para hacer tu primer reporte.</p>
            <p>Listo quiero <a class="btn btn-primary btn-sm" href="<?=base_url('registro');?>" role="button">crear una cuenta ahora</a> o si ya tienes una tal vez quieras <a class="btn btn-primary btn-sm " href="<?=base_url('sesion');?>" role="button">Iniciar Sesi&oacute;n</a></p>
        </div>
    </div>

    <div class="container">
        <h1 class="display-4">&Uacute;ltimos Reportes:</h1>
        <div class="row">
            <?php 
                foreach ($reportes as  $fila) {
                    echo "<div class='col-md-4'>";
                    echo (!empty($fila->reporte_mascota_nombre)?"<h2>$fila->reporte_mascota_nombre</h2>":"<h2>$fila->tipo_reporte</h2>")."<br/>";
                    

                    foreach($fila->imagenes_reporte as $imagen){
                        echo "<img style='margin-left:10px;' class='img-thumbnail' src='".base_url('reporte/getImagen/'.$imagen->imagen_miniatura)."/thumb'/>";
                        break;
                    }
                    echo "<p>$fila->reporte_descripcion</p>";
                    echo "<p>Departamento: ".$fila->departamento_nombre."<br/>";
                    // echo "Ciudad: ".$fila->ciudad_nombre."<br/>";
                    // echo "Distrito: ".$fila->distrito_nombre."<br/>";
                    // echo "Barrio: ".$fila->barrio_nombre."<br/>";
                    // echo "Direcci&oacute;n: ".$fila->reporte_direccion."</p>";
                    // echo "<hr/>";
                    echo "</div>";
                    //@todo paginador
                }
            ?>
            <!-- <div class="col-md-4">
                <h2>Heading</h2>
                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
            </div>

            <div class="col-md-4">
                <h2>Heading</h2>
                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
            </div>

            <div class="col-md-4">
                <h2>Heading</h2>
                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
            </div>

            <div class="col-md-4">
                <h2>Heading</h2>
                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
            </div>

            <div class="col-md-4">
                <h2>Heading</h2>
                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
            </div>

            <div class="col-md-4">
                <h2>Heading</h2>
                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
            </div> 

            <div class="col-md-4">
                <h2>Heading</h2>
                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
            </div>

            <div class="col-md-4">
                <h2>Heading</h2>
                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
            </div> -->

        </div>
    </div>
<?php echo $this->endSection() ?>