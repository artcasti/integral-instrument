
<div class="grid-form">
 		<div class="grid-form1">
 		<h3 id="forms-example" class="">Nuevo Contacto</h3>
 		<form action="class/manager_abms.php" method="post" id="contactofrm" enctype="multipart/form-data">
           <?php  $id = 0; ?>
            <input type="hidden" name="abm" value="contacto">
            <input type="hidden" name="id" value="0">
         	<div class="vali-form">
         	  <div class="col-md-6 form-group1">
              <img src="images/contactos/perfil.jpg" width = "150px" id="previewing" alt="imagen">
              <input type="file" id="FileInput" name="FileInput">
              <input type="hidden" name="imagen"  value="perfil.jpg">
              <div id="message"></div>
              <img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Por favor aguarde"/>

            <div id="output"></div>
            
                 </div>
           <div class="col-md-6 form-group1" >
                 <p class="clasificacion">
                    <input class ="estrellas" id="radio1" type="radio" name="estrellas" value="5" <?php if ($id!=0){echo $checked= ($infoitem[11]==5) ? 'checked' : '';}?>><!--
                    --><label id="lblstar" for="radio1">&#9733;</label><!--
                    --><input class ="estrellas" id="radio2" type="radio" name="estrellas" value="4" <?php if ($id!=0){echo $checked= ($infoitem[11]==4) ? 'checked' : '';}?>><!--
                    --><label id="lblstar" for="radio2">&#9733;</label><!--
                    --><input class ="estrellas" id="radio3" type="radio" name="estrellas" value="3" <?php if ($id!=0){echo $checked= ($infoitem[11]==3) ? 'checked' : '';}?>><!--
                    --><label id="lblstar" for="radio3">&#9733;</label><!--
                    --><input class ="estrellas" id="radio4" type="radio" name="estrellas" value="2" <?php if ($id!=0){echo $checked= ($infoitem[11]==2) ? 'checked' : '';}?>><!--
                    --><label id="lblstar" for="radio4">&#9733;</label><!--
                    --><input class ="estrellas" id="radio5" type="radio" name="estrellas" value="1" <?php if ($id!=0){echo $checked= ($infoitem[11]==1) ? 'checked' : '';}?>><!--
                    --><label id="lblstar" for="radio5">&#9733;</label>
                  </p>
           </div>
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Contacto</label>
              <input type="text" placeholder="Ej.Carlos Gonzalez" required="" name="contacto">
            </div>
            <div class="col-md-6 form-group1 group-mail">
              <label class="control-label">Teléfono</label>
              <input type="text" placeholder="Ej. 1146658997" name="telefono" >
            </div>
            <div class="col-md-6 form-group1 group-mail">
              <label class="control-label">Correo Electrónico</label>
              <input type="text" placeholder="Ej. eduardogonzalez@hotmail.com" name="email" >
            </div>
                                  
            <div class="col-md-12 form-group"> 
            <label class="control-label">Cliente</label>         
            <select class="form-control" id="cliente" name="cliente"  required="Requerido">
            <option value="0">Seleccione...</option>
            <?php 
                require_once('../class/clases.php');
                $cm = new ConfigurationManager();
            if(isset($_GET['cliente'])) 
            { 
                $cm->carga_selected('cliente',$_GET['cliente'],0);
            }
            else
            {
                $cm->carga_selected('cliente',0,0);   
            }    
            
            ?>
            </div>                 
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Domicilio</label>
              <input type="text" placeholder="Ej. Pavón 1555 Piso 1 Depto 2" name="domicilio" >
            </div>
            <div class="col-md-6 form-group1 group-mail">
              <label class="control-label">Localidad</label>
              <input type="text" placeholder="Ej. Buenos Aires" name="localidad" >
            </div>
            <div class="col-md-6 form-group1 group-mail">
              <label class="control-label">Código Postal</label>
              <input type="text" placeholder="Ej. C1425ABE" name="cpostal" >
            </div>
            <div class="col-md-6 form-group"> 
            <label class="control-label">Provincia</label>         
            <select class="form-control" id="provincia" name="provincia" >
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('provincia',0,0);
            }
            else
            {
                $cm->carga_selected('provincia',0,0);   
            }    
            
            ?>
            </div>                 
            <div class="col-md-6 form-group"> 
            <label class="control-label">País</label>         
            <select class="form-control" id="pais" name="pais" >
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('pais',0,0);
            }
            else
            {
                $cm->carga_selected('pais',0,0);   
            }    
            
            ?>
            </div>                 
            
            <div class="col-md-12 form-group"> 
            <label class="control-label">Transporte</label>         
            <select class="form-control" id="transporte" name="transporte" >
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('transporte',0,0);
            }
            else
            {
                $cm->carga_selected('transporte',0,0);   
            }    
            
            ?>
            </div>  
                                                
            <div class="col-md-12 form-group1 group-mail">
            <div class="form-group">
            <label for="checkbox" class="col-sm-2 control-label">Habilitado</label>
            <div class="col-sm-8">
            <div class="checkbox-inline"><label><input type="radio" name="habilitado" value="1" checked=""> Si</label></div>
            <div class="checkbox-inline"><label><input type="radio" name="habilitado" value="0" > No</label></div>
            </div>
            </div>
            </div>            
            
            
            <div class="clearfix"> </div>
           
            
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Observaciones</label>
              <textarea placeholder="observaciones"  id="observaciones" name="observaciones"> </textarea>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'observaciones',{height:'50px' }  );
            </script>
            </div>
             <div class="clearfix"> </div>

          <div class="clearfix"> </div>
        </form>
 
        </div>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
<a class="btn btn-danger" id="submitContacto">Agregar</a>
</div>


<script>
/* must apply only after HTML has loaded */
$(document).ready(function () {
    $("#contactofrm").on("submit", function(e) {
        
        var formURL = $(this).attr("action");
        var postData = $(this).serializeArray();
                
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function(data, textStatus, jqXHR) {

                $("#modalcontacto").modal('toggle');                
                
            },
            error: function(jqXHR, status, error) {
                console.log(status + ": " + error);
            }
        });
        e.preventDefault();
    });
     
$(document).on("click", "#submitContacto", function(event){
//    alert( "GO" ); 
    $(document).find("#contactofrm").submit();
  //  $(document).find("#myModal").modal('toggle');
    
});
    


    
});

</script>

   