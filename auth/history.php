<?

top('История');
$_SESSION['loader'] = 0;

?>

<script type="text/javascript">

function load_history() {


	$.get( '/loader', function ( data ) {

		

		if ( data == 'empty' )
			$('#space').text( 'История пуста' );
		
		else if ( data != 'end' )
			$('#space').append( data );



	} 

	);
}
	


$(document).ready(function() {

	load_history();


});


</script>



<button onclick="load_history()">Загрузить</button>

<div id="space"></div>

<? bottom() ?>