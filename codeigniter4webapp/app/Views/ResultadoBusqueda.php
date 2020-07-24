<?php $this->extend('default_layout');

echo $this->section('content'); ?>

<div class="container">

    <div class="text-left py-5">
        <h1 class="display-3">Resultado de la b&uacute;squeda:</h1>
    </div>
    <div class="row">
        <p>No se encontraron resultados para la busqueda</p>
    </div>
</div>


<?php echo $this->endSection() ?>