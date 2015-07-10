// JavaScript Document

$(document).ready(function () {

	/*
	t118_js_button_and_message - блок с кнопкой, по которой открывается сообщение, и самим сообщением
	t118_js_message_button - кнопка, по которой должно открываться сообщение
	t118_js_message_block - блок с сообщением, которое должно открываться при нажатии на кнопку
	t118_js_close_button - кнопка внутри блока с сообщением, при нажатии на которую оно должно закрываться
	*/

	$('.t118_js_message_button').live('click', function(){
		$(this).closest('.t118_js_button_and_message').addClass('t118_js_open_message');
	});

	$('.t118_js_close_button').live('click', function(){
		$(this).closest('.t118_js_button_and_message').removeClass('t118_js_open_message');
	});

});