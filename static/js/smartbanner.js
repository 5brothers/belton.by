/* Всплывающее окно со ссылкой на страницу мобильного приложения */

/*
Пример вызова функции:

$(document).ready(function(){

	// $('#t158_smartbanner_js') - блок с содержимым всплывающего окна
	$('#t158_smartbanner_js').smartbanner();
	
});
*/

(function($) {
$.fn.smartbanner = function(options) {
	
	var Smartbanner = {
        
		// блок с содержимым всплывающего окна
		block: null,
		
		// тип всплывающего окна в зависимости от операционной системы (возможные значения: 'ios' | 'kindle' | 'android' | 'windows')
		type: '',
		
		// индивидуальные данные для операционных систем
		type_data: {
			'ios': {
				is_active: true, // есть ли приложение для данной операционной системы
				meta_name: 'apple-itunes-app', // атрибут name метатега, из которого будут браться данные (такой метатег должен быть на странице)
				store_link_start: 'https://itunes.apple.com/ru/app/id', // начало ссылки на страницу приложения, после которого идет идентификатор
				store_text: 'в App Store' // название магазина, которое идет после цены приложения
			},
			'kindle': {
				is_active: false, 
				meta_name: 'kindle-fire-app',
				store_link_start: 'amzn://apps/android?asin=',
				store_text: 'в Amazon Appstore'
			},
			'android': {
				is_active: true,
				meta_name: 'google-play-app',
				store_link_start: 'market://details?id=',
				store_text: 'на Google Play'
			},
			'windows': {
				is_active: false, // todo - пока нет параметров для метатегов windows - будем считать, что нет приложения
				meta_name: 'msApplication-ID',
				store_link_start: 'ms-windows-store:PDP?PFN=',
				store_text: 'в Windows Store'
			}
		},	
		
		// данные приложения, актуальные для текущей операционной системы (будут заполняться, когда мы ее определим)
		app_data: {
			id: '', // идентификатор приложения
			meta: null, // метатег, в котором содержаться данные о приложении
			store_link: '', // ссылка на страницу приложения
			store_text: '' // название магазина, которое идет после цены приложения
		},
		
		// параметры
        options: {
            block_id: 't158_smartbanner_js', // идентификатор блока с содержимым всплывающего окна
			block_open_class: 't158_smartbanner_open', // класс открытого блока
			button_close_class: 't158_close_js', // класс кнопки "Закрыть"
			store_name_class: 't158_info_store_name_js', // класс блока  с названием магазина
			store_link_class: 't158_button_view_link_js', // класс ссылки на страницу приложения
			type_forced: '', // принудительно определяемый тип всплывающего окна вне зависимости от операционной системы (нужен для теста)
			days_hidden: 1, // количество дней, которое не будет появляться окно после того, как пользователь его закрыл (15)
			days_reminder: 5, // количество дней, которое не будет появляться окно после того, как пользователь перешел на страницу приложения (90)
			cookie_closed: 'smartbanner-closed', // имя куки, которая проставляется, если окно было закрыто
			cookie_views: 'smartbanner-views', // имя куки, которая проставляется, если пользователь переходил на страницу с приложением
			cookie_domain: '.komus.ru', // параметр domain для куки
			ios_universal_app: true // мобильное приложение является универсальным для Ipad и Iphone
        },
        
        init: function(block, options) {
            // блок с содержимым всплывающего окна
			this.block = block;
			// параметры
            $.extend(this.options, options);
			
			var _this = this;
			
			// если блок на странице есть и он один
			if ( block.size() == 1 ) {				
				// запускаем действия по открыванию окна
				this.start(_this);
				// пользователь нажал на ссылку страницы с приложением
				this.click_view(_this);
				// пользователь нажал на кнопку "Закрыть"
				this.click_close(_this);
			};
        },
		
		// запускаем действия по открыванию окна
		start: function (_this) {
			// определим тип всплывающего окна в зависимости от операционной системы
			_this.detect_type(_this);			
			// определим, показывать ли окно
			var is_show = _this.is_show(_this);
			if (is_show) {
				// определяем данные приложения, актуальные для текущей операционной системы
				var is_detect_app_data = _this.detect_app_data(_this);
				// если данные приложения определились
				if (is_detect_app_data) {
					// заполняем окно данными
					_this.write_data(_this);
					// открываем окно
					_this.show(_this);
				};
			};
		},
		
		// определим тип всплывающего окна в зависимости от операционной системы
		detect_type: function (_this) {
						
			// название браузера
			var UA = navigator.userAgent;
			// тип всплывающего окна
			var type = '';
			
			// узнаем операционку и в зависимости от нее присвоим тип
			if (_this.options.type_forced) {
				type = _this.options.type_forced;
			} else if (UA.match(/iPhone|iPod/i) != null || (UA.match(/iPad/) && _this.options.ios_universal_app)) {
				if (UA.match(/Safari/i) != null &&
				   (UA.match(/CriOS/i) != null ||
				   // Check webview and native smart banner support (iOS 6+)
				   window.Number(UA.substr(UA.indexOf('OS ') + 3, 3).replace('_', '.')) < 6)) { 
				   		type = 'ios';
				   };
			} else if (UA.match(/\bSilk\/(.*\bMobile Safari\b)?/) || UA.match(/\bKF\w/) || UA.match('Kindle Fire')) {
				type = 'kindle';
			} else if (UA.match(/Android/i) != null) {
				type = 'android';
			} else if (UA.match(/Windows NT 6.2/i) != null && UA.match(/Touch/i) !== null) {
				type = 'windows';
			}
			
			Smartbanner.type = type;
		},		
		
		// проверяем корректность текущего значения Smartbanner.type
		is_correct_type: function () {
			// тип всплывающего окна в зависимости от операционной системы
			var type = Smartbanner.type;			
			// индивидуальные данные для операционных систем
			var type_data = Smartbanner.type_data;			
			// если тип операционной системы определен, есть данные для нее в type_data и есть мобильное приложение
			if (type && (typeof type_data[type] != 'undefined') && type_data[type].is_active) {
				return true;
			}
			else {
				return false;
			};
		},
		
		// определяем данные приложения, актуальные для текущей операционной системы
		detect_app_data: function (_this) {
			
			// если текущее значение Smartbanner.type некорректно, то определить мы ничего не можем
			if (! _this.is_correct_type()) {return false;};
			
			// тип всплывающего окна в зависимости от операционной системы
			var type = Smartbanner.type;
			// индивидуальные данные для текущей операционной системы
			var type_data = Smartbanner.type_data[type];			
			
			// артибут name метатега
			var meta_name = type_data.meta_name;
			// метатег
			var meta = $('meta[name="' + meta_name + '"]');			
			// если метатега нет - то данных приложения мы определить не можем
			if (meta.size() == 0) {return false;};
			
			// идентификатор приложения для текущей операционной системы
			var id = '';
			// определим идентификатор
			if (type == 'windows') {
				id = meta.attr('content');
			}
			else {
				id = /app-id=([^\s,]+)/.exec(meta.attr('content'))[1];
			};
			
			// ссылка на страницу приложения
			var store_link = type_data.store_link_start;
			// для windows ссылка формируется особым образом
			if (type == 'windows') {
				// найдем метатег с данными приложения
				var meta_windows = $('meta[name="msApplication-PackageFamilyName"]');
				// если метатега нет - ссылку мы определить не можем
				if (meta_windows.size() == 0) {return false;};
				// найдем параметр из метатега
				var pfn = meta_windows.attr('content');
				// сформируем ссылку
				store_link += pfn;
			}
			// для остальных операционных систем ссылка формируется стандартно
			else {
				store_link += id;
			}
			
			// название магазина, которое идет после цены приложения
			var store_text = type_data.store_text;	
			
			// полученные данные приложения
			var app_data = {
				id: id,
				meta: meta,
				store_link: store_link,
				store_text: store_text
			};
			
			// накатываем данные 
            $.extend(Smartbanner.app_data, app_data);
			
			// если мы дошли до конца - значит все данные приложения для текущей операционной системы определились
			return true;			
		},
		
		// заполняем окно данными
		write_data: function (_this) {
			// данные приложения
			var app_data = Smartbanner.app_data;						
			
			// впишем название магазина
			_this.block.find('.' + _this.options.store_name_class).html(app_data.store_text);			
			// впишем ссылку на магазин
			_this.block.find('.' + _this.options.store_link_class).attr('href', app_data.store_link);
		},
		
		// определяем, показывать ли всплывающее окно
		is_show: function (_this) {			
			
			// если текущее значение Smartbanner.type некорректно, то не будем открывать окно
			if (! _this.is_correct_type()) {return false;};
			
			// Check if it's already a standalone web app or running within a webui view of an app (not mobile safari)
			var standalone = navigator.standalone;
			var is_standalone = ( (typeof standalone != 'undefined') && standalone ) ? true : false;
			// Не показываем баннер, если сайт загружается в приложение, или установлены куки, говорящие о том, 
			// что всплывающее окно было закрыто или пользователь уже переходил на страницу с приложенмем
			if ( is_standalone || _this.get_cookie(_this.options.cookie_closed) || _this.get_cookie(_this.options.cookie_views) ) {
				return  false;
			}
						
			return true;
		},
		
		// открываем окно
		show: function (_this) {			
			// дадим главному блоку класс открытого		
			_this.block.addClass(_this.options.block_open_class);
		},
		
		// пользователь нажал на ссылку страницы с приложением
		click_view: function (_this) {
			// нажали на ссылку
			_this.block.find('.' + _this.options.store_link_class).click(function(){
				// устанавливаем куку
				_this.set_cookie(_this.options.cookie_views, 'true', _this.options.days_reminder, _this.options.cookie_domain)
			});
		},		
		
		// пользователь нажал на кнопку "Закрыть"
		click_close: function (_this) {
			// нажали на кнопку
			_this.block.find('.' + _this.options.button_close_class).click(function(){
				// устанавливаем куку
				_this.set_cookie(_this.options.cookie_closed, 'true', _this.options.days_hidden, _this.options.cookie_domain);				
				// уберем у главного блока класс открытого (закроем окно)
				_this.block.removeClass(_this.options.block_open_class);
			});
		},
		
		// определяем, установлена ли кука
		// name - имя куки
		get_cookie: function(name) {
            var i,x,y,ARRcookies = document.cookie.split(";")
            for(i=0;i<ARRcookies.length;i++) {
                x = ARRcookies[i].substr(0,ARRcookies[i].indexOf("="))
                y = ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1)
                x = x.replace(/^\s+|\s+$/g,"")
                if (x==name) {
                    return decodeURI(y)
                }
            }
            return null
        },
		
		// устанавливаем куку
		// name - имя куки
		// value - значение куки
		// exdays - на сколько дней ставим куку
		// domain - домен, на котором будет видна кука
		set_cookie: function(name, value, exdays, domain) {
            var exdate = new Date()
            exdate.setDate(exdate.getDate()+exdays)
            value=encodeURI(value)+((exdays==null)?'':'; expires='+exdate.toUTCString())
            document.cookie=name+'='+value+'; path=/; domain=' + domain;
        }
    }
	
	
	Smartbanner.init($(this), options);		
}	
})(jQuery);