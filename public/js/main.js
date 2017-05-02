$( function() {
	// banner 轮播
	( function() {
		var timeIn = setInterval( function() {
			$( '.c-banner__turn-two' ).removeClass('scale-in').addClass( 'scale-out' );
			$( '.c-banner__turn-one' ).removeClass( 'scale-out' ).addClass( 'scale-in' );
		}, 6000 );
		var timeOut = setInterval( function() {
			$( '.c-banner__turn-two' ).removeClass( 'scale-out' ).addClass( 'scale-in' );
			$( '.c-banner__turn-one' ).removeClass('scale-in').addClass( 'scale-out' );
		}, 12000 );
	} )();

	// 初始化 Swiper
	( function() {
		var swiper = new Swiper( '.swiper-container', {
	        pagination: '.swiper-pagination',
	        nextButton: '.swiper-button-next',
	        prevButton: '.swiper-button-prev',
	        slidesPerView: 1,
	        paginationClickable: true,
	        autoplay: 4000,
	        loop: true
	    } );

	    var swiper = new Swiper('.swiper-container2', {
	        pagination: '.swiper-pagination2',
	        slidesPerView: 2,
	        paginationClickable: true,
	        spaceBetween: 30,
	        freeMode: true
	    });
	} )();

	// scroll function
	( function() {

		var wow = new WOW( {
			offset: 100
		} );
		wow.init();

		$( '.scroll-btn ').on( 'click',function( ev ) {
			
			var $this = $( this );
			var anchor = '#' + $this.data( 'scroll' );
			var destination = $( anchor ).offset().top;
			
			$( 'html,body' ).animate( { scrollTop: destination}, 700 );
			return false;
		} );

		// back to top
		$( '.o-to-top' ).hide();
		$( window ).scroll( function() {
			if( $( window ).scrollTop()<500 ) {
				$( '.o-to-top' ).addClass( 'wow bounceInLeft' ).fadeOut( 500 );
			} else {
				$( '.o-to-top' ).removeClass( 'wow bouceInRight' ).show();
			}
		} );

	} )();
	
} );