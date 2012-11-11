/* 
 * Create HTML5 elements for IE's sake
 * Reference: http://ejohn.org/blog/html5-shiv/
 * Reference: http://remysharp.com/2009/01/07/html5-enabling-script/
 */
 
$(document).ready(function() {
if(!Modernizr.input.placeholder){
	$('[placeholder]').focus(function() {
	  var input = $(this);
	  if (input.val() == input.attr('placeholder')) {
		input.val('');
		input.removeClass('placeholder');
	  }
	}).blur(function() {
	  var input = $(this);
	  if (input.val() == '' || input.val() == input.attr('placeholder')) {
		input.addClass('placeholder');
		input.val(input.attr('placeholder'));
	  }
	}).blur();
	$('[placeholder]').parents('form').submit(function() {
	  $(this).find('[placeholder]').each(function() {
		var input = $(this);
		if (input.val() == input.attr('placeholder')) {
		  input.val('');
		}
	  })
	});
}
});	


var e = ("abbr,article,aside,audio,canvas,datalist,details,figure,footer,header,hgroup,mark,menu,meter,nav,output,progress,section,time,video").split(',');
for (var i=0; i<e.length; i++) {
document.createElement(e[i]);
 }