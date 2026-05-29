<?php 
require_once('../class/clases.php');
$cm = new ConfigurationManager();

if ( $_GET[ 'nrolinea' ]!=0 ) {
$infoingreso=$cm->getLineaDetalle($_GET['id'],$_GET['nrolinea']);
$equipo = $infoingreso[2];	
} else {
$equipo = $_GET['idequipo'];
$infoingreso=$cm->getLineaDetalle(0,0);	
}

$infoequipo=$cm->getEquipo($equipo);


?>
        
          <form action="class/manager_abms.php" method="post" id="ingresoForm" enctype="multipart/form-data">
            <input type="hidden" name="abm" value="agregaringreso">
            <input type="hidden" name="id" value="<?php echo $_GET['id'];  ?>">
            <input type="hidden" name="nrolinea" value="<?php if ($_GET['nrolinea']!=0) {echo $_GET['nrolinea'];   }else{echo 0;    }  ?>">
            <input type="hidden" name="equipo" value="<?php echo $equipo;  ?>">
            
         	<div class="vali-form">
         	    <div class="col-md-12 form-group group-mail">
				<label class="col-md-10 control-label">Formulario Nro: <?php echo $_GET['id'];  ?></label>
				<label class="col-md-10 control-label">Equipo:<?php echo $infoequipo['marca'].'-'.$infoequipo['modelo'].'-'.$infoequipo['nroserie'];?></label>
		
				</div>
          <div class="col-md-12 form-group1 group-mail">
				<div class="form-group">
				<label for="checkbox" class="col-md-2 control-label">Trabajos</label>
				<div class="col-md-10">
					<div class="checkbox-inline"><label><input type="checkbox" name="calibra" value="0" <?php if ($infoingreso[3]){echo 'checked';}  ?> > Calibra</label></div>
					<div class="checkbox-inline"><label><input type="checkbox" name="repara" value="0" <?php if ($infoingreso[4]){echo 'checked';}  ?>>  Repara</label></div>
				</div>	
				</div>
            </div>                                  
            <div class="col-md-12 form-group1 group-mail">
				<div class="form-group">
				<label for="checkbox" class="col-md-2 control-label">Imprime Vto Certificado?</label>
				<div class="col-md-10">
					<div class="checkbox-inline"><label><input type="radio" name="vtocertificado" value="1" <?php if ($infoingreso[11]){echo 'checked';}  ?>> Si</label></div>
					<div class="checkbox-inline"><label><input type="radio" name="vtocertificado" value="0" <?php if ($infoingreso[11]){echo 'checked';}  ?>> No</label></div>
				</div>	
				</div>
            </div>             
            <div class="col-md-12 form-group1 group-mail">
				<div class="form-group">
				<label for="checkbox" class="col-xs-2 control-label">Accesorios</label>
				<div class="col-xs-10">
					<div class="checkbox-inline"><label><input type="checkbox" name="cargador" value="0" <?php if ($infoingreso[5]){echo 'checked';}  ?>> Cargador</label></div>
					<div class="checkbox-inline"><label><input type="checkbox" name="valija" value="0" <?php if ($infoingreso[6]){echo 'checked';}  ?>> Valija</label></div>
					<div class="checkbox-inline"><label><input type="checkbox" name="interfase" value="0" <?php if ($infoingreso[7]){echo 'checked';}  ?>>Interfase</label></div>
					<div class="checkbox-inline"><label><input type="checkbox" name="bomba" value="0" <?php if ($infoingreso[8]){echo 'checked';}  ?>>Bomba</label></div>
					<div class="checkbox-inline"><label><input type="checkbox" name="copa" value="0" <?php if ($infoingreso[9]){echo 'checked';}  ?>>Copa de Calibración</label></div>
					<div class="checkbox-inline"><label><input type="checkbox" name="baterias" value="0" <?php if ($infoingreso[10]){echo 'checked';}  ?>>Baterías</label></div>
				</div>
				</div>
            </div>                                  
              <div class="col-md-12 form-group group-mail">
                   
              <img src="<?php if($_GET['nrolinea']!=0) { echo  'images/laboratorio/'.$infoingreso[12];}else{ echo 'images/ico-file.jpg';} ?>" width = "150px" id="previewing" alt="imagen">
              <input type="file" id="FileInput" name="FileInput">
              <input type="hidden" name="imagen"  <?php if($_GET['nrolinea']!=0) { echo  'value="'.$infoingreso[12].'"';}else{ echo 'value="ico-file.jpg"';}?>>
              <div id="message"></div>
              <img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Por favor aguarde"/>

            <div id="output"></div>
            
                 </div>        
            
            
            <div class="clearfix"> </div>
           

           
            
            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Observaciones</label>
              <textarea placeholder="observaciones"  id="observaciones" name="observaciones"> <?php if($_GET['nrolinea']!=0) { echo  $infoingreso[13];}?></textarea>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'observaciones' );
            </script>
            </div>
             <div class="clearfix"> </div>

			<div class="col-md-6 form-group">
			<label class="control-label">Entregado por</label>
			<input type="text"  id="entregadopor" name="entregadopor" class="form-control">
			</div>
          

          <div class="clearfix"> </div>
            <div class="col-md-12 form-group">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="submit" id="submitIngreso" class="btn btn-primary">Enviar Formulario</button>
            </div>
          <div class="clearfix"> </div>
        </form>
			</div>



<script>
/* must apply only after HTML has loaded */
$(document).ready(function () {
/*    $("#ingresoForm").on("submit", function(e) {
        
        var formURL = $(this).attr("action");
        var postData = $(this).serializeArray();
                
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function(data, textStatus, jqXHR) {

                $("#modalingreso").modal('toggle');                
                
            },
            error: function(jqXHR, status, error) {
                console.log(status + ": " + error);
            }s
        });
        e.preventDefault();
    });*/
     
$(document).on("click", "#submitEquipo", function(event){
//    alert( "GO" ); 
	event.preventDefault();
    $(document).find("#ingresoForm").submit();
    //$(document).find("#modalmarca").modal('hide');
    
});
	
    
});

</script>