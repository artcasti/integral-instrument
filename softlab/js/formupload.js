$(document).ready(function() { 
	var options = { 
			target:   '#output',   // target element(s) to be updated with server response 
			beforeSubmit:  beforeSubmit,  // pre-submit callback 
			success:       afterSuccess,  // post-submit callback 
//			uploadProgress: OnProgress, //upload progress callback 
			resetForm: true        // reset the form after successful submit 
		}; 
		
	 $('#MyUploadForm').submit(function() { 
			$(this).ajaxSubmit(options);  			
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}); 
		

//function after succesful file upload (when server response)
function afterSuccess()
{
	$('#submit-btn').show(); //hide submit button
	$('#loading-img').hide(); //hide submit button
	$('#progressbox').delay( 1000 ).fadeOut(); //hide progress bar

}

//function to check file size before uploading.
function beforeSubmit(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		
		if( !$('#FileInput').val()) //check empty input filed
		{
			$("#output").html("Tiene que seleccionar un archivo!");
			return false
		}
		
		var fsize = $('#FileInput')[0].files[0].size; //get file size
		var ftype = $('#FileInput')[0].files[0].type; // get file type
		

		//allow file types 
		switch(ftype)
        {
            case 'image/png': 
			case 'image/gif': 
			case 'image/jpeg': 
			case 'image/pjpeg':
			case 'text/plain':
			case 'text/html':
			case 'application/x-zip-compressed':
			case 'application/pdf':
			case 'application/msword':
			case 'application/vnd.ms-excel':
			case 'video/mp4':
                break;
            default:
                $("#output").html("<b>"+ftype+"</b> Tipo de archivo no soportado!");
				return false
        }
		
		//Allowed file size is less than 512 KB (524288)
		if(fsize>524288) 
		{
			$("#output").html("<b>"+bytesToSize(fsize) +"</b> Archivo muy grande! <br />El archivo es muy grande, debe pesar menos de 512 KB.");
			return false
		}
				
		$('#submit-btn').hide(); //hide submit button
		$('#loading-img').show(); //hide submit button
		$("#output").html("");  
	}
	else
	{
		//Output error to older unsupported browsers that doesn't support HTML5 File API
		$("#output").html("Por favor actualice su browser, esta versión no posee las características necesarias!");
		return false;
	}
}


//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}



// Function to preview image after validation
$(function() {
$("#FileInput").change(function() {
$("#message").empty(); // To remove the previous error message
var file = this.files[0];
var imagefile = file.type;
var fsize = file.size;     
var match= ["image/jpeg","image/png","image/jpg"];
if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
{
$('#previewing').attr('src','');
$("#message").html("<p id='error'>Por favor seleccione un archivo de imagen valido</p>"+"<h4>Nota</h4>"+"<span id='error_message'>Solo jpeg, jpg y png permitidos</span>");
return false;
}
else
{
var reader = new FileReader();
reader.onload = imageIsLoaded;
reader.readAsDataURL(this.files[0]);
$("#message").html("<p id='error'>El tamaño del archivo es de :"+Math.round(fsize/1024)+" KB</p>");    
}
});
});
function imageIsLoaded(e) {
$("#FileInput").css("color","green");
$('#image_preview').css("display", "block");
$('#previewing').attr('src', e.target.result);
$('#previewing').attr('width', '150px');
};

$(function() {
$("#DocInput").change(function() {
$("#message").empty(); // To remove the previous error message
var file = this.files[0];
var docfile = file.type;
var fsize = file.size;
var match= ["image/jpeg","image/png","image/jpg","text/plain","application/pdf","application/msword","application/vnd.ms-excel"];
if(!((docfile==match[0]) || (docfile==match[1]) || (docfile==match[2]) || (docfile==match[3]) || (docfile==match[4]) || (docfile==match[5]) || (docfile==match[6])))
{
$("#message").html("<p id='error'>Por favor seleccione un archivo valido</p>"+"<h4>Nota</h4>"+"<span id='error_message'>Solo pdf, doc, xls, txt, jpeg, jpg y png permitidos</span>");
return false;
}
else
{
$("#message").html("<p id='error'>El tamaño del archivo es de :"+Math.round(fsize/1024)+" KB</p>");    
}
});
});
    
    
});