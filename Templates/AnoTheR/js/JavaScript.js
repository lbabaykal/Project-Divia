const Modal_Authorization = document.querySelector('.modal_authorization');
const Modal_Registration = document.querySelector('.modal_registration');


function HideAuthorization() {
	Modal_Authorization.classList.toggle("show-modal");
}

function HideRegistration() {
	Modal_Registration.classList.toggle("show-modal");
}

function ShowAuthorization() {
	$(".modal_authorization").load("/Login/TemplateAuthorization");
	Modal_Authorization.classList.toggle("show-modal");
}

function ShowRegistration() {
	Modal_Authorization.classList.toggle("show-modal");
	$(".modal_registration").load("/Login/TemplateRegistration");
	Modal_Registration.classList.toggle("show-modal");
}

let header = $('.header'),
	scrollPrev = 0;

$(window).scroll(function() {
	let scrolled = $(window).scrollTop();

	if ( scrolled > 50 && scrolled > scrollPrev ) {
		header.addClass('out');
	} else {
		header.removeClass('out');
	}
	scrollPrev = scrolled;
});

$('#menu-change').on("click", function(){
	$('#menu-active').toggle();
});
$('#search-change').on("click", function(){
	$('#search-active').toggle();
});











