<?php $this->extend('dashboard_layout');
echo $this->section('content') ?>

<h1 class="h2">Dashboard - Mis reportes</h1>

</div>
<?php
    foreach ($reportes as  $fila) {
        echo "<div class='container-fluid'>";
        echo "<h3>$fila->tipo_reporte: $fila->reporte_mascota_nombre</h3><br/>";
        echo "<p>$fila->reporte_descripcion</p>";
        foreach($fila->imagenes_reporte as $imagen){
            echo "<img class='img-thumbnail' src='".base_url('reporte/getImagen/'.$imagen->imagen_miniatura)."/thumb'/>";
        }
        echo "</div>";
    }
?>
<div>
<?php echo $this->endSection() ?>