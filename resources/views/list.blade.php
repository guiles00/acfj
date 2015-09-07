<html>
<script src="jquery.js"></script>
<script type="text/javascript">

$(document).ready(function(){
    $("#create").click(function(){
		        
		$.get( "./crea", function( data ) {
		  $( ".result" ).html( data );
		  console.log( "Load was performed." );
		});	
    });
});
	//trae algo con el get
$.get( "./accion", function( data ) {
  $( ".result" ).html( data );
  console.log( "Load was performed." );
});	

</script>
<body>
Aprendete mejor laravel
<div class="result"></div>
<input id="create" value="manda" type="button"></input>
</body>
</html>