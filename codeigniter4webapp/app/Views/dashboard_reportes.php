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
            echo "<div><img style='margin-left:10px; margin-top:10px; width:100px;' class='img-thumbnail' src='".base_url('reporte/getImagen/'.$imagen->imagen_miniatura)."/thumb'/></div>";
        }
        echo "<p>Departamento: ".$fila->departamento_nombre."<br/>";
        echo "Ciudad: ".$fila->ciudad_nombre."<br/>";
        echo "Distrito: ".$fila->distrito_nombre."<br/>";
        echo "Barrio: ".$fila->barrio_nombre."<br/>";
        echo "Direcci&oacute;n: ".$fila->reporte_direccion."</p>";
        if($fila->reporte_vencimiento < date("Y-m-d H:i:s")){
            echo "<button onclick='renovarUnaSemana(".$fila->id_reporte.");' class='btn btn-warning'>Renovar Publicacion 1 semana</button>";
        }
        // echo "<pre>".print_r($fila,true)."</pre>";
        echo "<hr/>";
        echo "</div>";
        //@todo paginador
    }
?>
<div>
<script type="text/javascript">
    function renovarUnaSemana(id_reporte){
        window.location = "<?=base_url();?>/reporte/renovarUnaSemana/"+id_reporte;
    }
</script>
<?php echo $this->endSection() ?>