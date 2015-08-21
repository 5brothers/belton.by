mSklad.panel.Conf = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'msklad-panel-config'
        ,xtype: 'form'
        ,layout: 'form'
        ,cls: 'container form-with-labels'
        ,url: mSklad.config.connector_url
        ,baseParams: {
            action: 'mgr/config/save',
            id: config.user
        }
        ,border: false
        ,padding: '10px'
        ,labelAlign: 'top'
        ,defaults: {
            border: false,
            msgTarget: 'under'
        }
        ,items: [
        {
            xtype: 'textfield',
            fieldLabel: _('msklad_1c_link'),
            name: '1c_link',
            value: mSklad.config.commercMlLink,
            allowBlank: true,
            width: 600
        },{
            xtype: 'textfield',
            fieldLabel: _('msklad_1c_login'),
            name: 'username',
            value: MODx.config['msklad_1c_sync_login'],
            maxLength: 255,
            allowBlank: true,
            width: 300
        }, {
            xtype: 'textfield',
            fieldLabel: _('msklad_1c_pass'),
            name: 'password',
            value: MODx.config['msklad_1c_sync_pass'],
            maxLength: 255,
            allowBlank: true,
            width: 300
        }]
    });
    mSklad.panel.Conf.superclass.constructor.call(this,config);
};
Ext.extend(mSklad.panel.Conf,MODx.FormPanel, {
    updateConfig: function (o){
        var vals = this.getForm().getValues();//.setValues(r.object);

        for(var p in vals) {
            MODx.config['msklad.'+p]=vals[p];
        }
        //mskladCheckConfig();
    }

});
Ext.reg('msklad-config-panel',mSklad.panel.Conf);