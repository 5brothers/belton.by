<?php
/**
* Settings English Lexicon Entries for mSklad
*
* @package msklad
* @subpackage lexicon
*/

$_lang['area_msklad_main'] = 'Main';
$_lang['area_msklad_api'] = 'Connect to API';
$_lang['area_msklad_1c'] = 'Connect to 1c';

$_lang['setting_msklad_sync_direction'] = 'Sync direction for products';
$_lang['setting_msklad_sync_direction_desc'] = '0 - from miniShop2 to MoySklad, 1 - from CommerceML to miniShop2. Default - 1';
$_lang['setting_msklad_debug'] = 'Debug mode';
$_lang['setting_msklad_debug_desc'] = 'During synchronization of merchandise in the folder logs are saved received and sent requests  REST';
$_lang['setting_msklad_api_username'] = 'Username API MoySklad';
$_lang['setting_msklad_api_username_desc'] = 'Used to establish a connection with the API MoySklad when synchronizing merchandise';
$_lang['setting_msklad_api_password'] = 'Password API MoySklad';
$_lang['setting_msklad_api_password_desc'] = 'Used to establish a connection with the API MoySklad when synchronizing merchandise';
$_lang['setting_msklad_on_update'] = 'In the process of updating the directory';
$_lang['setting_msklad_on_update_desc'] = 'Is set automatically to prevent simultaneous synchronization is automatically reset after 10 minutes';
$_lang['setting_msklad_1c_sync_login'] = 'Login for CommerceML';
$_lang['setting_msklad_1c_sync_login_desc'] = 'Used to establish a connection and synchronization through CommerceML';
$_lang['setting_msklad_1c_sync_pass'] = 'Password for CommerceML';
$_lang['setting_msklad_1c_sync_pass_desc'] = 'Used to establish a connection and synchronization through CommerceML';
$_lang['setting_msklad_price_type_uuid'] = 'Currency API MoySklad';
$_lang['setting_msklad_price_type_uuid_desc'] = 'Is installed automatically when synchronization (руб)';
$_lang['setting_msklad_uom_type_uuid'] = 'Unit of goods API MoySklad';
$_lang['setting_msklad_uom_type_uuid_desc'] = 'Is installed automatically when synchronization (шт)';
$_lang['setting_msklad_price_by_feature_tv'] = 'Tv параметр цены с учетом характеристики';
$_lang['setting_msklad_price_by_feature_tv_desc'] = 'Имя параметра, для сохранения цен с учетом характеристики при синхронизации';
$_lang['setting_msklad_order_accept_status_id'] = 'Id status of the accepted order';
$_lang['setting_msklad_order_accept_status_id_desc'] = 'Installed instead of the status "New" orders processed through the CommerceML';
$_lang['setting_msklad_catalog_root_id'] = 'Id shop category';
$_lang['setting_msklad_catalog_root_id_desc'] = 'This category will be imported. Default - 0 (root)';
$_lang['setting_msklad_catalog_context'] = 'Catalog context';
$_lang['setting_msklad_catalog_context_desc'] = 'Context of the catalog in which you are importing.';
$_lang['setting_msklad_user_id_import'] = 'User id';
$_lang['setting_msklad_user_id_import_desc'] = 'Id user that will be imported. Default - 1. The user must be assigned the rights to create and publish resources.';
$_lang['setting_msklad_publish_default'] = 'Published default';
$_lang['setting_msklad_publish_default_desc'] = 'Select "Yes" to make all imported resources published by default.';
$_lang['setting_msklad_template_product_default'] = 'Default template for new product';
$_lang['setting_msklad_template_product_default_desc'] = 'Select template which will be set by default when you creating new product.  When you install borrowed from the settings minishop2.';
$_lang['setting_msklad_template_category_default'] = 'Default template for new category';
$_lang['setting_msklad_template_category_default_desc'] = 'Select template which will be set by default when you creating new product.';
$_lang['setting_msklad_catalog_currency'] = 'Catalog currency';
$_lang['setting_msklad_catalog_currency_desc'] = 'By default, the "руб" is used to synchronize through CommerceML';
$_lang['setting_msklad_time_limit'] = 'Time limit';
$_lang['setting_msklad_time_limit_desc'] = 'Peak performance of one package when importing. The default is "60", display value according to the settings hosting.';
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