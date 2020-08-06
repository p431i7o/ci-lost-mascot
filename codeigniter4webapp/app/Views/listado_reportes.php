<?php $this->extend('default_layout');

echo $this->section('content'); ?>

<div class="container">

      <div class="text-left py-5">
        <h1 class="display-3">Listado de Reportes</h1>
        
        <?php
        foreach($reportes as $fila){


            echo "<div class='container-fluid'>";
            echo "<h3>$fila->tipo_reporte: $fila->reporte_mascota_nombre</h3><br/>";
            echo "<p>$fila->reporte_descripcion</p>";
            foreach($fila->imagenes_reporte as $imagen){
                echo "<img style='margin-left:10px;' class='img-thumbnail' src='".base_url('reporte/getImagen/'.$imagen->imagen_miniatura)."/thumb'/>";
            }
            echo "<p>Departamento: ".$fila->departamento_nombre."<br/>";
            echo "Ciudad: ".$fila->ciudad_nombre."<br/>";
            echo "Distrito: ".$fila->distrito_nombre."<br/>";
            echo "Barrio: ".$fila->barrio_nombre."<br/>";
            echo "Direcci&oacute;n: ".$fila->reporte_direccion."</p>";
            echo "<hr/>";
            echo "</div>";
        }
        ?>
   

            
    </div>
</div>


<?php echo $this->endSection() ?>