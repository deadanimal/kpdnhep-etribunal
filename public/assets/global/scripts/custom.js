// $("input, textarea, option").addClass('uppercase');

// $("input, textarea, option").each(function() {
	
// 	if($(this).attr('id')) {
// 		if($(this).attr('id').indexOf('username') != -1 || $(this).attr('id').indexOf('pass') != -1 || $(this).attr('id').indexOf('email') != -1) {
// 			$( this ).removeClass('uppercase');
// 		}
// 	}
// 	if($(this).attr('unupper')) {
// 		if($(this).attr('unupper') == 'unUpper') {
// 			$( this ).removeClass('uppercase');
// 		}
// 	}
	
// });

$("input[type='text'], textarea, option").on('change', function(){

	if( $(this).attr('id').indexOf('username') != -1 || $(this).attr('id').indexOf('pass') != -1 || $(this).attr('id').indexOf('email') != -1 || $(this).attr('id').indexOf('emel') != -1 ) {
		this.value = this.value;
		//console.log('not upper');
	}
	else if($(this).attr('unupper') == 'unUpper') {
		this.value = this.value;
	}
	else if(window.location.href.indexOf("admin/master") > -1) {
       this.value = this.value;
    }
	else {
    	this.value = this.value.toUpperCase();
	}

	if( $(this).attr('id').indexOf('phone') != -1) {
		$(this).attr('maxlength', 15);
	}

});

// Phone number and postcode
$('.numeric').on('keydown', function(e){
	-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()
});

$(".numeric").each(function() {
	
	if($(this).attr('id')) {
		if($(this).attr('id').indexOf('postcode') != -1) {
			$( this ).attr('maxlength', '5');
		}
	}
	
});

$('.decimal').keypress(function(event) {
	//console.log(event);
	if ( event.which != 8 && event.which != 0 && (event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
		event.preventDefault();
	}
});

$('.toWord').html("");

$(".tabbable-line > .nav-tabs > li").css("background-color", "#f3f8f8 !important");
$(".tabbable-line > .nav-tabs > li.active").css("background-color", "#daecee !important");

var myBlockui = function () {
	console.log('bui open')
	$.blockUI({ message: '<div class="blockui">\n' +
			'    <div class="boxes">\n' +
			'    <div class="box">\n' +
			'        <div></div>\n' +
			'        <div></div>\n' +
			'        <div></div>\n' +
			'        <div></div>\n' +
			'    </div>\n' +
			'    <div class="box">\n' +
			'        <div></div>\n' +
			'        <div></div>\n' +
			'        <div></div>\n' +
			'        <div></div>\n' +
			'    </div>\n' +
			'    <div class="box">\n' +
			'        <div></div>\n' +
			'        <div></div>\n' +
			'        <div></div>\n' +
			'        <div></div>\n' +
			'    </div>\n' +
			'    <div class="box">\n' +
			'        <div></div>\n' +
			'        <div></div>\n' +
			'        <div></div>\n' +
			'        <div></div>\n' +
			'    </div>\n' +
			'</div>\n' +
			'</div><h1>Processing...</h1><p>Please do not refresh or close your browser.</p>',
		baseZ: 11000
	});
}
