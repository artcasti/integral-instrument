 
$("#nrodoc").blur(function(){

//alert('sale');	
var tipodoc = $('#tipodoc').val();
var nrodoc = $('#nrodoc').val().trim();
	if(tipodoc == 0){
		if(nrodoc!=''){
		alert('Debe seleccionar un tipo de documento');
		$('#tipodoc').focus();
		return false;
		}else{
		return false;	
		}	
		
	}
	
        //alert(email);
    $.ajax({
        url: 'ajax/controlcuit.php',
        data: {tipodoc: tipodoc, nrodoc: nrodoc},
        type: 'GET',
        success: function(response){
                   //alert(response);
            if(response==='NO' ){
//                         alert('El Documento ya existe en la base de datos');
                        //alert(response);
				 $('#nrodoc').parent().addClass('has-error');
						$('#nrodoc').focus();

//                $('#modal-reg #idcandidato').val(response);
//                $(document).find("#inicia_registro").submit();
//                $('#modal-reg').modal('hide');
            }else{
                   //alert(response);
        		$('#nrodoc').parent().removeClass('has-error');
				
//                $('#nombre').parent().removeClass('has-error');
//                $('#apellido').parent().removeClass('has-error');
//                $('#mail').parent().removeClass('has-error');
//                
//                $(document).find("#inicia_registro").submit();
//                $('#modal-reg').modal('hide');
            }
        }
    });
	
});

$('select#tipodoc').on('change',function(){
	//alert($(this).val());
	if($(this).val()!=0){
		$('#nrodoc').focus();
	}
});