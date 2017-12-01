$(document).ready(function() {
	main();
});

function main(){
  $('button').on('click', function(event){
    if ($('#hello').hasClass('blue')){
		$('#hello').removeClass('blue');
		$('#hello').addClass('yellow');
	} else {
		$('#hello').removeClass('yellow');
		$('#hello').addClass('blue');
	}
  });
}