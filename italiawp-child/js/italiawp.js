jQuery(document).ready(function($){
	'use strict';
	$(document).delegate('.em-calnav', 'click', function(){
    	var parametri = $(this).attr('data-valori').split("&");
    	var DatiParametri=$("#Parametri").val();
         $.ajax({type: 'POST',
	        url: ajaxurl, 
	        cache: false,
	        data:{
	            security:ajaxsec,
	            action:'CalendarioMese',
	            mese:parametri[0],
	            anno:parametri[1],
	            parametri:DatiParametri,
	        },
	        beforeSend: function() {
	        	$("#loading").fadeIn('fast');
	        },
	        success: function(risposta){
	        	$("#loading").fadeOut('slow');
	            $("#CalendarioEventi").html(risposta);
	        },
	        error: function(error) { 
	        	$("#loading").fadeOut('slow');
			},                   
	    });
	});
});     