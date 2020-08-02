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
    <div class="row text-center">
        <h4 class="display-3 text-center">Cambio de contrase&ntilde;a</h4>
    </div>
</div>
<div class="container">
    <div class="row">

        <form id="demo-form" method="POST" class="form-signin needs-validation accordion" action="<?=base_url('cambio_contrasenha');?>" >

            <?= csrf_field() ?>
            <input type="hidden" name="email_hasheado" value="<?=$email_hasheado;?>">
            <input type="hidden" name="hash_recuperacion" value="<?=$hash_recuperacion;?>">
                <!-- <div class="">
                    <label for="firstName">Nombre Completo:</label>
                    <input type="text" class="form-control" id="firstName" placeholder="" value="" required>
                        <div class="invalid-feedback">
                        Valid first name is required.
                    </div>
                </div> -->
            <?php if($session->getFlashdata('error')){
                ?>
                <div class="alert alert-warning"><?= is_array($session->getFlashdata('error'))?implode('<br/>',$session->getFlashdata('error')):$session->getFlashdata('error'); ?></div>

                <?php
            } ?>

            <div class="form-label-group">
                <input type="password" id="usuario_password" name="usuario_password" class="form-control" required autofocus>
                <label for="usuario_password">Nueva contrase&ntilde;a</label>
                <?php 
                    if (isset($validation) && $validation->hasError('usuario_password'))
                    {
                        echo '<div class="alert alert-danger">'.$validation->getError('usuario_password').'</div>';
                    }
                ?>
              </div>

            <div class="form-label-group">
                <input type="password" id="usuario_password2" name="usuario_password2" class="form-control"  required>
                <label for="usuario_password2">Repetir Contrase&ntilde;a</label>
                <?php 
                    if (isset($validation) && $validation->hasError('usuario_password2'))
                    {
                        echo '<div class="alert alert-danger">'.$validation->getError('usuario_password2').'</div>';
                    }
                ?>
            </div>
            <?php 
                    if (isset($validation) && $validation->hasError('g-recaptcha-response'))
                    {
                        echo '<div class="alert alert-danger">'.$validation->getError('g-recaptcha-response').'</div>';
                    }
                ?>
            <!-- <button class="btn btn-lg btn-primary btn-block" type="submit" onclick="validarYEnviar();">Registrarme</button> -->
            
            <button class="g-recaptcha btn btn-lg btn-primary btn-block" 
            data-sitekey="<?=env('captcha_public');?>" 
            data-callback='onSubmit' 
            data-action='submit'>Cambiar Contrase&ntilde;a</button>
                    
        </form>
    </div>
</div>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
   function onSubmit(token) {
     document.getElementById("demo-form").submit();
   }
 </script>
<?php echo $this->endSection() ?>