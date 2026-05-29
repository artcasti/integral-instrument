 
 <form action="class/manager_abms.php" method="post" id="formCliente" enctype="multipart/form-data" >
            <input type="hidden" name="abm" value="cliente">
            <input type="hidden" name="id" value="0">
         	<div class="vali-form">
           <div class="col-md-12 form-group" >
		<p class="clasificacion">
                    <input class ="estrellas" id="radio1" type="radio" name="estrellas" value="5" ><!--
                    --><label id="lblstar" for="radio1">&#9733;</label><!--
                    --><input class ="estrellas" id="radio2" type="radio" name="estrellas" value="4" ><!--
                    --><label id="lblstar" for="radio2">&#9733;</label><!--
                    --><input class ="estrellas" id="radio3" type="radio" name="estrellas" value="3" ><!--
                    --><label id="lblstar" for="radio3">&#9733;</label><!--
                    --><input class ="estrellas" id="radio4" type="radio" name="estrellas" value="2" ><!--
                    --><label id="lblstar" for="radio4">&#9733;</label><!--
                    --><input class ="estrellas" id="radio5" type="radio" name="estrellas" value="1" ><!--
                    --><label id="lblstar" for="radio5">&#9733;</label>
                  </p>
           </div>
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Nombre o Razón Social</label>
              <input type="text" placeholder="Nombre" class="form-control" required="" name="nombre"  >
            </div>           
            <div class="col-md-6 form-group"> 
            <label class="control-label">Tipo de Documento</label>         
            <select class="form-control" id="tipodoc" name="tipodoc"  required="Requerido">
            <option value="0">Seleccione...</option>
            <?php 
				require_once('../class/clases.php');
                $cm = new ConfigurationManager();
				
                $cm->carga_selected('tipodoc',0,0);   
             ?>
            </div>
            <div class="col-md-6 form-group1">
              <label class="control-label">Número de Documento</label>
              <input type="text" placeholder="Ej.30665785807" required="" class="form-control" id="nrodoc" name="nrodoc"  >
                <span class="help-block error">Documento ya utilizado</span>
            </div>

                                
            <div class="col-md-12 form-group"> 
            <label class="control-label">Condición IVA</label>         
            <select class="form-control" id="condiva" name="condiva"  required="Requerido">
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('condiva',0,0);
            }
            else
            {
                $cm->carga_selected('condiva',0,0);   
            }    
            
            ?>
            </div>                 
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Domicilio</label>
              <input type="text" placeholder="Ej. Pavón 1555 Piso 1 Depto 2" class="form-control" name="domicilio">
            </div>
            <div class="col-md-6 form-group1 group-mail">
              <label class="control-label">Localidad</label>
              <input type="text" placeholder="Ej. Buenos Aires" class="form-control" name="localidad" >
            </div>
            <div class="col-md-6 form-group1 group-mail">
              <label class="control-label">Código Postal</label>
              <input type="text" placeholder="Ej. C1425ABE" name="cpostal" class="form-control" >
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
            
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Teléfono</label>
              <input type="text" placeholder="Ej. 1146658997" name="telefono" class="form-control">
            </div>
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Contacto Principal</label>
              <input type="text" placeholder="Ej. Eduardo Gonzalez" name="contactoppal" class="form-control" >
            </div>
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Correo Electrónico</label>
              <input type="text" placeholder="Ej. eduardogonzalez@hotmail.com" name="email"  class="form-control">
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
            <div class="checkbox-inline"><label><input type="radio" name="habilitado" value="0"> No</label></div>
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
                CKEDITOR.replace( 'observaciones' );
            </script>
            </div>
             <div class="clearfix"> </div>

        </form>



          <div class="clearfix"> </div>
            <div class="col-md-12 form-group">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="submit" id="submitCliente" class="btn btn-primary">Enviar Formulario</button>
            </div>
          <div class="clearfix"> </div>
        </form>
			</div>



<script>
/* must apply only after HTML has loaded */
$(document).ready(function () {
    $("#formCliente").on("submit", function(e) {
        
        var formURL = $(this).attr("action");
        var postData = $(this).serializeArray();
                
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function(data, textStatus, jqXHR) {

                $("#modalcliente").modal('toggle');                
                
            },
            error: function(jqXHR, status, error) {
                console.log(status + ": " + error);
            }
        });
        e.preventDefault();
    });
     
$(document).on("click", "#submitCliente", function(event){

	event.preventDefault();
    $(document).find("#formCliente").submit();
    
});
    


    
});
</script>
	<script src="js/controlcuit.js"></script>