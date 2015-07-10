// JavaScript Document

/* 
* Подключается в шапке сайта.
* Функции для открывания новых окон (Доставка и Оплата). 
*/

/* Окно с информацией о доставке (страница /pages/delivery/) */
function delivery_window_open () {
	window.open('/pages/delivery/', 'Delivery', 'scrollbars=yes, status=no, toolbar=no, location=no, menubar=no, width=360, height=750');	
}

/* Окно с информацией об оплате (страница /pages/pay/) */
function pay_window_open () {
	window.open('/pages/pay/', 'Pay', 'scrollbars=yes, status=no, toolbar=no, location=no, menubar=no, width=360, height=750'); 
}

/* Окно "Гарантии и возврат товара" (страница /pages/guarantees/) */
function guarantees_window_open () {
	window.open('/pages/guarantees/', 'Guarantees', 'scrollbars=yes, status=no, toolbar=no, location=no, menubar=no, width=774, height=750'); 
}

