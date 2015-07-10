msRevaluation.form.msRevaluation = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'msrevaluation-form-msrevaluation'
        ,url: msRevaluation.config.connectorUrl
        ,baseParams: {
            action: 'mgr/process'
        }
        ,fields: [{
            xtype: 'minishop2-combo-category'
            ,width: 300
            ,emptyText: _('all')
        },{
            xtype: 'minishop2-combo-vendor'
            ,width: 300
            ,emptyText: _('all')
        },{
            xtype: 'modx-combo'
            ,fieldLabel: _('rev_dir')
            ,name: 'rev_dir'
            ,width: 300
            ,queryMode: 'local'
            ,value: _('increase')
            ,store:[_('increase'),_('decrease')]
        },{
            xtype: 'numberfield'
            ,renderer: true
            ,fieldLabel: _('percent')
            ,name: 'percent'
            ,width: 150
            ,allowBlank: false
        },{
            xtype: 'numberfield'
            ,fieldLabel: _('buti_prices')
            ,name: 'coefficient'
            ,value: 10
            ,width: 150
        },{
            xtype: 'textarea'
            ,fieldLabel: _('comment')
            ,name: 'comment'
            ,width: 300
        }]
    });
    msRevaluation.form.msRevaluation.superclass.constructor.call(this,config)
};
Ext.extend(msRevaluation.form.msRevaluation,MODx.Window);
Ext.reg('msrevaluation-form-msrevaluation',msRevaluation.form.msRevaluation);


//Позаимствованное у минишопа поле для вывода списка категорий
msRevaluation.form.Category = function(config) {
	config = config || {};
	Ext.applyIf(config,{
		id: 'minishop2-combo-section'
		,fieldLabel: _('category')
		,fields: ['id','pagetitle','parents']
		,valueField: 'id'
		,displayField: 'pagetitle'
		,name: 'id_categiry'
		,hiddenName: 'id_categiry'
		,url: MODx.config.assets_url+'components/minishop2/connector.php'
		,baseParams: {
			action: 'mgr/category/getcats'
			,combo: 1
			,id: config.value
		}
		,tpl: new Ext.XTemplate(''
			+'<tpl for="."><div class="minishop2-category-list-item">'
			+'<tpl if="parents">'
					+'<span class="parents">'
						+'<tpl for="parents">'
							+'<nobr><small>{pagetitle} / </small></nobr>'
						+'</tpl>'
					+'</span>'
			+'</tpl>'
			+'<span><small>({id})</small> <b>{pagetitle}</b></span>'
			+'</div></tpl>',{
			compiled: true
		})
		,itemSelector: 'div.minishop2-category-list-item'
		,pageSize: 20
		,editable: true
	});
	msRevaluation.form.Category.superclass.constructor.call(this,config);
};
Ext.extend(msRevaluation.form.Category,MODx.combo.ComboBox);
Ext.reg('minishop2-combo-category',msRevaluation.form.Category);


msRevaluation.form.Vendor = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'minishop2-combo-vendor'
        ,fieldLabel: _('vendor')
        ,fields: ['id','name']
        ,valueField: 'id'
        ,displayField: 'name'
        ,name: 'id_vendor'
        ,hiddenName: 'id_vendor'
        ,url: MODx.config.assets_url+'components/minishop2/connector.php'
        ,baseParams: {
            action: 'mgr/settings/vendor/getlist'
        }
        ,pageSize: 20
        ,editable: true
    });
    msRevaluation.form.Vendor.superclass.constructor.call(this,config);
};
Ext.extend(msRevaluation.form.Vendor,MODx.combo.ComboBox);
Ext.reg('minishop2-combo-vendor',msRevaluation.form.Vendor);