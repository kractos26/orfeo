jQuery.noConflict();
// Contador para la cantidad de archivos subidos.
var fileCountSize = 0;
// Limite para la cantidad de archivos que se pueden subir.
var fileCountLimit = 100;
// Cantidad de archivos subidos.
var addedFiles = 0;
// Limite de subida de los archivos, en total.
var fileLimit = 10*1024*1024;
// Arregloq ue contiene los archivos subidos.
var fileNamesTmpDir  = new Array();
var uploader;

/**
 * Converts the given data structure to a JSON string. Argument: arr - The data
 * structure that must be converted to JSON Example: var json_string =
 * array2json(['e', {pluribus: 'unum'}]); var json =
 * array2json({"success":"Sweet","failure":false,"empty_array":[],"numbers":[1,2,3],"info":{"name":"Binny","site":"http:\/\/www.openjs.com\/"}});
 * http://www.openjs.com/scripts/data/json_encode.php
*/
function array2json(arr) {
    var parts = [];
    var is_list = (Object.prototype.toString.apply(arr) === '[object Array]');

    for(var key in arr) {
    	var value = arr[key];
        if(typeof value == "object") { // Custom handling for arrays
            if(is_list) parts.push(array2json(value)); /* :RECURSION: */
            else parts[key] = array2json(value); /* :RECURSION: */
        } else {
            var str = "";
            if(!is_list) str = '"' + key + '":';

            // Custom handling for multiple data types
            if(typeof value == "number") str += value; // Numbers
            else if(value === false) str += 'false'; // The booleans
            else if(value === true) str += 'true';
            else str += '"' + value + '"'; // All other things
            // :TODO: Is there any more datatype we should be in the lookout
			// for? (Functions?)

            parts.push(str);
        }
    }
    var json = parts.join(",");
    
    if(is_list) return '[' + json + ']';// Return numerical JSON
    return '{' + json + '}';// Return associative JSON
}


// JavaScript Document
function trae_municipio() {
	var url = "municipio.php";
	var pars = "depto=" + document.quejas.depto.value;
	var ajax = new Ajax.Request(url, {
		asynchronous : false,
		parameters : pars,
		method : "get",
		onComplete : procesaRespuesta});
	function procesaRespuesta(resp) {
		document.getElementById("div-contenidos").innerHTML = resp.responseText;
	}
}

// Validacion captcha en JavaScript
// @author Sebastian Ortiz V.

function validar_captcha() {
	var url = "captcha.php";
	var valido = false;
	var pars = "captcha="
			+ document.getElementById('captcha').value;
	var ajax = new Ajax.Request(url, {
		// Cuando es sincrono _NO_ se ejecutan los callbacks
		asynchronous : false,
		parameters : pars,
		method : "post",		
		// onComplete : procesaRespuesta
	});
        
	function procesaRespuesta(resp) {
		var text = resp.responseText;
		// alert(text);
		if (text == "true") {
			valido = true;
		} else {
			valido = false;
		}

	}
	procesaRespuesta(ajax.transport);
	return valido;
}

// Recargar captcha por JS
// @author Sebastian Ortiz V.

function recargar_captcha() {
	var url = "captcha.php";
	var src = "";
	var pars = "recargar=si";
	var ajax = new Ajax.Request(url, {
		// Cuando es sincrono _NO_ se ejecutan los callbacks
		asynchronous : false,
		parameters : pars,
		method : "post",		
		// onComplete : procesaRespuesta
	});
	function procesaRespuesta(resp) {
		var text = resp.responseText;	
		src = text;

	}
	procesaRespuesta(ajax.transport);
	return src;
}

function reloadImg(id) {
	   var obj = document.getElementById(id);
	   obj.src = recargar_captcha();
	   return false;
	}


// Validacion segun tipo de solicitud, tipo de documento y con captcha
// @author Sebastian Ortiz V.

function valida_form() {

	var mensaje = "";
	var error = 0;
        jQuery('textarea:required:invalid').focus();
        jQuery('select:required:invalid').focus();
        jQuery('input:required:invalid').focus();
//     
//        if (document.getElementById('captcha').value != document.getElementById('capchta2').value)
//        {
//			mensaje += '\n-Código de verificación inválido.';
//			error = 1;
//        }
//	 
	// Agregar las direcciones de los archivos subidos
	document.getElementById("adjuntosSubidos").value =JSON.stringify(fileNamesTmpDir);
       
//	if (error == 1) {
//		alert(mensaje);
//		return false;
//	} else if (error == 2) {
//		alert(mensaje)
//		return true;
//	} else {
//		return true;
//	}
}

function pasa_nit() {
	var i
	for (i = 0; i < document.busqueda.nit.length; i++) {
		if (document.busqueda.nit[i].checked)
			break;
	}
	valor_nit = document.busqueda.nit[i].value;
	window.opener.document.quejas.nit.value = valor_nit;
	window.opener.trae_entidad();
	window.close();

}

// validacion caracteres

/*
 * <input type="text" onkeypress="return alpha(event,numbers)" /> <input
 * type="text" onkeypress="return alpha(event,letters)" /> <input type="text"
 * onkeypress="return alpha(event,numbers+letters+signs)" />
 */

var letters = ' ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyzáéíúü\u0008'
var numbers = '1234567890 \u0008'
var signs = ',.:;@-\''
var mathsigns = '+-=()*/'
var custom = '<>#$%&?	'

function alpha(e, allow) {
	var k;
	k = document.all ? parseInt(e.keyCode) : parseInt(e.which);
	return (allow.indexOf(String.fromCharCode(k)) != -1 || e.keyCode == 9);
}

function alphaField(e, allow) {
	var k;
	r = true;
	for ( var i = 0; i < e.length; i++) {
		if (allow.indexOf(e.charAt(i)) == -1)
			return false;
	}
	return r;
}

// validacion email
// http://stackoverflow.com/questions/46155/validate-email-address-in-javascript
function isEmailAddress(theElement) {
	var s = theElement.value;	
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	if (s.length == 0)
		return true;
	if (re.test(s))
		return true;
	else
		return false;
}

// Adicion de campos para adjuntos
// @author Sebastian Ortiz V.

function addInputFile() {
	var container = document.getElementById('adjuntos');
	var mpo = document.getElementById('campo_adjuntos');
	var pf = document.createElement('p');
	var ifile = document.createElement('input');
	ifile.type = 'file';
	ifile.name = 'userfile[]';
	ifile.id = 'campo_adjuntos';
	ifile.onchange = campo.onchange;
	// ifile.class ='large';
	pf.appendChild(ifile);
	container.appendChild(pf);
}


function checkAnonimo(){
	var anonimo = document.getElementById('chkAnonimo');
	if(anonimo.value==1){
		disableElementById('li_tipoDocumento');
		disableElementById('li_numeroDocumento');
		disableElementById('li_nombre');
		disableElementById('li_apellido');
		disableElementById('li_pais');
		disableElementById('li_departamento');
		disableElementById('li_municipio');
		disableElementById('li_direccion');
		disableElementById('li_telefono');
//                disableElementById('li_upload');
//		disableElementById('li_medioRespuesta');
		
		jQuery('#lbl_email').html('E-mail');		
		return true;

	}else{
		enableElementById('li_tipoDocumento');
		enableElementById('li_numeroDocumento');
		enableElementById('li_nombre');
		enableElementById('li_apellido');
		enableElementById('li_pais');
		enableElementById('li_departamento');
		enableElementById('li_municipio');
		enableElementById('li_direccion');
		enableElementById('li_telefono');
//                enableElementById('li_upload');
//		enableElementById('li_medioRespuesta');
		
		
		jQuery('#lbl_email').html('E-mail <font color="#FF0000">*</font>');
		return false;

	}
}

function cambia_pais(){
	var pais =  document.getElementById('slc_pais');
	if (pais.value != 170){
		disableElementById('slc_depto');
		disableElementById('slc_municipio');
	}else if (pais.value == 170){
		enableElementById('slc_depto');
		enableElementById('slc_municipio');
	}
}

function disableElementById(idElement){
	jQuery('#'+idElement).hide();
}

function enableElementById(idElement){
	
	jQuery('#'+idElement).show();
}

function toggleVisibility(controlId)
{
	if(jQuery('#'+controlId).is(":visible")){
		jQuery('#'+controlId).hide();
	}else{
		jQuery('#'+controlId).show();
	}
}

function countChar(val){
    var len = val.value.length;
    if (len >= 2000) {
        val.value = val.value.substring(0, 2000);
    }else {
    	jQuery("#charNum").html("C&aacute;rcteres disponibles: <b>"+ (2000-len) + "</b>");
    }
};

function createUploader() {
    
uploader = new qq.FineUploader({
   
element: $('filelimit-fine-uploader'),
request: {
endpoint: 'qqUploadedFileXhr.class.php',
},
multiple: true,
validation: {
	sizeLimit: 5*1024*1024// 5.0MB = 5 * 1024 kb * 1024 bytes
	},
	 text: {
		uploadButton: '<img src="images/PaperClic.png" width="60px" class="icon-upload icon-white">'
		},
	autoUpload : true,
    callbacks: {
	    onSubmit: function(id, fileName) {	    
	    if((fileCountSize + uploader._handler._files[id].size) > fileLimit) {
	    	jQuery('.qq-upload-button').hide();
	    	jQuery('.qq-upload-drop-area').hide();
		alert('Solo archivos: .pdf .jpg .png <br>El tamaño máximo permitido de subida de todos los archivos es de ' + uploader._formatSize(fileLimit));		
                 
            return false;
	    }
	    fileCountSize += uploader._handler._files[id].size;
	    },
	    onCancel: function(id, fileName) {
	    	try{
	    	if(jQuery.isNumeric(uploader._handler._files[id].size)){
	    	fileCountSize -= uploader._handler._files[id].size;
	    	}
	    	}catch(error){
	    		//Debe ser que estamos en explorer
	    	}
	    	var index = fileNamesTmpDir.indexOf(fileName);
	    	if(index>=0){
	    		addedFiles--;
	    		fileNamesTmpDir.splice(index,1);
	    		//Prevenir sacar el mensaje de archivos en progreso, cuando se hace un cancel manual.
	 		   uploader._filesInProgress++;
	    	}
	    		    	
	    if(fileCountSize <= fileLimit) {
	    	jQuery('.qq-upload-button').show();
	    }
		   jQuery('#availabeForUpload').html('Solo archivos: .pdf .jpg .png <br>Tama&ntilde;o m&aacute;ximo por archivo de 5.0MB. Disponible ' +  uploader._formatSize(fileLimit-fileCountSize) );
		   
	    },
	    onComplete: function(id, fileName, responseJSON) {
	    if (responseJSON.success) {
	    fileNamesTmpDir.push(fileName);
	    addedFiles ++;
	   jQuery('#availabeForUpload').html('Solo archivos: .pdf .jpg .png <br>Tama&ntilde;o m&aacute;ximo por archivo de 5.0MB. Disponible ' +  uploader._formatSize(fileLimit-fileCountSize) );
	    if(addedFiles >= fileCountLimit) {
	    	alert('Has alcanzado la cantidad m&aacute;xima de archivos a subir, no podr&aacute;s subir m&aacute;s de ' + fileCountLimit + ' archivos.');
	    	jQuery('.qq-upload-button').hide();
	    	jQuery('.qq-upload-drop-area').hide();
	    }
	    }else{
	    	alert('Solo archivos: .pdf .jpg .png <br>Ocurrio un error subiendo el archivo. Por favor valida que no supere los 5.0MB y en total 10.0MB');
	    }
	    },
	    onError: function(id, fileName, errorReason) {
	    	alert('Solo archivos: .pdf .jpg .png <br>Ocurrio un error subiendo el archivo.' + errorReason);
               
	    },
	},

});
jQuery('#availabeForUpload').html('Solo archivos: .pdf .jpg .png <br>Tamaño Máximo Disponible ' +  uploader._formatSize(fileLimit-fileCountSize));
}



