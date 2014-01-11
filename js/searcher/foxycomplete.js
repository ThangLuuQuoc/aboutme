// JavaScript Document
(function($) {
	$(document).ready(function() {

		$( '#s' ).each( function(){
		$(this).attr( 'title', $(this).val() )
		  .focus( function(){
			if ( $(this).val() == $(this).attr('title') ) {
			  $(this).val( '' );
			}
		  } ).blur( function(){
			if ( $(this).val() == '' || $(this).val() == ' ' ) {
			  $(this).val( $(this).attr('title') );
			}
		  } );
		} );

		$('input#s').result(function(event, data, formatted) {
			$('#result').html( !data ? "No match!" : "Selected: " + formatted);
		}).blur(function(){		
		});
		
		$(function() {		
		function format(mail) {
			return "<a href='"+mail.permalink+"'><img src='" + mail.image + "' /><span class='title'>" + mail.title +"</span></a>";			
		}
		
		function link(mail) {
			return mail.permalink
		}

		function title(mail) {
			return mail.title
		}
		
		$.ajaxSetup({ type: "post" });

		$("#s").autocomplete(window.location.protocol + '//' + window.location.host + "/getDataSearcher.php", {
			extraParams: {verifiedCheck: true},
			minChars: 2,
			width: 290,
			max: 5, /** máxima cantidad de resultados a mostrar */
			scroll: false, /** para mostrar o no el scroll en los resultados de búsqueda */
			dataType: "json",
			matchContains: "word",
			parse: function(data) {
				return $.map(data, function(row) {
					return {
						data: row,
						value: row.title,
						result: $("#s").val()
					}
				});
			},
			formatItem: function(item) {				
				return format(item);
			}
			}).result(function(e, item) {
				$("#s").val(title(item));
				location.href = link(item);
			});						
		});
				
	});
})(jQuery);