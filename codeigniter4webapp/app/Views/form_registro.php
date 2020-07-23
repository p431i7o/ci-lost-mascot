<?php $this->extend('default_layout');

echo $this->section('content'); ?>
<style type="text/css">
    
.form-signin {
  width: 100%;
  max-width: 420px;
  padding: 15px;
  margin: auto;
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
</style>
<div class="container">
    <div class="row">
        <h4 class="display-3">Formulario de registro</h4>
    </div>
</div>
<div class="container">
    <div class="row">
    <div class="col-5 py-5 text-justify">
        
        <p class="lead text-justify">
            ¿Por qu&eacute; pedimos que se registre?
            <br/>
            Es para que se pueda garantizar que tengamos ciertos datos, que permitan que ocurra una comunicaci&oacute;n entre los que buscan y encuentran a las mascotas.
        <br/>
            <!-- No estamos afiliados con ning&uacute;n grupo de ninguna clase, nuestra &uacute;nica intenci&oacute;n es ayudar a que los animalitos que anden perdidos, puedan regresar a sus hogares. -->
        <br/>
            Si bien hacemos nuestro mejor esfuerzo, en cuidar los datos que ustedes con confianza nos proveen, le rogamos no reutilizar su contrase&ntilde;a, escriba una que sea &uacute;nica para este sitio, que tenga al menos 6 caracteres y  procure usar n&uacute;meros y letras en MAY&Uacute;SCULAS y min&uacute;sculas as&iacute; como s&iacute;mbolos especiales para que la contrase&ntilde;a sea lo mas segura posible.
        </p>
    </div>
    
    <form method="POST" class=" col-md-5 form-signin needs-validation accordion"  novalidate action="<?=base_url('registrar_cuenta');?>" >
            <!-- <div class="">
                <label for="firstName">Nombre Completo:</label>
                <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
                    <div class="invalid-feedback">
                    Valid first name is required.
                </div>
            </div> -->
        <div class="form-label-group">
            <input name="usuario_nombre" type="text" id="nombre" class="form-control" placeholder="Nombre Completo" required autofocus>
            <label for="nombre">Nombre Completo</label>
        </div>

        <div class="form-label-group">
            <input name="usuario_nombre" type="text" id="nombre" class="form-control" placeholder="N&uacute;mero telef&oacute;nico" required autofocus>
            <label for="nombre">Tel&eacute;fono</label>
        </div>

        <div class="form-label-group">
            <input type="email" id="usuario_email" name="usuario_email" class="form-control" placeholder="Direcci&oacute;n de correo" required autofocus>
            <label for="inputEmail">Correo electr&oacute;nico</label>
          </div>

        <div class="form-label-group">
            <input type="password" id="usuario_password" name="usuario_password" class="form-control" placeholder="Contrase&ntilde;" required>
            <label for="usuario_password">Contrase&ntilde;a</label>
        </div>
        
        <button class="btn btn-lg btn-primary btn-block" type="button" onclick="validarYEnviar();">Registrarme</button>
        
    </form>
  </div>
</div>

<?php echo $this->endSection() ?>