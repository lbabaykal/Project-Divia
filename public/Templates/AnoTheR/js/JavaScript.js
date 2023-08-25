const Modal_Authorization = document.querySelector('.modal_authorization');
const Modal_Registration = document.querySelector('.modal_registration');
const Modal_Recovery_Password = document.querySelector('.modal_recovery_password');


function HideAuthorization() {
	Modal_Authorization.classList.toggle("show-modal");
}

function HideRegistration() {
	Modal_Registration.classList.toggle("show-modal");
}

function HideRecovery_Password() {
	Modal_Recovery_Password.classList.toggle("show-modal");
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

function ShowRecovery_Password() {
	Modal_Authorization.classList.toggle("show-modal");
	$(".modal_recovery_password").load("/Login/TemplateRecoveryPassword");
	Modal_Recovery_Password.classList.toggle("show-modal");
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