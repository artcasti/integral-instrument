<?php  
require_once('../class/clases.php');

$cm = new ConfigurationManager();

if (isset($_GET['tipodoc']))
{
    switch($_GET['tipodoc']){
		case '2':
				$info = $cm->getCotizacion($_GET['id']);
			break;	
	}
}

?>
		<div class="validation-system">
 		
 		<div class="validation-form">
 	<!---->
  	    
        <form action="class/enviar2.php" method="post" id="formMensaje">
        	<input type="hidden" name="tipodoc" value="<?php echo $_GET['tipodoc'];?>">
        	<input type="hidden" name="archivo" value="<?php echo 'P'.trim($info['referencia']).'.pdf';  ?>">
        	<input type="hidden" name="idcotizacion" value="<?php echo $_GET['id'];?>">
        	
         	<div class="vali-form">
            <div class="col-md-12 form-group1">
              <label class="control-label">Para</label>
              <input type="text" placeholder="Para" required="" name="para" value="<?php echo $info['emailenvio'];  ?>">
            </div>
            <div class="col-md-12 form-group1">
              <label class="control-label">Asunto</label>
              <input type="text" placeholder="Asunto" required="" name="asunto" value="Cotización Solicitada Ref: <?php echo $info['referencia'];  ?>"  >
            </div>           
            
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Texto del Mensaje</label>
              <textarea placeholder="cuerpo"  id="cuerpo" name="cuerpo">
              	<?php  echo $info['encabezado']; ?>
              </textarea>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'cuerpo' );
            </script>
            </div>
             <div class="clearfix"> </div>



           

          <div class="clearfix"> </div>
            <div class="col-md-12 form-group">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="submit" id="submitMensaje" class="btn btn-primary">Enviar Cotizacion</button>
            </div>
          <div class="clearfix"> </div>
        </form>
    
 	<!---->
 </div>

</div>



<script>
$(document).on("click", "#submitMensaje", function(event){
//    alert( "GO" ); 
	event.preventDefault();
    $(document).find("#formMensaje").submit();
    //$(document).find("#modalmarca").modal('hide');
    
});
    

</script>