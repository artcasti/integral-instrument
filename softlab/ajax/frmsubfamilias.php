
<div class="grid-form">
 		<div class="grid-form1">
 		<h3 id="forms-example" class="">Nueva Subfamilia</h3>
 		<form action="class/manager_abms.php" id="formsubfamilia" method="post">
<div class="form-group"> 
            <label class="control-label">Familia</label>         
            <select id="familia" name="familia"  >
            <option value="0">Seleccione...</option>
            <?php 
                require_once('../class/clases.php');
                $cm = new ConfigurationManager();
            if(isset($_GET['familia'])) 
            { 
                $cm->carga_selected('familia',$_GET['familia'],0);
            }
            else
            {
                $cm->carga_selected('familia',0,0);   
            }    
            
            ?>
    </div>
    <div class="form-group">
   <input type="hidden" name="abm" value="subfamilia" >
   <input type="hidden" name="id" id="id" value="0">
    <label for="exampleInputMenu">Subfamilia</label>
    <input type="text" class="form-control" id="subfamilia" name ="subfamilia" placeholder="Nombre de la Familia">
  </div>

        </form>
        </div>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
<a class="btn btn-danger" id="submitSubFam">Agregar</a>
</div>


<script>
/* must apply only after HTML has loaded */
$(document).ready(function () {
    $("#formsubfamilia").on("submit", function(e) {
        
        var formURL = $(this).attr("action");
        var postData = $(this).serializeArray();
                
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function(data, textStatus, jqXHR) {

                $("#modalsubfamilia").modal('toggle');                
                
            },
            error: function(jqXHR, status, error) {
                console.log(status + ": " + error);
            }
        });
        e.preventDefault();
    });
     
$(document).on("click", "#submitSubFam", function(event){
//    alert( "GO" ); 
    $(document).find("#formsubfamilia").submit();
  //  $(document).find("#myModal").modal('toggle');
    
});
    


    
});

</script>

