mSklad.panel.Home = function(config) {
	config = config || {};
	Ext.apply(config,{
        id: 'msklad-panel-cmp'
		,border: false
		,baseCls: 'modx-formpanel'
		,items: [{
			html: '<h2>'+_('msklad')+'</h2><p>'+_('msklad_menu_desc')+'</p>'
			,border: false
			,cls: 'modx-page-header container'
		},{
			xtype: 'modx-tabs'
			,bodyStyle: 'padding: 10px'
			,defaults: { border: false ,autoHeight: true }
			,border: true
			,activeItem: 0
			,hideMode: 'offsets'
			,items: [
                //Настройки
                {
                    title: _('msklad_1c_properties')
                    ,defaults: {autoHeight: true}
                    ,items: [{
                        html: '<p>'+_('msklad_1c_properties_intro')+'</p>'
                        ,border: false
                        ,bodyCssClass: 'panel-desc'
                        ,bodyStyle: 'margin-bottom: 10px'
                    },{
                        xtype: 'msklad-grid-property'
                        ,preventRender: true
                    }]
                }
                ,{
                    title: _('msklad_1c_config')
                    ,defaults: {autoHeight: true}
                    ,items: [{
                        xtype: 'msklad-config-panel'
                        ,preventRender: true
                    }]
                }
                ,{
                    title: _('msklad_sync_catalog')
                    ,defaults: {autoHeight: true}
                    ,items: [{
                        xtype: 'msklad-sync-panel'
                        ,preventRender: true
                    }]
                }
            ]
		}
        ,{
            html: _('msklad_copyright')
            ,border: false
            ,bodyStyle: 'background-color: transparent !important; margin:10px; text-align:right;'
        }]
	});
	mSklad.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(mSklad.panel.Home,MODx.Panel,{
    exportCatalog: function(start,total,name) {
        if(typeof(start)=='undefined') var start = 0;
        if(typeof(total)=='undefined') var total = 0;
        if(typeof(name)=='undefined') var name = '';

        var sync_form = Ext.getCmp('msklad_sync_form');

        sync_form.getEl().mask(_('msklad_export_prepare')+(total>0 ? ' ('+start+' '+_('msklad_export_prepare_from')+' '+total+')' : ''), 'x-mask-loading');

        MODx.Ajax.request({
            url: mSklad.config.connector_url
            ,params: {
                action: 'mgr/export/prepare', start:start, total:total, name:name
            }
            ,method: 'POST'
            ,listeners: {
                success: {fn:function(r) {
                    sync_form.getEl().unmask();
                    if(r.message.stop==0){
                        start+=500;
                        Ext.getCmp('msklad-panel-cmp').exportCatalog(start, r.message.total,r.message.name);
                    }else{
                        sync_form.getEl().mask(_('msklad_export_prepare_ok'), 'x-mask-loading');
                        Ext.getCmp('msklad-panel-cmp').getExportFile(r.message.name);
                    }
                },scope:this}
                ,failure: {fn:function(r) {
                    sync_form.getEl().unmask();
                },scope:this}
            }
        });
    }
    ,getExportFile: function(name) {
        var sync_form = Ext.getCmp('msklad_sync_form');

        sync_form.getEl().mask(_('msklad_export_file'), 'x-mask-loading');

        var resultPanel = Ext.getCmp('export-result');
        resultPanel.body.update('');

        MODx.Ajax.request({
            url: mSklad.config.connector_url
            ,params: {
                action: 'mgr/export/getfile', name:name
            }
            ,method: 'POST'
            ,listeners: {
                success: {fn:function(r) {
                    sync_form.getEl().unmask();
                    resultPanel.body.update(_('msklad_export_download')+' <a href="'+r.message.file+'" target="_blank">'+r.message.file+'</a>');
                },scope:this}
                ,failure: {fn:function(r) {
                    sync_form.getEl().unmask();
                },scope:this}
            }
        });
    }
    ,checkConnect: function() {
        var sync_form = Ext.getCmp('msklad_sync_form');

        sync_form.getEl().mask(_('msklad_api_check_connect'), 'x-mask-loading');

        MODx.Ajax.request({
            url: mSklad.config.connector_url
            ,params: {
                action: 'mgr/api/checkconnect'
            }
            ,method: 'POST'
            ,listeners: {
                success: {fn:function(r) {
                    sync_form.getEl().unmask();
                    Ext.getCmp('msklad-panel-cmp').loadCategory(0,0);
                },scope:this}
                ,failure: {fn:function(r) {
                    sync_form.getEl().unmask();
                },scope:this}
            }
        });
    }

    ,loadCategory: function(start,total) {
        if(typeof(start)=='undefined') var start = 0;
        if(typeof(total)=='undefined') var total = 0;

        var sync_form = Ext.getCmp('msklad_sync_form');

        sync_form.getEl().mask(_('msklad_category_load')+(total>0 ? ' ('+start+' '+_('msklad_category_load_from')+' '+total+')' : ''), 'x-mask-loading');

        MODx.Ajax.request({
            url: mSklad.config.connector_url
            ,params: {
                action: 'mgr/category/load', start:start, total:total
            }
            ,method: 'POST'
            ,listeners: {
                success: {fn:function(r) {
                    sync_form.getEl().unmask();
                    if(r.message.stop==0){
                        start+=500;
                        Ext.getCmp('msklad-panel-cmp').loadCategory(start, r.message.total);
                    }else{
                        sync_form.getEl().mask(_('msklad_category_load_ok'), 'x-mask-loading');
                        Ext.getCmp('msklad-panel-cmp').prepareCategory();
                    }
                },scope:this}
                ,failure: {fn:function(r) {
                    sync_form.getEl().unmask();
                },scope:this}
            }
        });
    }

    ,prepareCategory: function() {
        var sync_form = Ext.getCmp('msklad_sync_form');

        sync_form.getEl().mask(_('msklad_category_prepare'), 'x-mask-loading');

        MODx.Ajax.request({
            url: mSklad.config.connector_url
            ,params: {
                action: 'mgr/category/prepare'
            }
            ,method: 'POST'
            ,listeners: {
                success: {fn:function(r) {
                    sync_form.getEl().mask(_('msklad_category_prepare_ok'), 'x-mask-loading');
                    Ext.getCmp('msklad-panel-cmp').updateCategory(0,0,1);
                },scope:this}
                ,failure: {fn:function(r) {
                    sync_form.getEl().unmask();
                },scope:this}
            }
        });
    }

    ,updateCategory: function(start,total,level) {
        if(typeof(start)=='undefined') var start = 0;
        if(typeof(total)=='undefined') var total = 0;
        if(typeof(level)=='undefined') var level = 1;
        var sync_form = Ext.getCmp('msklad_sync_form');

        sync_form.getEl().mask(_('msklad_category_update'), 'x-mask-loading');

        MODx.Ajax.request({
            url: mSklad.config.connector_url
            ,params: {
                action: 'mgr/category/updatesklad', start:start, total:total, level:level
            }
            ,method: 'POST'
            ,listeners: {
                success: {fn:function(r) {
                    if(r.message.stop==0){
                        if(r.message.level==level) start+=100;
                        else start=0;
                        Ext.getCmp('msklad-panel-cmp').updateCategory(start, r.message.total, r.message.level);
                    }else{
                        sync_form.getEl().mask(_('msklad_category_update_ok'), 'x-mask-loading');
                        Ext.getCmp('msklad-panel-cmp').loadProducts(0,0);
                    }

                },scope:this}
                ,failure: {fn:function(r) {
                    sync_form.getEl().unmask();
                },scope:this}
            }
        });
    }

    ,loadProducts: function(start,total) {
        if(typeof(start)=='undefined') var start = 0;
        if(typeof(total)=='undefined') var total = 0;

        var sync_form = Ext.getCmp('msklad_sync_form');

        sync_form.getEl().mask(_('msklad_product_load')+(total>0 ? ' ('+start+' '+_('msklad_product_load_from')+' '+total+')' : ''), 'x-mask-loading');

        MODx.Ajax.request({
            url: mSklad.config.connector_url
            ,params: {
                action: 'mgr/product/load', start:start, total:total
            }
            ,method: 'POST'
            ,listeners: {
                success: {fn:function(r) {
                    sync_form.getEl().unmask();
                    if(r.message.stop==0){
                        start+=500;
                        Ext.getCmp('msklad-panel-cmp').loadProducts(start, r.message.total);
                    }else{
                        sync_form.getEl().mask(_('msklad_product_load_ok'), 'x-mask-loading');
                        Ext.getCmp('msklad-panel-cmp').prepareProducts(0,0);

                    }
                },scope:this}
                ,failure: {fn:function(r) {
                    sync_form.getEl().unmask();
                },scope:this}
            }
        });
    }

    ,prepareProducts: function(start,total) {
        if(typeof(start)=='undefined') var start = 0;
        if(typeof(total)=='undefined') var total = 0;

        var sync_form = Ext.getCmp('msklad_sync_form');

        sync_form.getEl().mask(_('msklad_product_prepare')+(total>0 ? ' ('+start+' '+_('msklad_product_load_from')+' '+total+')' : ''), 'x-mask-loading');

        MODx.Ajax.request({
            url: mSklad.config.connector_url
            ,params: {
                action: 'mgr/product/prepare', start:start, total:total
            }
            ,method: 'POST'
            ,listeners: {
                success: {fn:function(r) {
                    if(r.message.stop==0){
                        start+=500;
                        Ext.getCmp('msklad-panel-cmp').prepareProducts(start, r.message.total);
                    }else{
                        sync_form.getEl().mask(_('msklad_product_prepare_ok'), 'x-mask-loading');
                        Ext.getCmp('msklad-panel-cmp').updateProducts(0,0);
                    }
                },scope:this}
                ,failure: {fn:function(r) {
                    sync_form.getEl().unmask();
                },scope:this}
            }
        });
    }

    ,updateProducts: function(start,total) {
        if(typeof(start)=='undefined') var start = 0;
        if(typeof(total)=='undefined') var total = 0;

        var sync_form = Ext.getCmp('msklad_sync_form');

        sync_form.getEl().mask(_('msklad_product_update')+(total>0 ? ' ('+start+' '+_('msklad_product_load_from')+' '+total+')' : ''), 'x-mask-loading');

        MODx.Ajax.request({
            url: mSklad.config.connector_url
            ,params: {
                action: 'mgr/product/updatesklad', start:start, total:total
            }
            ,method: 'POST'
            ,listeners: {
                success: {fn:function(r) {
//                    Ext.getCmp('msklad-panel-cmp').finishSync();
                    if(r.message.stop==0){
                        start+=100;
                        Ext.getCmp('msklad-panel-cmp').updateProducts(start, r.message.total);
                    }else{
                        sync_form.getEl().mask(_('msklad_product_update_ok'), 'x-mask-loading');
                        Ext.getCmp('msklad-panel-cmp').finishSync();
                    }
                },scope:this}
                ,failure: {fn:function(r) {
                    sync_form.getEl().unmask();
                },scope:this}
            }
        });
    }

    ,finishSync: function() {
        var sync_form = Ext.getCmp('msklad_sync_form');

        sync_form.getEl().mask(_('msklad_sync_finish'), 'x-mask-loading');

        MODx.Ajax.request({
            url: mSklad.config.connector_url
            ,params: {
                action: 'mgr/sync/finish'
            }
            ,method: 'POST'
            ,listeners: {
                success: {fn:function(r) {
                    sync_form.getEl().unmask();
                },scope:this}
                ,failure: {fn:function(r) {
                    sync_form.getEl().unmask();
                },scope:this}
            }
        });
    }
});
Ext.reg('msklad-panel-home',mSklad.panel.Home);
