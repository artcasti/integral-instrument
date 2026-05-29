 	<div class="grid-form">
 		<div class="grid-form1">
 		<h3 id="forms-example" class="">Nueva Familia</h3>
 		<form action="class/manager_abms.php" id="formfamilia" method="post">
  <div class="form-group">
   <input type="hidden" name="abm" value="familia" >
   <input type="hidden" name="id" id="id" value="0">
   <input type="hidden" name="location" id="location" value=<?php echo $_GET['location'];?>>
    <label for="exampleInputMenu">Familia</label>
    <input type="text" class="form-control" id="familia" name ="familia" placeholder="Nombre de la Familia">
  </div>

<!--  <button type="submit" class="btn btn-default">Submit</button>-->
</form>
</div>
        </div>
        				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<a class="btn btn-danger" id="submitForm">Agregar</a>
				</div>


<script>
/* must apply only after HTML has loaded */
$(document).ready(function () {
    $("#formfamilia").on("submit", function(e) {
        
        var formURL = $(this).attr("action");
        var postData = $(this).serializeArray();
                
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function(data, textStatus, jqXHR) {

                $("#myModal").modal('toggle');                
                
            },
            error: function(jqXHR, status, error) {
                console.log(status + ": " + error);
            }
        });
        e.preventDefault();
    });
     
$(document).on("click", "#submitForm", function(event){
//    alert( "GO" ); 
    $(document).find("#formfamilia").submit();
  //  $(document).find("#myModal").modal('toggle');
    
});
    


    
});

</script>