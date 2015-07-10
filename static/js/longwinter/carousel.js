/**
 *  Скрипт карусели.
 *  Используется на странице товара в блоке с доп. картинками (элемент product-card__pictures.php)
 *  и на странице с офисным пространством в блоке с наборами (блок office-carousel)
 */
 
(function($) {
$.fn.carousel = function(options) {	    	
    
	var Carousel = {
        // блоки с каруселями, для которых запускается функция (блоков с каруселями может быть несколько на странице, если вызов задан для класса)
		items: null,
		// ДАЛЕЕ - ГДЕ УКАЗАНЫ ПУСТЫЕ МАССИВЫ, ТАМ БУДУТ СОДЕРЖАТЬСЯ ЗНАЧЕНИЯ УКАЗАННЫХ ПАРАМЕТРОВ ДЛЯ ВСЕХ БЛОКОВ items НА СТРАНИЦЕ
		// ширина видимого блока с элементами (который между стрелками)
		items_visible_width: 0,
		// ширина всей полосы с элементами (которая скрыто двигается под стрелками)
		items_inside_width: new Array(),
		// текущий сдвиг влево всей полосы  с элементами
		items_inside_left: new Array(),
		// величина сдвига при нажатии на стрелку по умолчанию
		shift_width: 0,
		// параметры
        options: {
            // блок с элементами
			items_class: 'carousel_js', // класс главного родительского блока с каруселью
			items_inside_class: 'carousel--content-inside', // класс полосы с элементами, которая будет сдвигаться при нажатии на стрелки
			item_class: 'carousel--item', // класс блока с одним элементом
			item_current_class: '', // класс блока с текущим выбранным элементом (если он задан, то произойдет прокрутка к текущему элементу)
			item_width: 100, // ширина блока с одним элементом
			// количество элементов, которое помещается внутри видимой части
			items_visible_count: 4,
			// параметры сдвига
			shift_time: 1000, // время сдвига элементов при нажатии на стрелку
			shift_count: 4, // количество сдвигаемых элементов при нажатии на стрелку
			// стрелка влево
			arrow_left_class: 'carousel--arrow-left', // класс стрелки влево
			arrow_left_activ_class: 'carousel--arrow-left-activ', // класс активной стрелки влево
			arrow_left_passiv_class: 'carousel--arrow-left-passiv', // класс неактивной стрелки влево
			// стрелка вправо
			arrow_right_class: 'carousel--arrow-right', // класс стрелки вправо
			arrow_right_activ_class: 'carousel--arrow-right-activ', // класс активной стрелки вправо
			arrow_right_passiv_class: 'carousel--arrow-right-passiv' // класс неактивной стрелки вправо
        },
        
        init: function(items, options) {
            // блок с элементами
			this.items = items;
			// параметры
            $.extend(this.options, options);
			
			var _this = this;
			
			// если блок с каруселью на странице есть
			if ( items.size() > 0 ) {
				// Пройдем по всем блокам с каруселями на странице и сделаем для каждого следующее:
				// дадим внутреннему блоку со всеми элементами нужную ширину, левый отступ 0px, определим вид стрелок "влево" и "вправо"
				// и посчитаем начальные параметры
				this.start(_this);				
				// действия при нажатии на стрелку "влево"
				this.arrow_left_click(_this);
				// действия при нажатии на стрелку "вправо"
				this.arrow_right_click(_this);
			};
        },
		
		// Пройдем по всем блокам с каруселями на странице и сделаем для каждого следующее:
		// дадим внутреннему блоку со всеми элементами нужную ширину, левый отступ 0px, определим вид стрелок "влево" и "вправо"
		// и посчитаем начальные параметры
		start: function (_this) {
			
			// посчитаем ширину видимого блока с элементами
			Carousel.items_visible_width = _this.options.items_visible_count * _this.options.item_width;
			// посчитаем величину сдвига при нажатии на стрелку
			Carousel.shift_width = _this.options.shift_count * _this.options.item_width;
			
			// счетчик блоков
			var number_block = 0;
			// пройдем по всем блокам с каруселями
			_this.items.each(function () {
				// узнаем количество элементов в блоке с элементами
				var items_count = $(this).find('.' + _this.options.item_class).size();
				// найдем ширину блока со всеми элементами
				var items_inside_width = items_count * _this.options.item_width;
				// положим ширину в глобальную переменную
				Carousel.items_inside_width[number_block] = items_inside_width;
				// положим значение левого отступа в глобальную переменную
				Carousel.items_inside_left[number_block] = 0;
				// дадим блоку со всеми элементами найденную ширину и левый отступ 0px
				$(this).find('.' + _this.options.items_inside_class).css({'width' : items_inside_width + 'px', 'left' : '0px'});
				// дадим левой стрелке неактивный вид
				$(this).find('.' + _this.options.arrow_left_class).addClass(_this.options.arrow_left_passiv_class);
				// если элементов больше, чем должно поместиться в видимом блоке - дадим правой стрелке активный вид
				// если меньше - пассивный
				if (items_count > _this.options.items_visible_count) {
					$(this).find('.' + _this.options.arrow_right_class).addClass(_this.options.arrow_right_activ_class);
				}
				else {
					$(this).find('.' + _this.options.arrow_right_class).addClass(_this.options.arrow_right_passiv_class);
				}
				// если задан класс текущего элемента - прокрутим к нему карусель
				if (_this.options.item_current_class) {
					Carousel.goto_current(_this, $(this), number_block);
				};
				// прибавляем счетчик
				number_block ++;
			});
		},
		
		// если задан класс текущего элемента - прокрутим к нему карусель
		// items - текущий блок с каруселью
		// number_block - номер текущего блока с каруселью на странице (нумерация начинается с нуля)
		goto_current: function (_this, items, number_block) {
			
			// величина сдвига влево
			shift_width = 0;
			
			// найдем текущий элемент
			var item_current = items.find('.' + _this.options.item_current_class);
			// если текущий элемент в блоке есть
			if (item_current.size() > 0) {
				// найдем индекс текущего элемента
				var item_current_index = items.find('.' + _this.options.item_class).index(item_current);
				// найдем длину от начала блока со всеми элементами до левого края текущего элемента
				var item_current_left = item_current_index * _this.options.item_width;
				// найдем длину от конца блока со всеми элементами до левого края текущего элемента
				var item_current_right = Carousel.items_inside_width[number_block] - item_current_left;
				
				// если длина слева от элемента больше или равна видимой части, то есть чего сдвигать
				if (item_current_left >= Carousel.items_visible_width) {
					// если длина справа от элемента меньше или равна видимой части, то сдвинем блок до конца вправо
					if (item_current_right <= Carousel.items_visible_width) {						
						shift_width = Carousel.items_inside_width[number_block] - Carousel.items_visible_width;
					}
					// если длина справа от элемента больше видимой части - то сдвинем на целое количество Carousel.shift_width
					else {
						shift_width = (Math.floor (item_current_left / Carousel.shift_width)) * Carousel.shift_width;
					};
				};
				
				// если величина сдвига определена
				if (shift_width) {
					// действия при сдвиге карусели влево
					Carousel.shift_left (_this, items, number_block, shift_width);
				};
			};			
		},
		
		// действия при нажатии на стрелку "влево"
		arrow_left_click: function (_this) {
			$('.' + _this.options.arrow_left_class).on("click", function() {
				// найдем текущий блок с конвейером элементов
				var items = $(this).closest('.' + _this.options.items_class);
				// найдем номер текущего блока
				var number_block = _this.items.index(items);
				// посчитаем длину блока, которая скрыта слева
				var block_left_width = Carousel.block_left_width(number_block);
				// проверим, можем ли мы двигать товары вправо
				if (block_left_width > 0) {					
					// посчитаем, на сколько мы можем сдвинуть товары вправо
					if (block_left_width >= Carousel.shift_width) {
						var shift_width = Carousel.shift_width;
					}
					else {
						var shift_width = block_left_width;
					};
					
					// действия при сдвиге карусели вправо
					Carousel.shift_right (_this, items, number_block, shift_width);
				};
			});
		},
		
		// действия при сдвиге карусели вправо
		// items - текущий блок с каруселью
		// number_block - номер текущего блока с каруселью на странице (нумерация начинается с нуля)
		// shift_width - величина сдвига влево
		shift_right: function (_this, items, number_block, shift_width) {			
			// найдем новое значение сдвига влево блока со всеми элементами
			Carousel.items_inside_left[number_block] = Carousel.items_inside_left[number_block] + shift_width;
			// сдвинем товары вправо
			items.find('.' + _this.options.items_inside_class).animate({'left' : Carousel.items_inside_left[number_block] + 'px'}, _this.options.shift_time);
			// проверим, не нужно ли сделать левую стрелку пассивной
			if (Carousel.block_left_width(number_block) <= 0) {
				items.find('.' + _this.options.arrow_left_class)
					 .removeClass(_this.options.arrow_left_activ_class)
					 .addClass(_this.options.arrow_left_passiv_class);
			};
			// сделаем активной правую стрелку
			items.find('.' + _this.options.arrow_right_class)
				 .removeClass(_this.options.arrow_right_passiv_class)
				 .addClass(_this.options.arrow_right_activ_class);
		},
		
		// действия при нажатии на стрелку "вправо"
		arrow_right_click: function (_this) {
			$('.' + _this.options.arrow_right_class).on("click", function() {
				// найдем текущий блок с конвейером элементов
				var items = $(this).closest('.' + _this.options.items_class);
				// найдем номер текущего блока
				var number_block = _this.items.index(items);
				// посчитаем длину блока, которая скрыта справа
				var block_right_width = Carousel.block_right_width(number_block);
				// проверим, можем ли мы двигать товары влево
				if (block_right_width > 0) {					
					// посчитаем, на сколько мы можем сдвинуть товары влево
					if (block_right_width >= Carousel.shift_width) {
						var shift_width = Carousel.shift_width;
					}
					else {
						var shift_width = block_right_width;
					};
					
					// действия при сдвиге карусели влево
					Carousel.shift_left (_this, items, number_block, shift_width);
				};
			});
		},
		
		// действия при сдвиге карусели влево
		// items - текущий блок с каруселью
		// number_block - номер текущего блока с каруселью на странице (нумерация начинается с нуля)
		// shift_width - величина сдвига влево
		shift_left: function (_this, items, number_block, shift_width) {			
			// найдем новое значение сдвига влево блока со всеми элементами
			Carousel.items_inside_left[number_block] = Carousel.items_inside_left[number_block] - shift_width;
			// сдвинем товары влево
			items.find('.' + _this.options.items_inside_class).animate({'left' : Carousel.items_inside_left[number_block] + 'px'}, _this.options.shift_time);
			// проверим, не нужно ли сделать правую стрелку пассивной
			if (Carousel.block_right_width(number_block) <= 0) {
				items.find('.' + _this.options.arrow_right_class)
					 .removeClass(_this.options.arrow_right_activ_class)
					 .addClass(_this.options.arrow_right_passiv_class);
			};
			// сделаем активной левую стрелку
			items.find('.' + _this.options.arrow_left_class)
				 .removeClass(_this.options.arrow_left_passiv_class)
				 .addClass(_this.options.arrow_left_activ_class);
		},
		
		// возвращает длину блока, которая скрыта слева
		// number_block - номер текущего блока с каруселью на странице (нумерация начинается с нуля)
		block_left_width: function (number_block) {
			var block_left_width = -1 * (Carousel.items_inside_left[number_block]);
			return block_left_width;
		},
		
		// возвращает длину блока, которая скрыта справа
		// number_block - номер текущего блока с каруселью на странице (нумерация начинается с нуля)
		block_right_width: function (number_block) {
			var block_right_width = Carousel.items_inside_width[number_block] - (Carousel.items_visible_width - Carousel.items_inside_left[number_block]);
			return block_right_width;
		}		
    }
	
	
	Carousel.init($(this), options);		
}	
})(jQuery);