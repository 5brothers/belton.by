mSklad.panel.Sync = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'msklad_sync_form'
        ,xtype: 'form'
        ,layout: 'form'
        ,cls: 'container form-with-labels'
        ,border: false
        ,padding: '10px'
        ,labelWidth: 180
        ,buttonAlign: 'left'
        ,items: [
            {
                xtype: 'hidden'
                ,name: 'shop'
                ,value: 'minishop'
                ,id: 'modx-resource-parent-hidden-cmp'+this.ident_imp
            }
            ,{
                xtype: 'button'
                ,id: 'msklad_button_sync_catalog'
                ,text: _('msklad_sync_catalog_button')
                ,handler: function(){
                    Ext.getCmp('msklad-panel-cmp').checkConnect()
                }
                ,listeners: {
                    render: {fn: function(a) {
                        if(mSklad.config.sync_direction==1) a.hide();
                    }, scope: this}
                }
                ,scope: this
            }
            ,{
                html: _('msklad_export_msg')
                ,border: false
                ,bodyCssClass: 'panel-desc'
                ,bodyStyle: 'margin-bottom: 10px'
            }
            ,{
                xtype: "button"
                ,id: 'msklad_button_export_catalog'
                ,text: _('msklad_sync_export_button')
                ,handler: function(){
                    Ext.getCmp('msklad-panel-cmp').exportCatalog(0,0,'');
                }
                ,scope: this
            }
            ,{
                html: '<div class="export-result"></div>'
                ,border: false
                ,id: 'export-result'
            }
        ]
    });
    mSklad.panel.Sync.superclass.constructor.call(this,config);
};
Ext.extend(mSklad.panel.Sync,MODx.FormPanel, {

});
Ext.reg('msklad-sync-panel',mSklad.panel.Sync);