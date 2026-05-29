        <form action="class/manager_abms.php" method="post" id="equiForm" enctype="multipart/form-data">
            <input type="hidden" name="abm" value="equipo">
            <input type="hidden" name="id" value="0">
         	<div class="vali-form">
            <div class="col-md-6 form-group"> 
            <label class="control-label">Familia</label>    
            <div class="combo-boton">     
            <select class="form-control" id="familia" name="familia"  required="Requerido">
            <option value="0">Seleccione...</option>
            <option value="999">Genérica</option>
            <?php
				
				require_once('../class/clases.php');
                $cm = new ConfigurationManager();
				$id=0;
            if($id!=0) 
            { 
                $cm->carga_selected('familia',0,0);
            }
            else
            {
                $cm->carga_selected('familia',0,0);   
            }    
            
            ?>
            </div>
            </div>
            <div class="col-md-6 form-group">
             
            <label class="control-label ">Subfamilia</label>         
            <div class="combo-boton">
            <select class="form-control" id="subfamilia" name="subfamilia"  required="Requerido">
            <option value="0">Seleccione...</option>
            <option value="999">Genérica</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('subfamilia',0,0);
            }
            else
            {
                $cm->carga_selected('subfamilia',0,0);   
            }    
            
            ?>
                                    
            </div>
            </div>
            <div class="col-md-6 form-group"> 
            <label class="control-label">Marca</label>
            <div class="combo-boton">         
            <select class="form-control" id="marca" name="marca"  required="Requerido">
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('marcas',0,0);
            }
            else
            {
                $cm->carga_selected('marcas',0,0);   
            }    
            
            ?>
            </div>
            </div>
            <div class="col-md-6 form-group"> 
            <label class="control-label">Modelo</label>         
            <div class="combo-boton">
            <select class="form-control" id="modelo" name="modelo"  required="Requerido">
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('modelo',0,0);
            }
            else
            {
                $cm->carga_selected('modelo',0,0);   
            }    
            
            ?>
             <button type="button" class="btn btn-primary btn-md btn-group" onclick="agregarModelo()" role="group"><i class="fa fa-plus"></i></button>
			</div>
            </div>                        
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Número de Serie</label>
              <input type="text" placeholder="Ej.TS30665785807" required="" name="nroserie" value="">
            </div>
                                            
            <div class="col-md-12 form-group1 group-mail"> 
            <label class="control-label">Cliente</label>         
            <select class="form-control" id="cliente" name="cliente"  required="Requerido">
            <option value="0">Seleccione...</option>
            <?php 
            if($id!=0) 
            { 
                $cm->carga_selected('cliente',0,0);
            }
            else
            {
				if(isset($_GET['cliente'])) 
				{ 
				$cm->carga_selected('cliente',$_GET['cliente'],0);
				}
				else
				{
				$cm->carga_selected('cliente',0,0);   
				}  
            }    
            
            ?>
            </div>                   
            <div class="col-md-12 form-group1 group-mail">
				<div class="form-group">
				<label for="checkbox" class="control-label">Es equipo patrón?</label>
					<div class="checkbox-inline"><label><input type="radio" name="espatron" value="1"> Si</label></div>
					<div class="checkbox-inline"><label><input type="radio" name="espatron" value="0" checked> No</label></div>
					
				</div>
            </div> 
              <div class="col-md-12 form-group group-mail">
                   
              <img src="images/ico-file.jpg" width = "150px" id="previewing" alt="imagen">
              <input type="file" id="FileInput" name="FileInput">
              <input type="hidden" name="imagen"  value="ico-file.jpg">
              <div id="message"></div>
              <img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Por favor aguarde"/>

            <div id="output"></div>
            
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
            <div class="col-md-12 form-group">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="submit" id="submitEquipo" class="btn btn-primary">Enviar Formulario</button>
            </div>
          <div class="clearfix"> </div>
        </form>
			</div>



<script>
/* must apply only after HTML has loaded */
$(document).ready(function () {
    $("#equiForm").on("submit", function(e) {
        
        var formURL = $(this).attr("action");
        var postData = $(this).serializeArray();
                
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function(data, textStatus, jqXHR) {

                $("#modalequipo").modal('toggle');                
                
            },
            error: function(jqXHR, status, error) {
                console.log(status + ": " + error);
            }
        });
        e.preventDefault();
    });
     
$(document).on("click", "#submitEquipo", function(event){
//    alert( "GO" ); 
	event.preventDefault();
    $(document).find("#equiForm").submit();
    //$(document).find("#modalmarca").modal('hide');
    
});
	
    
      $('select#familia').on('change', function () {
        var id = $(this).val(); // get selected value
        var combo ="subfamilia";
          
        var opcion = 0;  
		if(id!=999){  
        $.get('ajax/detcombo.php', { id:id, combo:combo, opcion:opcion }, function(resp) {
        $('select#subfamilia').html(resp);
        });
		}else{
		$('select#subfamilia').val(id);	
		}	
      });

	     $('select#marca').on('change', function () {
        var id = $(this).val(); // get selected value
        var combo ="modelo";
          
        var opcion = 0;  
		if(id!=999){  
        $.get('ajax/detcombo.php', { id:id, combo:combo, opcion:opcion }, function(resp) {
        $('select#modelo').html(resp);
        });
		}else{
		$('select#modelo').val(id);	
		}	
      });
    
});
	
	function agregarModelo(){
				idmarca = $('select#marca').val();
		if(idmarca==0){
			alert('Debe seleccionar una marca!');
		}else{
        $('#modalmodelo').attr('data-remote','ajax/frmmodelos.php?idmarca='+idmarca);
        $('#modalmodelo').modal('toggle');
		}
   
};

	$('#modalmodelo').on('show.bs.modal', function(){
		//alert('capturo');
	$('#modalequipo').css('opacity',.5);
		$(this).css('z-index',1060);

	});
	
	$('#modalmodelo').on('hidden.bs.modal', function(){
		$('#modalequipo').css('opacity',1);
		cargarModelos();


	});

	function cargarModelos(){
        var id = $('select#marca').val();// get selected value
        var combo ="modelo";
          
        var opcion = 0;  
        $.get('ajax/detcombo.php', { id:id, combo:combo, opcion:opcion }, function(resp) {
        $('select#modelo').html(resp);

});    
}
	
</script>