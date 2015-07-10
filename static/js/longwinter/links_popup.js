/**
 *  Для ссылок "Оплата" и "Доставка" будем открывать контент в  новом окне.
 *  
 */
$(document).ready(function () {
	
	// Оплата
	$('a[href="' + dpath_www + '/pages/pay/' + '"]').on("click", function(eventObject) {
		// отменяем переход по ссылке
		eventObject.preventDefault();
		// открываем окно
		window.open(dpath_www + '/pages/pay/', 'Pay', 'scrollbars=yes,status=no,toolbar=no,location=no,menubar=no,width=360,height=750');
	});
	
	// Доставка
	$('a[href="' + dpath_www + '/pages/delivery/' + '"]').on("click", function(eventObject) {
		// отменяем переход по ссылке
		eventObject.preventDefault();
		// открываем окно
		window.open(dpath_www + '/pages/delivery/', 'Delivery', 'scrollbars=yes,status=no,toolbar=no,location=no,menubar=no,width=360,height=750');
	});
	
});