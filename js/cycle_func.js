$(function(){
  $("#slide ul").cycle({
        fx:'fade',
		speed: 1000,
		timeout: 3000,
		//prev: '.anterior',
		//next: '.proximo', 
		pager:'.paginador-slider', 
		fastOnEvent: true
  });	   
});