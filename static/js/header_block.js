// JavaScript Document

/*
Подключается в заголовки страниц.
Скрипт предназначен для разворачивания/сворачивания текста при нажатии на ссылку "Подробнее".
*/

$(document).ready(function () {
	<!-- СКРИПТ ДЛЯ ПОЯВЛЕНИЯ ТЕКСТА ПРИ НАЖИМАНИИИ НА ССЫЛКУ "ПОДРОБНЕЕ" -->
	$('.t73_text').addClass('t73_js_text');
	
	$('.t73_js_detalis_link').toggle(function() {
		$(this).closest('.t73_js_text').find('.t73_js_text_2').show(1000);
		$(this).html('свернуть');  
	}, function() {
		$(this).closest('.t73_js_text').find('.t73_js_text_2').hide(1000);
		$(this).html('подробнее');
	});
	<!-- СКРИПТ ДЛЯ ПОЯВЛЕНИЯ ТЕКСТА ПРИ НАЖИМАНИИИ НА ССЫЛКУ "ПОДРОБНЕЕ" -->
});