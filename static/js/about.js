// JavaScript Document

/* Подключается на страницы "О компании" - 
русскую http://komus.ru/pages/about/ 
и английскую http://komus.ru/pages/about_en/ версии.
Скрипт предназначен для открывания/закрывания блоков с годами в колонке "Комус" в датах".
*/

$(document).ready(function () {

	/* ПЕРЕМЕННЫЕ */
	/* текущая картинка с выбранным годом */
	var t96_js_year_img_current;
	
	/* СОБЫТИЯ ПРИ ЗАХОДЕ НА СТРАНИЦУ */
	/* скроем все блоки, кроеме первого */
	$(".t96_js_years_ul .t96_js_pozitif_info_ul:not(:first)").hide();
	/* сделаем картинку-заголовок первого блока красной */
	t96_js_year_img_current = $(".t96_js_years_ul .t96_js_year_img:first");
	replase_years_ul_img_path ('on_red');
	
	/* ФУНКЦИИ */
	/* функция - меняет путь к картинке-заголовку блока */
	/* первый аргумент - объект-картинка (object_img),
	второй аргумент - способ замены (on_what) (on_red - заголовок должен стать красным ; on_gray - заголовок должен стать серым) */
	function replase_years_ul_img_path (on_what) {
		/* вынимаем путь к картинке */
		var katalog_img_path = t96_js_year_img_current.attr('src');
		/* меняем его на новый */
		if (on_what == 'on_red') {
			var katalog_img_path_new = katalog_img_path.replace(/gray/,'red');
		};
		if (on_what == 'on_gray') {
			var katalog_img_path_new = katalog_img_path.replace(/red/,'gray');
		};
		/* присваиваем новый путь */
		t96_js_year_img_current.attr('src',katalog_img_path_new);
	}
	
	/* РЕАКЦИЯ НА ДЕЙСТВИЯ ПОЛЬЗОВАЛЕТЯ */
	$('.t96_js_year_img').click(function(){
		/* сделаем серой картинку-заголовок предыдущего выбранного года */
		if (t96_js_year_img_current) {
			replase_years_ul_img_path ('on_gray');
		};
		/* сделаем красной картинку-заголовок выбранного года */
		t96_js_year_img_current = $(this);
		replase_years_ul_img_path ('on_red');
		/* скроем предыдущий видимый блок */
		$('.t96_js_pozitif_info_ul:visible').slideUp("slow");
		/* откроем выбранный блок */
		$(this).closest('li').find('.t96_js_pozitif_info_ul').slideDown("slow");
	});

});