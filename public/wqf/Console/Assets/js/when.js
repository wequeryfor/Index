// instanciate new modal
var modal = new tingle.modal({
    footer: false,
    stickyFooter: false,
    closeLabel: "Fechar"
});

// set content
function showModal(el){
	html = $(el).html();
	modal.setContent(html);
	modal.open();
}

var menuOpen = 0;

function toggleMenuCanvas(event){
	
	main = $('main');
	keyClass = 'out-menu';
	
	if(main.hasClass(keyClass)){
		main.removeClass(keyClass);
	} else {
		main.addClass(keyClass);
	}

	menuOpen++;

}


$(window).on('load', function(){
	$('.main > .main-content-in').on('click', function(){
		if(menuOpen == 1){
			menuOpen++;
		} else if(menuOpen == 2){
			toggleMenuCanvas();
			menuOpen = 0;
		}
	});
});