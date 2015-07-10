/**
 *  Функция, которая позволит узнать, поддерживает ли браузер необходимый атрибут.
 *  element - элемент,
 *  attribute - атрибут.
 */
function element_supports_attribute(element, attribute) {
    var test = document.createElement(element);
    if(attribute in test) {return true;}
    else {return false;}
}



/**
 *  Функция для оформления подсказок в полях формы.
 *  Вызывается для формы, в которой есть подсказки в полях input и textarea (у элементов должен быть прописан пустой value="").
 *  В качестве параметров передаются значения fields_class и placeholder_class (описание их ниже).
 *  Текст подсказок прописывается в атрибутах title и placeholder полей input и textarea.
 *  Полям input и textarea, в которых есть подсказки, дается тот класс, который передается в параметр fields_class.
 *  Для класса, который передается в параметр placeholder_class прописывается стиль со светло-серым шрифтом для подсказок.
 */
/* Пример подключения функции 
<?php // Запускаем функцию ?>
<script type="text/javascript">
$(document).ready(function(){
	
	// form_whith_placeholder - функция для оформления подсказок в полях формы, находится в /js/longwinter/functions.js
	// $('.search-top--form_js') - класс формы, в полях input и textarea которой должны появляться комментарии
	$('.<?=$_s; ?>--form_js').form_whith_placeholder({
		fields_class: '<?=$_s; ?>--field-placeholder_js', // Класс полей input и textarea, в которых должны появляться подсказки
		placeholder_class: '<?=$_s; ?>--field-placeholder' // Класс, который присваивается полю на то время, пока в нем находится подсказка
	});
	
});
</script>
*/
(function($) {
    
	Form_whith_placeholder = {
        // форма
		form: null,
		// параметры
        options: {
            fields_class: 'field-placeholder_js', // Класс полей input и textarea, в которых должны появляться подсказки
			placeholder_class: 'field-placeholder' // Класс, который присваивается полю на то время, пока в нем находится подсказка
        },
        
        init: function(form, options) {
            // форма
			this.form = form;
			// параметры
            $.extend(this.options, options);
			// если свойство placeholder не поддерживается
			if (!element_supports_attribute('input', 'placeholder')) {			
				// сделаем подсказки в полях input и textarea
				this.fields_placeholder(this.form, this.options);
			};
        },
		
		// сделаем подсказки в полях input и textarea
		fields_placeholder: function (form, options) {
			
			// вынимаем имена классов
			var fields_class = options.fields_class;
			var placeholder_class = options.placeholder_class;
			
			// пройдем все формы с переданным классом
			form.each(function(){
				// пройдем все поля с подсказками в данной форме
				$(this).find('.' + fields_class).each(function(){
					// и пропишем подсказки в полях input и textarea
					if ($(this).attr('value') == ''  ||  $(this).attr('value') == $(this).attr('title')) {
						$(this).attr('value', $(this).attr('title'));
						$(this).addClass(placeholder_class);
					};			  
				});
			});		
			
			// убираем подсказку, если поле находится в фокусе
			form.find('.' + fields_class).focus(function(){
				if ($(this).val() == $(this).attr('title')) {
					$(this).attr('value', '');
					$(this).removeClass(placeholder_class);
				};		
			});	
			
			// заполним пустое поле подсказкой при потере фокуса
			form.find('.' + fields_class).blur(function(){
				if ($(this).val() == '') {
					$(this).attr('value', $(this).attr('title'));
					$(this).addClass(placeholder_class);
				};		
			});
			
			// при отправке формы очистим поля, заполненные подсказками
			form.submit(function(eventObject) {
				$('.' + fields_class).each(function(){
					if ($(this).val() == $(this).attr('title')) {
						$(this).attr('value', '');				
					};		
				});
			});
		}
    }
	
	$.fn.form_whith_placeholder = function(options) {	    	
		Form_whith_placeholder.init($(this), options);		
	}
	
})(jQuery);



/**
 *  Функция для изменения вида полей формы в фокусе.
 *  Вызывается для полей, которые должны изменять свой вид при нахождении в фокусе.
 *  В качестве параметров передаются значения field_class, field_block_class и focus_class (описание их ниже).
 */
/* Пример подключения функции 
<?php // Запускаем функцию ?>
<script type="text/javascript">
$(document).ready(function(){
	
	// form_fields_focus - функция для изменения вида полей формы в фокусе, находится в /js/longwinter/functions.js
	// $('.search-top--field-input_js') - класс полей, вид которых должен меняться, когда они находятся в фокусе
	$('.<?=$_s; ?>--field-input_js').form_fields_focus({
		field_class: 'field-input_js', // Класс поля формы, которое изменяет вид при нахождении в фокусе
		field_block_class: '<?=$_s; ?>--field_js', // Класс родительского для поля блока, которому нужно поменять класс, когда поле находится в фокусе
		focus_class: '<?=$_s; ?>--field-m-focus' // Класс, который нужно присвоить родительскому блоку field_block_class, когда поле находится в фокусе
	});
	
});
</script>
*/
(function($) {
$.fn.form_fields_focus = function(options) {
		
	var Form_fields_focus = {
        // поля формы
		fields: null,
		// параметры
        options: {
            field_class: 'field-input_js', // Класс поля формы, которое изменяет вид при нахождении в фокусе
			field_block_class: 'field_js', // Класс родительского для поля блока, которому нужно поменять класс, когда поле находится в фокусе
			focus_class: 'field-m-focus' // Класс, который нужно присвоить родительскому блоку field_block_class, когда поле находится в фокусе
        },
        
        init: function(fields, options) {
            // поля формы
			this.fields = fields;
			// параметры
            $.extend(this.options, options);
			
			var _this = this;			
						
			// присвоим класс, когда поле находится в фокусе
			// и уберем класс, когда поле теряет фокус
			this.field_focus(_this);			
        },	
		
		// присвоим класс, когда поле находится в фокусе
		// и уберем класс, когда поле теряет фокус
		field_focus: function (_this) {
			
			// поле в фокусе
			$(document).on('focus', '.' + _this.options.field_class, function() {			
				$(this).closest('.' + _this.options.field_block_class).addClass(_this.options.focus_class); 
			});
			
			// поле теряет фокус
			$(document).on('blur', '.' + _this.options.field_class, function() {			
				$(this).closest('.' + _this.options.field_block_class).removeClass(_this.options.focus_class); 
			});			
		}
    };
	
	
	Form_fields_focus.init($(this), options);		
}	
})(jQuery);



/**
 *  Функция для таймера обратного отсчета.
 *  На данный момент рассчитана на подсчет времени в пределах 24 часов, но может быть расширена.
 */
/* Пример подключения функции 
<?php // Запускаем функцию таймера обратного отсчета ?>
<script type="text/javascript">
$(document).ready(function(){                                                    
	// timer_countdown - функция для таймера обратного отсчета, находится в /js/longwinter/functions.js
	// $('#bargain-day--item-time-values-..._js') - блок, в котором должно меняться время (блок указывается по id)
	$('#<?=$_s; ?>--item-time-values-<?=$id; ?>_js').timer_countdown({
		time_left: <?=$item['time_left']; ?>, // общее количество секунд, которое осталась до конца работы таймера
		timer_label: '<?=$_s; ?>--item-time-values-<?=$id; ?>', // метка текущего таймера
		h_class: '<?=$_s; ?>--item-time-values-h_js', // класс для блока с количеством часов
		m_class: '<?=$_s; ?>--item-time-values-m_js', // класс для блока с количеством минут
		s_class: '<?=$_s; ?>--item-time-values-s_js' // класс для блока с количеством секунд
	});                                                    
});
</script>
*/
(function($) {
    
	Timer_countdown = {
        // блок, в котором должно меняться время 
		timer_block: null,
		// объект со временем для таймеров (для каждого таймера хранит метку времени, когда таймер должен перестать работать)
		timer_end: {},
		// параметры
        options: {
            time_left: 0, // общее количество секунд, которое осталась до конца работы таймера
			timer_label: 'timer-countdown-label', // метка текущего таймера
			h_class: 'timer-countdown-h_js', // класс для блока с количеством часов
			m_class: 'timer-countdown-m_js', // класс для блока с количеством минут
			s_class: 'timer-countdown-s_js' // класс для блока с количеством секунд
        },
        
        init: function(timer_block, options) {
            // блок, в котором должно меняться время
			this.timer_block = timer_block;
			// параметры
            $.extend(this.options, options);			
			// если блок с таймером один
			if (this.timer_block.size() == 1) {			
				// если передано ненулевое время - запускаем таймер
				if (this.options.time_left > 0) {
					// заполним значение объекта timer_end для данного таймера
					var date = new Date();
					var current_time = date.getTime();
					var timer_end = current_time + (this.options.time_left * 1000);
					Timer_countdown.timer_end[this.options.timer_label] = timer_end;
					// запускаем ежесекундный отсчет таймера
					this.timer_go(this.timer_block, this.options);
				};
			};
        },
		
		// запускаем ежесекундный отсчет таймера
		timer_go: function(timer_block, options) {			
			
			// вынем из объекта значение метки времени, когда должен перестать работать таймер
			var timer_end = Timer_countdown.timer_end[options.timer_label];
			// вынем метку таймера
			var timer_label = options.timer_label;
			// вынем имена классов для часов, минут и секунд
			var h_class = options.h_class;
			var m_class = options.m_class;
			var s_class = options.s_class;
			
			// запускаем таймер
			timer_block.everyTime(1000, timer_label, function() {				
				// найдем настоящее время
				var date = new Date();
				var current_time = date.getTime();
				// узнаем разницу между настоящим временем и тем, когда должен перестать работать таймер
				var time_left = timer_end - current_time; 
				
				// если время осталось
				if (time_left >= 0) {
					// считаем значения часов, минут и секунд, которые должны быть вписаны в таймер
					// и вписываем значения в блок таймера
					Timer_countdown.timer_calculation(timer_block, h_class, m_class, s_class, time_left);
				} 
				// если времени не осталось
				else {
					// остановим таймер
					timer_block.stopTime(timer_label);
					// обнулим таймер на всякий случай
					Timer_countdown.timer_calculation(timer_block, h_class, m_class, s_class, 0);
				};
			});			
        },
		
		// считаем значения часов, минут и секунд, которые должны быть вписаны в таймер
		// и вписываем значения в блок таймера
		timer_calculation: function(timer_block, h_class, m_class, s_class, time_left) {

			var time = new Date();			
			time.setTime(time_left);
			
			// считаем значения часов, минут и секунд
			var h = time.getUTCHours(); // часы
			var m = time.getMinutes(); // минуты
			var s = time.getSeconds(); // секунды
			
			// если значения однозначные - припишем в начале 0
			h = (h < 10) ? '0' + h : h;
			m = (m < 10) ? '0' + m : m;
			s = (s < 10) ? '0' + s : s;
			
			// вписываем значения в блок таймера
			timer_block.find('.' + h_class).html(h); // часы
			timer_block.find('.' + m_class).html(m); // минуты
			timer_block.find('.' + s_class).html(s); // секунды
        }
    }
	
	$.fn.timer_countdown = function(options) {	    	
		Timer_countdown.init($(this), options);		
	}
	
})(jQuery);



/**
 *  Функция прокручивает страницу до переданного элемента за заданное время
 *  
 *  obj - элемент, к началу которого должна прокрутиться страница
 *  time - время (милисекунд), за которое должна прокрутиться страница
 */
function scroll_page (obj, time) {
	
	// если объект на странице есть
	if (obj.size() > 0) {
		
		// верхнее меню
		var ab = $('#application-bar_js');
		
		// найдем высоту верхнего меню
		var height_ab = 0;
		if (ab.size() == 1 && !detectIE6 ()) {
			height_ab = ab.height();
		}
		
		// найдем высоту, на которую нужно прокрутить страницу
		var height_top = obj.offset().top - height_ab;
		
		// если время для прокрутки задано
		if (time) {
			$('html, body').animate({scrollTop: height_top}, time);
		}
		// если время для прокрутки 0
		else {
			$('html, body').scrollTop(height_top);
		}
	}
}
 


/**
 *  Функция определяет, а не IE6 ли браузер у пользователя.
 *  Возвращает true, если браузер IE6 и false, если нет.
 */
function detectIE6 () {
	var ie = false;
	var vers = 0;
	var uagent = navigator.userAgent;
	uagent = uagent.indexOf("MSIE");
	// Если uagent не равен (-1) ie будет true
	if(uagent != -1){
		ie = true;
		//  Создаем переменную vers, помещаем в нее значение строки navigator.userAgent
		vers = navigator.userAgent;
		vers = vers.substr(uagent + 5, 2); 
		vers = parseInt(vers); // Преобразуем в целое число
	};
	// Теперь выполним проверку
	if(ie && vers == 6){
		return true;
	} else {
		return false;
	};
}


/**
 *  Функция определяет, а не IE ли браузер у пользователя.
 *  Возвращает true, если браузер IE и false, если нет.
 */
function detectIE () {
	var ie = false;
	var uagent = navigator.userAgent;
	
	uagent = uagent.indexOf("MSIE");
	
	if(uagent != -1){
		ie = true;		
	};

	return ie;
}


/**
 *  Функция определяет, а не Opera ли браузер у пользователя.
 *  Возвращает true, если браузер Opera и false, если нет.
 */
function detectOpera () {
	var opera = false;
	var uagent = navigator.userAgent;
	
	uagent = uagent.indexOf("Opera");
	
	if(uagent != -1){
		opera = true;		
	};

	return opera;
}

/**
 * Функция определяет существует ли такая функция
 * Return TRUE if the given function has been defined
 *
 * function_name - имя функции или свойство объекта - функция
 */
function function_exists (function_name) { 

	if (typeof function_name == 'string'){ 
        return (typeof this.window[function_name] == 'function'); 
    } else{ 
        return (function_name instanceof Function); 
    } 
}

/**
 * Функция определяет существует ли переданный объект object_name и его свойство property_name
 * Если существует - вернет true, если нет - false.
 */
function object_property_exists (object_name, property_name) { 
    
	if ( (typeof object_name == 'string') && (typeof property_name == 'string') && (typeof this.window[object_name] != 'undefined') ) {
		
		if (typeof this.window[object_name][property_name] != 'undefined') {
			return true;
		}
		else {
			return false;
		};
	} 
	else {
		return false;
	};	
}

/**
 * Функция для сбора статистики по кликам
 * example:
 * onclick="stat_click(1);"
 */
function stat_click(i){
	$.post("/aload/stat_click/", {type: i});
}

/**
 * Функция убирает пробелы из начала и из конца строки
 */
function trim (text) {
	var result  = text.replace(/^\s+|\s+$/g, "");
	return result;
}


/**
 * Функция очищает класс у блока, который определяет набор стилей для печати.
 * Блок #media-print_js находится сразу после body.
 */
function media_print_skin_clear () {
	$('#media-print_js').attr('class', '');
}