<script type="text/javascript">
function inicializar() {
	if (GBrowserIsCompatible()) {
	var map = new GMap2(document.getElementById("map"));  
	map.setCenter(new GLatLng(-33.43795,-70.603627), 15);  
	map.addControl(new GMapTypeControl());  
	map.addControl(new GLargeMapControl());  
	map.addControl(new GScaleControl());  
	map.addControl(new GOverviewMapControl());  
	//map.addOverlay(new GMarker(new GLatLng(-33.43795,-70.603627)));  
	  
	function informacion(ubicacion, descripcion) {	  
		var marca = new GMarker(ubicacion);  
		GEvent.addListener(marca, "click", function() {
		marca.openInfoWindowHtml(descripcion); } );  
		return marca;	  
	}  
	  
	var ubicacion = new GLatLng(-33.43795,-70.603627);  
	var descripcion = '<b>Texto ejemplo</b><br/>Para tutorial de CLH<br />';  
	var marca = informacion(ubicacion, descripcion);  
	  
	map.addOverlay(marca);  
	  
	}  
} 
</script>