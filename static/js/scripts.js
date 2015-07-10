




<script type="text/javascript">
(function($) {
    
	Popup = {
        // блок с контентом, который нужно открыть
		window_content: null,
		// параметры
        options: {
            block_class: 'popup_js', // класс главного родительского блока с окном
			block_open_class: 'popup--m-open', // класс, который делает блок видимым
			block_fixed_class: 'popup--m-fixed', // класс, который определяет фиксированное позиционирование окна
			window_class: 'popup--window_js', // класс самого окна
			window_top: 45, // величина отступа окна от верхнего края экрана (на тот случай, когда высота окна больше высоты экрана)
			button_close_class: 'popup--close_js' // класс кнопки "Закрыть"
        },
                
        init: function(window_content, options) {
            // блок с контентом, который нужно открыть
			this.window_content = window_content;
			// параметры
            $.extend(this.options, options);
			// если блок с контентом на странице есть
			if ( window_content.size() == 1 ) {			
				// открываем и позиционируем блок
				this.show_block(this.window_content, this.options);
				// закрываем окно при нажатии на кнопку "Закрыть"
				this.close_block(this.window_content, this.options);
			};
        },
		
		// открываем и позиционируем блок
		show_block: function (window_content, options) {
			
			// найдем главный родительский блок с окном 
			block = window_content.closest('.' + options.block_class);
			// покажем окно
			block.addClass(options.block_open_class);
			// блок с всплывающем окном, который будем позиционировать по центру экрана
			window_block = block.find('.' + options.window_class);			
			
			// позиционируем окно по центру экрана по горизонтали
				// зададим ширину блока со всплывающим окном
				window_border_width = parseInt (window_content.css('border-left-width')) + parseInt (window_content.css('border-right-width'));
				window_padding_width = parseInt (window_content.css('padding-left')) + parseInt (window_content.css('padding-right'));
				window_margin_width = parseInt (window_content.css('margin-left')) + parseInt (window_content.css('margin-right'));
				window_block.width( window_content.width() + window_border_width + window_padding_width + window_margin_width );
			
			// если позиционирование окна не должно быть фиксированным - 
			// позиционируем окно по центру или по верху экрана по вертикали
			if (! block.hasClass(options.block_fixed_class)) {
				// высота прокрученной сверху части страницы
				browser_top = $(window).scrollTop();
				// высота экрана
				screen_height = $(window).height();				
				// высота всплывающего окна
				window_height = window_block.height();
				// посчитаем отступ сверху от края экрана
					// если высота окна меньше высоты экрана
					if (window_height < screen_height) {
						// позиционируем блок по центру по вертикали
						// величина отсупа окна сверху от начала страницы
						window_top = browser_top + ((screen_height - window_height) / 2);
					}
					// если высота окна больше высоты экрана
					else {
						// позиционируем блок по верхнему краю экрана с отступом options.window_top
						// величина отсупа окна сверху от начала страницы
						window_top = browser_top + options.window_top;
					};
				
				// позиционируем окно
				window_block.css({'margin-top' :  window_top + 'px'});
			};			
		},
		
		// закрываем окно при нажатии на кнопку "Закрыть"
		close_block: function (window_content, options) {			
			// при нажимании на кнопку закроем окно		
			$(document).on("click", "." + options.button_close_class, function(eventObject) {			
				// не будем переходить по ссылке
				eventObject.preventDefault();
				$(this).closest('.' + options.block_class).removeClass(options.block_open_class);
				// очистим класс у блока, который определяет набор стилей для печати
				if (function_exists ('media_print_skin_clear')) {
					media_print_skin_clear ();
				};
			});
		},
		
		// функция закрывания окна
		// может вызываться в скрипте, который относится к содержимому окна например так 
		// Popup.close($(this)); или Popup.close(_this.block); или Popup.close(block);
		// параметром передается главный блок с контентом окна
		// используется например в message-bug_js.php для блока message-bug
		close: function (window_content) {
			window_content.closest('.' + Popup.options.block_class).removeClass(Popup.options.block_open_class);
			// очистим класс у блока, который определяет набор стилей для печати
			if (function_exists ('media_print_skin_clear')) {
				media_print_skin_clear ();
			};
		},
		
		// функция возвращает true, если окно открыто и false, если закрыто
		// может вызываться в скрипте, который относится к содержимому окна например так 
		// Popup.is_open($(this)) или Popup.is_open(_this.block) или Popup.is_open(block)
		// параметром передается главный блок с контентом окна
		// используется например в shops-remains_js.php для блока shops-remains
		is_open: function (window_content) {
			if (window_content.closest('.' + Popup.options.block_class).hasClass(Popup.options.block_open_class)) {
				return true;
			}
			else {
				return false;
			};
		}
    }
	
	$.fn.popup = function() {	    	
		Popup.init($(this));		
	}
	
})(jQuery);
</script>



 



 

<script type="text/javascript">
$(window).load(function(){
	
	// form_fields_focus - функция для изменения вида полей формы в фокусе, находится в /static/js/longwinter/functions.js
	// $('.form-text--input-cin_js') - класс полей, вид которых должен меняться, когда они находятся в фокусе
	$('.form-text--input-cin_js').form_fields_focus({
		field_class: 'form-text--input-cin_js', // Класс поля формы, которое изменяет вид при нахождении в фокусе
		field_block_class: 'form-text_js', // Класс родительского для поля блока, которому нужно поменять класс, когда поле находится в фокусе
		focus_class: 'form-text--m-focus' // Класс, который нужно присвоить родительскому блоку field_block_class, когда поле находится в фокусе
	});
	
});	
</script>
 

<script type="text/javascript">
$(window).load(function(){
	
	// form_fields_focus - функция для изменения вида полей формы в фокусе, находится в /static/js/longwinter/functions.js
	// $('.form-textarea--textarea-cin_js') - класс полей, вид которых должен меняться, когда они находятся в фокусе
	$('.form-textarea--textarea-cin_js').form_fields_focus({
		field_class: 'form-textarea--textarea-cin_js', // Класс поля формы, которое изменяет вид при нахождении в фокусе
		field_block_class: 'form-textarea_js', // Класс родительского для поля блока, которому нужно поменять класс, когда поле находится в фокусе
		focus_class: 'form-textarea--m-focus' // Класс, который нужно присвоить родительскому блоку field_block_class, когда поле находится в фокусе
	});
	
});	
</script>


