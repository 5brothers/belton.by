<script type="text/javascript">
(function($) {
    
    Application_bar = {
        // блок с верхним меню
        bar: null,
        // параметры блока с формой авторизации
        menu_login: null, // блок с панелью авторизации
        menu_login_number: 0, // номер блока с панелью авторизации среди других блоков с меню
        is_input_login_in_focus: false, // находится ли в фокусе одно из полей в форме авторизациии
        is_hover_login_menu: false, // наведен ли курсор на блок с меню авторизации         
        
        // параметры
        options: {
            // блоки с выпадающими панелями
            menu_class: 'application-bar--item-menu_js', // класс блока, внутри которого есть выпадающее меню
            menu_openable_class: 'application-bar--item-menu-m-openable', // класс блока, который может быть раскрыт
            menu_click_class: 'application-bar--item-menu-m-click', // класс блока, который будет раскрываться при клике
            menu_open_class: 'application-bar--item-menu-m-open', // класс отрытого блока
            menu_name_class: 'application-bar--item-menu-name', // класс блока с названием выпадающей панели (включает ссылку и стрелку)
            menu_name_link_class: 'application-bar--item-link', // класс ссылки внутри блока с названием выпадающей панели
            panel_class: 'application-bar__panel', // класс блока с выпадающей панелью
            panel_inside_class: 'application-bar__panel--inside', // класс блока со всем содержимым выпадающей панели
            panel_content_class: 'application-bar__panel--content', // класс блока, в котором находится главный контент в выпадающей панели
            panel_close_button_class: 'application-bar__panel--close-button_js', // класс кнопки-ссылки "Свернуть" внутри панели
            panel_top: 25, // отступ панели от верхнего края экрана
            panel_bottom: 20, // отступ панели от нижнего края экрана
            // блок с выбором компании
            item_usrname_class: 'application-bar--item-usrname', // класс блока, внутри которого находится название компании и выпадающая панель
            company_select_class: 'company-select', // класс блока со списком компаний
            // блок с формой авторизации
            item_login_class: 'application-bar--item-login', // класс блока, внутри которого находится форма авторизации
            // блок с иконкой корзины и суммой
            basket_sum_class: 'application-bar--basket-summ-count_js', // блок со значением суммы в корзине
            basket_link_class: 'application-bar--basket-link', // класс блока со ссылкой на корзину (включает иконку корзины и сумму)
            basket_link_active_class: 'application-bar--basket-link-active', // класс для блока со ссылкой на корзину, который дает содержимому красный цвет
            // блок с кнопкой "Оформить заказ"
            order_link_class: 'application-bar--order-link', // класс кнопки "Оформить заказ"
            order_link_active_class: 'application-bar--order-link-active' // класс кнопки "Оформить заказ", который дает ей красный цвет            
        },
          
        init: function(bar, options) {
            
            // блок с верхним меню
            this.bar = bar;
            // параметры
            $.extend(this.options, options);
            
            var _this = this;
            
            // если меню на странице одно
            if ( bar.size() == 1 ) {
                // двигаем меню по горизонтали при необходимости при заходе на страницу
                this.bar_shift(_this);
                // действия при изменении размера окна
                this.window_resize(_this);
                // действия при прокрутке окна
                this.window_scroll(_this);
                // при загрузке страницы изменяем вид блоков с выпадающми панелями при необходимости и найдем некоторые стартовые зачения
                this.panels_start(_this);
                // при наведении сделаем блоки с панелями открытыми
                this.panel_hover(_this);
                // если у блока с меню есть класс menu_click_class, то при клике на ссылку с названием блока, сделаем его открытым
                this.panel_click(_this);
                // будем отслеживать, находяться ли в фокусе поля в форме авторизации
                this.menu_login_is_focus(_this);
                // при нажимании на кнопку-ссылку "Свернуть" закроем панель
                this.panel_click_close_button(_this);
            };
        },
        
        // двигаем меню по горизонтали при необходимости
        bar_shift: function (_this) {           
            // смотрим - нет ли у нас невидимой части слева
            var window_scroll_left = $(window).scrollLeft();
            // и если такое дело есть - то
            if (window_scroll_left >= 0) {
                var left = -1 * window_scroll_left;
                // будем смещать верхнее меню, чтобы оно тоже ехало вместе с прокруткой и его можно было посмотреть
                _this.bar.css({'left' : left + 'px'});
            };
        },
        
        // действия при изменении размера окна
        window_resize: function (_this) {           
            $(window).resize(function() {
                Application_bar.bar_shift(_this);
            });
        },
        
        // действия при прокрутке окна
        window_scroll: function (_this) {           
            $(window).scroll(function() {
                Application_bar.bar_shift(_this);
            });
        },
        
        // обновляем сумму в корзине
        // sum - новое значение суммы, которое нужно вписать
        update_sum: function (sum) {            
            // определим блок с верхним меню
            var bar = Application_bar.bar;
            // обновим значение суммы
            bar.find('.' + Application_bar.options.basket_sum_class).text(sum);
            // сделаем красной кнопку "Оформить заказ"
            bar.find('.' + Application_bar.options.order_link_class).addClass(Application_bar.options.order_link_active_class);
            // сделаем красный цвет в блоке с иконкой корзины и суммой
            bar.find('.' + Application_bar.options.basket_link_class).addClass(Application_bar.options.basket_link_active_class);
        },
        
        // при загрузке страницы изменяем вид блоков с выпадающми панелями при необходимости и найдем некоторые стартовые зачения
        panels_start: function (_this) {            
            // блок с меню выбора компании
            var menu_usrname = _this.bar.find('.' + _this.options.item_usrname_class).find('.' + _this.options.menu_class);
            // проверим, есть ли список компаний внутри меню
            if ( menu_usrname.find('.' + _this.options.company_select_class).size() == 1 ) {
                // если есть - дадим блоку вид раскрываемого 
                menu_usrname.addClass(_this.options.menu_openable_class);
            };
            
            // определим блок с панелью авторизации
            Application_bar.menu_login = _this.bar.find('.' + _this.options.item_login_class).find('.' + _this.options.menu_class);         
            // определим номер блока с панелью авторизации среди других блоков  с меню
            Application_bar.menu_login_number = _this.bar.find('.' + _this.options.menu_class).index(Application_bar.menu_login);
        },
        
        // при наведении сделаем блоки с панелями открытыми
        panel_hover: function (_this) {         
            // навели мышь на блок
            _this.bar.find('.' + _this.options.menu_openable_class).hover (function () {                            
                // если это НЕ панель, которую можно открывать только при нажатии
                if (!$(this).hasClass(_this.options.menu_click_class)) {
                    // открываем панель
                    Application_bar.panel_open (_this, $(this));
                };
            }, function () {                
                // закрываем панель
                Application_bar.panel_close (_this, $(this));
            }); 
        },
        
        // если у блока с меню есть класс menu_click_class, то при клике на ссылку с названием блока, сделаем его открытым
        panel_click: function (_this) {
            // кликнули на ссылку
            _this.bar.find('.' + _this.options.menu_click_class).find('.' + _this.options.menu_name_class).on("click", function(eventObject) {
                // родительский блок с меню
                var menu = $(this).closest('.' + _this.options.menu_click_class);
                // если у родительского блока с меню есть класс menu_openable_class
                if (menu.hasClass(_this.options.menu_openable_class)) {
                    // не будем переходить по ссылке
                    eventObject.preventDefault();
                    // открываем панель
                    Application_bar.panel_open (_this, menu);
                };
            });
        },
        
        // открываем панель
        // menu - блок с выпадающим меню, который будем открывать
        panel_open: function (_this, menu) {
            // если это блок с меню авторизации
            if ( Application_bar.is_menu_login (_this, menu) ) { 
                // зафиксируем, что на него наведена мышь
                Application_bar.is_hover_login_menu = true;
            }
            // если это НЕ блок с меню авторизации
            else {
                // убем фокус из полей формы авторизации
                Application_bar.menu_login.find('input').blur();
                Application_bar.is_input_login_in_focus = false;
            };
            // закроем все блоки
            $('.' + _this.options.menu_openable_class).removeClass(_this.options.menu_open_class);
            // дадим данному блоку класс открытого
            menu.addClass(_this.options.menu_open_class);               
            // найдем панель внутри
            var panel = menu.find('.' + _this.options.panel_class);
            // если высота выпадающей панели больше, чем высота экрана - добавим внутрь панели прокрутку
            Application_bar.panel_add_scroll(_this, panel);
        },
        
        // закрываем панель
        // menu - блок с выпадающим меню, который будем закрывать
        panel_close: function (_this, menu) {
            // если это блок с меню авторизации
            if ( Application_bar.is_menu_login (_this, menu) ) { 
                // зафиксируем, что с него уведена мышь
                Application_bar.is_hover_login_menu = false;
                // закроем панель авторизации, если это можно
                Application_bar.panel_login_close(_this);
            }
            // если это НЕ блок  с меню авторизации
            else {
                // уберем у блока класс открытого
                menu.removeClass(_this.options.menu_open_class);
            };
        },
        
        // будем отслеживать, находяться ли в фокусе поля в форме авторизации
        menu_login_is_focus: function (_this) {
            
            Application_bar.menu_login.find('input').on("focus", function() {
                Application_bar.is_input_login_in_focus = true;
            });
            Application_bar.menu_login.find('input').on("blur", function() {
                Application_bar.is_input_login_in_focus = false;
                // закроем панель авторизации, если это можно
                Application_bar.panel_login_close(_this);
            });     
        },
        
        // функкция получает на вход блок menu и определяет, является ли он блоком с формой авторизации
        is_menu_login: function (_this, menu) {
            // номер текущего блока среди других блоков  с меню
            var menu_current_number = $('.' + _this.options.menu_class).index(menu);                
            // если это блок с меню авторизации - вернем true, если нет, то false
            if (menu_current_number == Application_bar.menu_login_number) { 
                return true;
            }
            else {
                return false;
            };
        },
        
        // функция проверяет, можно ли закрыть панель с формой авторизации  
        // и если можно - то закрывает ее   
        panel_login_close: function (_this) {
            // если ни одно из полей не в фокусе и мышь на панель не наведена
            if (!Application_bar.is_input_login_in_focus && !Application_bar.is_hover_login_menu) {
                // уберем у панели открытый вид
                Application_bar.menu_login.removeClass(_this.options.menu_open_class);
            }
        },
        
        // если высота выпадающей панели больше, чем высота экрана - добавим внутрь панели прокрутку
        // panel - панель, которой нужно дать полосу прокрутки внутри
        panel_add_scroll: function (_this, panel) {
            // узнаем высоту окна браузера
            var window_height = $(window).height();         
            // узнаем высоту панели
            var panel_height = panel.find('.' + _this.options.panel_inside_class).height();
            // если высота панели больше, чем экрана, то определим новую высоту блока с контентом, чтобы панель поместилась в экран
            if ( (_this.options.panel_top + panel_height + _this.options.panel_bottom) > window_height ) {
                // определим блок с контентом внутри панели
                var panel_content = panel.find('.' + _this.options.panel_content_class);
                // посмотрим, какая высота у блока с контентом
                var content_height =  panel_content.height();
                // определим, какую высоту должна занимать панель, чтобы поместиться в экран
                var panel_height_new = window_height - _this.options.panel_top - _this.options.panel_bottom;
                // посмотрим, какую высоту занимают в панели дополнительные элементы
                var panel_detalis_height = panel_height - content_height;
                // определим новую высоту для блока с контентом панели
                var content_height_new = panel_height_new - panel_detalis_height;
                // определим новый отступ справа для блока с контентом панели (он должен стать больше, т.к. появиться полоса прокрутки)
                var content_padding_right = parseInt(panel_content.css('padding-right')) + 15;
                // дадим новые значения блоку с контентом
                panel_content.height(content_height_new).css({'padding-right' : content_padding_right + 'px'});
            };
        },
        
        // при нажимании на кнопку-ссылку "Свернуть" закроем панель
        panel_click_close_button: function (_this) {
            _this.bar.find('.' + _this.options.panel_close_button_class).on("click", function () {
                $(this).closest('.' + _this.options.menu_class).removeClass(_this.options.menu_open_class);
            });
        }
    }
    
    $.fn.application_bar = function(options) {
        Application_bar.init($(this),options);
    }
    
})(jQuery);

</script>
<script type="text/javascript">
$(document).ready(function(){

    // $('#application-bar_js') - блок с верхним меню
    $('#application-bar_js').application_bar();
    
});
</script>


<!-- ВЕРХНЕЕ МЕНЮ -->
<div class="application-bar" id="application-bar_js">

    <div class="application-bar--block">
        <div class="application-bar--inside">
            
                        <div class="application-bar--items">
            	
                                <div class="application-bar--items-frame">
                	
                                    	<div class="application-bar--items-frame-left">
                    
						                        <div class="application-bar--item application-bar--item-area">
							                            
							
							                            <div class="application-bar--item-menu application-bar--item-menu-m-openable application-bar--item-menu-m-click application-bar--item-menu_js">
                                                                <div class="application-bar--item-menu-name">
                                    <a href="/region/" class="application-bar--item-link"><nobr>Минск</nobr></a>
                                </div><!-- .application-bar--item-menu-name -->
                                                                <div class="application-bar--item-menu-panel">
                                    



    <div class="application-bar__panel application-bar__panel_js">    
        <div class="application-bar__panel--inside">
            
			            <div class="application-bar__panel--top">
                <div class="application-bar__panel--top-arrow"></div>                
            </div><!-- .application-bar__panel--top -->
            
                        <div class="application-bar__panel--block">
                
                                <div class="application-bar__panel--content">



 

<script type="text/javascript">
$(document).ready(function () {

	

});
</script>
<!-- Меню выбора региона -->
<div class="region-select">        
    
        <div class="region-select--head">
    	Регионы обслуживания &laquo;Белтон&raquo; 
    </div><!-- .region-select--head -->
        
        	
                
                
                <div class="region-select--items">
            
                        <div class="region-select--items-col">
                
                                					
                      [[$regions]]
                    
                                        
                                
            </div><!-- .region-select--items-col -->
            
                        <div class="clear"></div>
            
        </div><!-- .region-select--items -->
        
        
</div><!-- .region-select -->
<!-- / Меню выбора региона --></div><!-- .application-bar__panel--content -->
                
                					                    <div class="application-bar__panel--close-block">
                        <span class="application-bar__panel--close-button application-bar__panel--close-button_js">
                            Свернуть
                        </span>
                    </div><!-- .application-bar__panel--close-block -->
                                
            </div><!-- .application-bar__panel--block -->
            
                        <table class="application-bar__panel--bottom">
            	<tr>
                	<td class="application-bar__panel--bottom-left"></td>
                    <td class="application-bar__panel--bottom-middle">&nbsp;</td>
                    <td class="application-bar__panel--bottom-right"></td>
                </tr>
            </table><!-- .application-bar__panel--bottom -->
            
        </div><!-- .application-bar__panel--inside -->                                       
    </div><!-- .application-bar__panel -->

                                </div><!-- .application-bar--item-menu-panel -->
                            </div><!-- .application-bar--item-menu -->
                        </div><!-- .application-bar--item -->
                    
                    </div><!-- .application-bar--items-frame-left -->
                    
                    <noindex>
					                	<div class="application-bar--items-frame-right">
                    
						                                                
                                                <div class="application-bar--item application-bar--item-myoffice">
                                                        <div class="application-bar--item-menu application-bar--item-menu-m-openable application-bar--item-menu_js">
                                                                <div class="application-bar--item-menu-name">
                                	<a 
                                    href="/myoffice/" 
                                    class="application-bar--item-link" 
                                    rel="nofollow"><nobr>Личный кабинет</nobr></a>
                                </div><!-- .application-bar--item-menu-name -->
                                                                <div class="application-bar--item-menu-panel">
                                    



    <div class="application-bar__panel application-bar__panel_js">    
        <div class="application-bar__panel--inside">
            
			            <div class="application-bar__panel--top">
                <div class="application-bar__panel--top-arrow"></div>                
            </div><!-- .application-bar__panel--top -->
            
                        <div class="application-bar__panel--block">
                
                                <div class="application-bar__panel--content">



<!-- Ссылки внутри выпадающей панели "Личный кабинет" -->
<div class="links-myoffice">        
    
            
        <ul class="links-myoffice--items">        
            
			                <li class="links-myoffice--item">
                    <img src="/image/nogreen/icone/regauth.png" class="links-myoffice--item-img" width="20" height="20" alt="" />
                    <a href="/myoffice/login/?statist=login&place=panel_out" class="links-myoffice--item-link" rel="nofollow">Регистрация/Авторизация</a>
                </li>
                        
			                <li class="links-myoffice--item">
                    <img src="/image/nogreen/icone/basket.png" class="links-myoffice--item-img" width="20" height="20" alt="" />
                    <a href="/cart/?statist=cart&place=panel_out" class="links-myoffice--item-link" rel="nofollow">Корзина</a>
                </li>
                        
			                <li class="links-myoffice--item">
                    <img src="/image/nogreen/icone/orders.png" class="links-myoffice--item-img" width="20" height="20" alt="" />
                    <a href="/myoffice/orders/?statist=orders&place=panel_out" class="links-myoffice--item-link" rel="nofollow">История заказов</a>
                </li>
                        
			            
			                <li class="links-myoffice--item">
                    <img src="/image/nogreen/icone/favorites.png" class="links-myoffice--item-img" width="20" height="20" alt="" />
                    <a href="/myoffice/favorites/?statist=fav&place=panel_out" class="links-myoffice--item-link" rel="nofollow">Избранное</a>
                </li>
                        
			                <li class="links-myoffice--item">
                    <img src="/image/nogreen/icone/user.png" class="links-myoffice--item-img" width="20" height="20" alt="" />
                    <a href="/myoffice/sms_subscribe/?statist=sms&place=panel_out" class="links-myoffice--item-link" rel="nofollow">SMS-уведомления</a>
                </li>
                        
			                
    </ul><!-- .links-myoffice--items -->
                    
</div><!-- .links-myoffice -->
<!-- / Ссылки внутри выпадающей панели "Личный кабинет" --></div><!-- .application-bar__panel--content -->
                
                                
            </div><!-- .application-bar__panel--block -->
            
                        <table class="application-bar__panel--bottom">
            	<tr>
                	<td class="application-bar__panel--bottom-left"></td>
                    <td class="application-bar__panel--bottom-middle">&nbsp;</td>
                    <td class="application-bar__panel--bottom-right"></td>
                </tr>
            </table><!-- .application-bar__panel--bottom -->
            
        </div><!-- .application-bar__panel--inside -->                                       
    </div><!-- .application-bar__panel -->

                                </div><!-- .application-bar--item-menu-panel -->
                            </div><!-- .application-bar--item-menu -->
                        </div><!-- .application-bar--item -->
                        
                                                    
                                                        <div class="application-bar--item application-bar--item-login">
                                								                                	<a href="/myoffice/login/" class="application-bar--item-link" rel="nofollow">Войти</a>
                                								                            </div><!-- .application-bar--item -->
                            
                                            
                    </div><!-- .application-bar--items-frame-right -->
                	</noindex>
                    
                </div><!-- .application-bar--items-frame -->
                        
            </div><!-- .application-bar--items -->
            
            <noindex>
                        <div class="application-bar--basket">
                                <a 
                href="/cart/" 
                class="application-bar--basket-link " 
                rel="nofollow">
                    <div class="application-bar--basket-summ">
                        <span class="application-bar--basket-summ-count application-bar--basket-summ-count_js">0</span>&nbsp;руб.
                    </div>
                </a>
            </div><!-- .application-bar--basket -->
            
                        <div class="application-bar--order">
            	                <a 
                href="/cart/index/b_order/" 
                class="application-bar--order-link " 
                rel="nofollow"></a>
            </div><!-- .application-bar--order -->
            </noindex>
            
        </div><!-- .application-bar--inside -->
    </div><!-- .application-bar--block -->
    
</div><!-- .application-bar -->