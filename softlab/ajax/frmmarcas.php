	<div class="validation-system">
 		
 		<div class="validation-form">
 	<!---->
  	    
        <form action="class/manager_abms.php" method="post" id="formMarca" enctype="multipart/form-data">
            <input type="hidden" name="abm" value="marca">
            <input type="hidden" name="idmarca" value="0">
         	<div class="vali-form">
            <div class="col-md-6 form-group1">
              <label class="control-label">Marca</label>
              <input type="text" placeholder="Marca" required="" name="marca" >
            </div>
                <div class="col-md-6 form-group1">
              <img src="./images/marcas/ico-file.jpg" width = "150px" id="previewing" alt="imagen">
              <input type="file" id="FileInput" name="FileInput">
              <input type="hidden" name="imagen"  value="ico-file.jpg">
              <div id="message"></div>
              <img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Por favor aguarde"/>

            <div id="output"></div>
            
                 </div>
                 
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Sitio WEB</label>
              <input type="text" placeholder="Sitio WEB de la Marca" required="" name="urlmarca">
            </div>
            <div class="clearfix"> </div>
           
            
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Observaciones</label>
              <textarea placeholder="observaciones"  id="observaciones" name="observaciones">
              	
              </textarea>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'observaciones' );
            </script>
            </div>
             <div class="clearfix"> </div>



           

          <div class="clearfix"> </div>
            <div class="col-md-12 form-group">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="submit" id="submitMarca" class="btn btn-primary">Enviar Formulario</button>
            </div>
          <div class="clearfix"> </div>
        </form>
    
 	<!---->
 </div>

</div>



<script>
/* must apply only after HTML has loaded */
$(document).ready(function () {
    $("#formMarca").on("submit", function(e) {
        
        var formURL = $(this).attr("action");
        var postData = $(this).serializeArray();
                
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function(data, textStatus, jqXHR) {

                $("#modalmarca").modal('toggle');                
                
            },
            error: function(jqXHR, status, error) {
                console.log(status + ": " + error);
            }
        });
        e.preventDefault();
    });
     
$(document).on("click", "#submitMarca", function(event){
//    alert( "GO" ); 
	event.preventDefault();
    $(document).find("#formMarca").submit();
    //$(document).find("#modalmarca").modal('hide');
    
});
    


    
});

</script>