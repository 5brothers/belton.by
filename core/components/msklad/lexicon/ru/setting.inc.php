<?php
/**
 * Settings Russian Lexicon Entries for mSklad
 *
 * @package msklad
 * @subpackage lexicon
 */

$_lang['area_msklad_main'] = 'Основные';
$_lang['area_msklad_api'] = 'Подключение к API';
$_lang['area_msklad_1c'] = 'Подключение к 1c';

$_lang['setting_msklad_sync_direction'] = 'Направление синхронизации товаров';
$_lang['setting_msklad_sync_direction_desc'] = '0 - из miniShop2 в МойСклад, 1 - из сервиса CommerceML в miniShop2. По умолчанию - 1';
$_lang['setting_msklad_debug'] = 'Режим отладки';
$_lang['setting_msklad_debug_desc'] = 'Во время синхронизации справочника товаров в папку logs сохраняются полученные и отправленные REST запросы';
$_lang['setting_msklad_api_username'] = 'Логин API МойСклад';
$_lang['setting_msklad_api_username_desc'] = 'Используется для установления соединения с API МойСклад при синхронизации справочника товаров';
$_lang['setting_msklad_api_password'] = 'Пароль API МойСклад';
$_lang['setting_msklad_api_password_desc'] = 'Используется для установления соединения с API МойСклад при синхронизации справочника товаров';
$_lang['setting_msklad_on_update'] = 'В процессе обновления справочника';
$_lang['setting_msklad_on_update_desc'] = 'Устанавливается автоматически для предотвращения одновременных синхронизаций, втоматически сбрасывается через 10 минут';
$_lang['setting_msklad_1c_sync_login'] = 'Логин для CommerceML';
$_lang['setting_msklad_1c_sync_login_desc'] = 'Используется для установления соединения и синхронизации посредством CommerceML';
$_lang['setting_msklad_1c_sync_pass'] = 'Пароль для CommerceML';
$_lang['setting_msklad_1c_sync_pass_desc'] = 'Используется для установления соединения и синхронизации посредством CommerceML';
$_lang['setting_msklad_price_type_uuid'] = 'Валюта API МойСклад';
$_lang['setting_msklad_price_type_uuid_desc'] = 'Устанавливается автоматически при синхронизации (руб)';
$_lang['setting_msklad_uom_type_uuid'] = 'Еденица измерения товаров API МойСклад';
$_lang['setting_msklad_uom_type_uuid_desc'] = 'Устанавливается автоматически при синхронизации (шт)';
$_lang['setting_msklad_price_by_feature_tv'] = 'Tv параметр цены с учетом характеристики';
$_lang['setting_msklad_price_by_feature_tv_desc'] = 'Имя параметра, для сохранения цен с учетом характеристики при синхронизации';
$_lang['setting_msklad_order_accept_status_id'] = 'Id статуса обработанного заказа';
$_lang['setting_msklad_order_accept_status_id_desc'] = 'Устанавливается вместо статуса "Новый" заказам обработанным посредством CommerceML';
$_lang['setting_msklad_catalog_root_id'] = 'Id категории каталога';
$_lang['setting_msklad_catalog_root_id_desc'] = 'В эту категорию будет производиться импорт. По умолчанию - 0 (корень)';
$_lang['setting_msklad_catalog_context'] = 'Контекст каталога';
$_lang['setting_msklad_catalog_context_desc'] = 'Контекст каталога, в который производится импорт.';
$_lang['setting_msklad_user_id_import'] = 'Id пользователя';
$_lang['setting_msklad_user_id_import_desc'] = 'Id пользователя от имени которого будет производится импорт. По умолчанию - 1. Пользователю должны быть назначены права на создание и публикацию ресурсов.';
$_lang['setting_msklad_publish_default'] = 'Публиковать по умолчанию';
$_lang['setting_msklad_publish_default_desc'] = 'Выберите «Да» если хотите, чтобы все импортированные ресурсы сразу становились опубликованными';
$_lang['setting_msklad_template_product_default'] = 'Шаблон по умолчанию для новых товаров';
$_lang['setting_msklad_template_product_default_desc'] = 'Выберете шаблон, который будет установлен по умолчанию при создании товара.  При установке берется из настроек minishop2.';
$_lang['setting_msklad_template_category_default'] = 'Шаблон по умолчанию для новых категорий';
$_lang['setting_msklad_template_category_default_desc'] = 'Выберете шаблон, который будет установлен по умолчанию при создании категории.';
$_lang['setting_msklad_catalog_currency'] = 'Валюта каталога';
$_lang['setting_msklad_catalog_currency_desc'] = 'По умолчанию "руб", используется для синхронизации посредством CommerceML';
$_lang['setting_msklad_time_limit'] = 'Лимит выполнения';
$_lang['setting_msklad_time_limit_desc'] = 'Лимит выполнения одного пакета при импорте. По умолчанию "60", выставляйте значение в соответствии с настройками хостинга.';
$_lang['setting_msklad_create_properties_tv'] = 'Создавать tv';
$_lang['setting_msklad_create_properties_tv_desc'] = 'Выберите «Да» если хотите, чтобы автоматически создавались недостающие tv для свойств товара';
$_lang['setting_msklad_save_properties_to_tv'] = 'Сохранять все свойства товара в одно tv';
$_lang['setting_msklad_save_properties_to_tv_desc'] = 'Имя параметра, для сохранения всех свойств товара в формате JSON';
$_lang['setting_msklad_import_all_prices'] = 'Импортировать все цены';
$_lang['setting_msklad_import_all_prices_desc'] = 'Выберите «Да» если хотите, чтобы импортировались все цены товара, а не только первая. Настройте связи цен в компоненте mSklad.';
$_lang['setting_msklad_alias_with_id'] = 'Добавление к псевдониму id товара';
$_lang['setting_msklad_alias_with_id_desc'] = 'Выберите «Да» если хотите, чтобы к псевдониму товара добавлялся id (решает проблему повторяющихся псевдонимов).';
$_lang['setting_msklad_publish_by_quantity'] = 'Публиковать товар если есть в наличии';
$_lang['setting_msklad_publish_by_quantity_desc'] = 'Выберите «Да» если хотите, чтобы товар публиковался в зависимости от наличия. Для работы необходима настроенная в компоненте, связь параметра "Количество" и включенную настройку "msklad_publish_default". Работает только для одного товарного предложения каждому товару.';
$_lang['setting_msklad_last_orders_sync'] = 'Дата последней синхронизации';
$_lang['setting_msklad_last_orders_sync_desc'] = 'При синхронизации выбираются только те заказы которые были созданы или изменены после указанной даты.';