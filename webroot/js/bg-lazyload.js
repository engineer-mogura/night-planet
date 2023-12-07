
/*--------------------------------------------------------------------------
	
	Script Name    : Background Image Lazyload
	Author         : FIRSTSTEP - Motohiro Tani
	Author URL     : https://www.1-firststep.com
	Create Date    : 2023/04/20
	Version        : 1.0
	Last Update    : 2023/04/20
	
--------------------------------------------------------------------------*/


function bg_lazyload() {
	
	let element = document.querySelectorAll( '.bg-lazyload' );
	
	if ( element.length === 0 ) {
		return;
	}
	
	
	for ( let i = 0; i < element.length; i++ ) {
		element[i].classList.remove( 'bg-lazyload' );
		element[i].classList.add( 'bg-lazyloaded' );
	}
	
}




window.addEventListener( 'load', function() {
	bg_lazyload();
}, false );