msRevaluation.grid.msRevaluation = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'msrevaluation-grid-msrevaluation'
        ,url: msRevaluation.config.connectorUrl
        ,baseParams: { action: 'mgr/list' }
        ,fields: ['id','time','comment','action','percent','id_categiry']
        ,paging: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'comment'
        ,columns: [{
            header: _('id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 60
            },{
            header: _('time')
            ,dataIndex: 'time'
            ,sortable: true
            ,width: 100
            },{
            header: _('comment')
            ,dataIndex: 'comment'
            ,sortable: false
            ,width: 350
            },{
            header: _('action')
            ,dataIndex: 'action'
            ,sortable: true
            ,width: 60
            },{
            header: _('category')
            ,dataIndex: 'id_categiry'
            ,sortable: true
            ,width: 150
        }]
        ,tbar: [{
            text: _('new_revaluation')
            ,handler: { xtype: 'msrevaluation-form-msrevaluation' ,blankValues: true }
        }]
        ,getMenu: function() {
            return [{
                    text: _('new_revaluation')
                    ,handler: this.newRewaluation
                },'-',{
                    text: _('remove')
                    ,handler: this.cancelRevaluation
            }];
        },
        cancelRevaluation: function() {
            MODx.msg.confirm({
                title: _('remove')
                ,text: _('remove_confirm')
                ,url: this.config.url
                ,params: {
                    action: 'mgr/cancel'
                    ,id: this.menu.record.id
                }
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        ,newRewaluation: function(btn,e) {
            if (!this.createRevaluation) {
                this.createRevaluation = MODx.load({
                    xtype: 'msrevaluation-form-msrevaluation'
                    ,listeners: {
                        'success': {fn:this.refresh,scope:this}
                    }
                });
            }
            this.createRevaluation.show(e.target);
        }
    });
    msRevaluation.grid.msRevaluation.superclass.constructor.call(this,config)
};
Ext.extend(msRevaluation.grid.msRevaluation,MODx.grid.Grid);
Ext.reg('msrevaluation-grid-msrevaluation',msRevaluation.grid.msRevaluation);