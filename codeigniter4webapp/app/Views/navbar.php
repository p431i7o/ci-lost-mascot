<nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="<?= base_url('Inicio'); ?>">Mascotas Perdidas</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('Inicio'); ?>">Inicio <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('ayuda'); ?>">Ayuda</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('legal'); ?>">Legal</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?=base_url('registro');?>">Registro</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=base_url('sesion');?>" >Iniciar Sesi&oacute;n</a> <!-- tabindex="-1"  disabled aria-disabled="true" -->
                    </li>
                </ul>
                <form action="<?= base_url('Buscar');?>" class="form-inline my-2 my-lg-0">
                    <input name="texto_busqueda" class="form-control mr-sm-2" type="text" placeholder="Buscar" aria-label="Buscar">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>
            </div>
        </nav>