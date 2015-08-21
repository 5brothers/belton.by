mSklad.grid.Property = function(config) {
    config = config || {};

    Ext.applyIf(config,{
        id: 'msklad-grid-property'
        ,url: mSklad.config.connector_url
        ,baseParams: {
            action: 'mgr/property/getlist'
        }
        ,fields: ['id','source','type','target','active','default']
        ,autoHeight: true
        ,paging: true
        ,remoteSort: true
        ,autosave: true
        ,columns: [
            {header: _('msklad_id'),dataIndex: 'id',width: 50, sortable: true}
            ,{header: _('msklad_source'),dataIndex: 'source',width: 150, sortable: true}
            ,{header: _('msklad_type'),dataIndex: 'type',width: 100, renderer: this.renderType}
            ,{header: _('msklad_target'),dataIndex: 'target',width: 150, sortable: true}
            ,{header: _('msklad_active'),dataIndex: 'active',width: 100, renderer: this.renderActive}
        ]
        ,tbar: [{
            text: _('msklad_btn_create')
            ,handler: this.createProperty
            ,scope: this
        }]
    });
    mSklad.grid.Property.superclass.constructor.call(this,config);
};

Ext.extend(mSklad.grid.Property,MODx.grid.Grid,{
    windows: {}
    ,getMenu: function(grid,index) {
        var m = [];
        m.push({
            text: _('msklad_menu_update')
            ,handler: this.updateProperty
        });
        var record = grid.store.getAt(index);
        if(record.data.default!=1){
            m.push('-');
            m.push({
                text: _('msklad_menu_remove')
                ,handler: this.removeProperty
            });
        }
         this.addContextMenuItem(m);
    }
    ,renderType: function(value) {
        if(value==1) return _('msklad_type_db');
        else return  _('msklad_type_tv');
    }
    ,renderActive: function(value) {
        if(value) return _('msklad_active_yes');
        else return  _('msklad_active_no');
    }
    ,createProperty: function(btn,e) {
        if (!this.windows.createProperty) {
            this.windows.createProperty = MODx.load({
                xtype: 'msklad-window-property-create'
                ,fields: this.getPropertyFields('create',0)
                ,listeners: {
                    success: {fn:function() { this.refresh(); },scope:this}
                }
            });
        }
        this.windows.createProperty.fp.getForm().reset();
        this.windows.createProperty.show(e.target);
//        Ext.getCmp('msklad-property-type_desc-create').getEl().dom.innerText = '';
    }

    ,updateProperty: function(btn,e) {
        if (!this.menu.record || !this.menu.record.id) return false;
        var r = this.menu.record;

//        if (!this.windows.updateProperty) {
            this.windows.updateProperty = MODx.load({
                xtype: 'msklad-window-property-update'
                ,record: r
                ,fields: this.getPropertyFields('update', r.default)
                ,listeners: {
                    success: {fn:function() { this.refresh(); },scope:this}
                }
            });
//        }
        this.windows.updateProperty.fp.getForm().reset();
        this.windows.updateProperty.fp.getForm().setValues(r);
        this.windows.updateProperty.show(e.target);
//        Ext.getCmp('msklad-property-type_desc-update').getEl().dom.innerText = r.type ? _('ms2_link_'+r.type+'_desc') : '';
    }

    ,removeProperty: function(btn,e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: _('msklad_menu_remove') + '"' + this.menu.record.name + '"'
            ,text: _('msklad_menu_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/property/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                success: {fn:function(r) {this.refresh();}, scope:this}
            }
        });
    }
    ,getPropertyFields: function(type,propertyDefault) {
        return [
            {xtype: 'hidden',name: 'id'}
            ,{xtype: 'hidden',name: 'default'}
            ,{xtype: 'textfield',fieldLabel: _('msklad_source'), name: 'source', allowBlank: false, anchor: '99%',  disabled: propertyDefault == true ? 1 : 0}
            ,{xtype: 'msklad-combo-property-type',fieldLabel: _('msklad_type'), name: 'type', allowBlank: false, anchor: '99%'}
            ,{xtype: 'textfield',fieldLabel: _('msklad_target'), name: 'target', allowBlank: false, anchor: '99%'}
            ,{xtype: 'xcheckbox',boxLabel: _('msklad_active'), name: 'active', inputValue: 1, checked: 1}
        ];
    }
});

Ext.reg('msklad-grid-property',mSklad.grid.Property);



mSklad.window.createProperty = function(config) {
    config = config || {};

    this.ident = 'meuitem-create-'+Ext.id()+'-window';
    Ext.applyIf(config,{
        title: _('msklad_menu_create')
        ,id: this.ident
        ,width: 600
        ,labelAlign: 'left'
        ,labelWidth: 300
        ,url: mSklad.config.connector_url
        ,action: 'mgr/property/create'
        ,fields: config.fields
        ,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
    });
    mSklad.window.createProperty.superclass.constructor.call(this,config);
};
Ext.extend(mSklad.window.createProperty,MODx.Window);
Ext.reg('msklad-window-property-create',mSklad.window.createProperty);

mSklad.window.updateProperty = function(config) {
    config = config || {};

    this.ident = 'meuitem-update-'+Ext.id()+'-window';
    Ext.applyIf(config,{
        title: _('msklad_menu_update')
        ,id: this.ident
        ,width: 600
        ,labelAlign: 'left'
        ,labelWidth: 300
        ,url: mSklad.config.connector_url
        ,action: 'mgr/property/update'
        ,fields: config.fields
        ,keys: [{key: Ext.EventObject.ENTER,shift: true,fn: function() {this.submit() },scope: this}]
    });
    mSklad.window.updateProperty .superclass.constructor.call(this,config);
};
Ext.extend(mSklad.window.updateProperty ,MODx.Window);
Ext.reg('msklad-window-property-update',mSklad.window.updateProperty);

mSklad.combo.PropertyType = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 0
            ,fields: ['type','display']
            ,data: [
                ['1',_('msklad_type_db')]
                ,['2',_('msklad_type_tv')]
            ]
        })
        ,mode: 'local'
        ,displayField: 'display'
        ,valueField: 'type'
        ,hiddenName: 'type'

    });
    mSklad.combo.PropertyType.superclass.constructor.call(this,config);
};
Ext.extend(mSklad.combo.PropertyType,MODx.combo.ComboBox);
Ext.reg('msklad-combo-property-type',mSklad.combo.PropertyType);