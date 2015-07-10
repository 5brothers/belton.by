msRevaluation.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h2>'+_('revaluation.management')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
            },{
            xtype: 'modx-tabs'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,items: [{
                title: _('revaluation')
                ,defaults: { autoHeight: true }
                ,items: [/*{
                    html: '<p>'+_('revaluation.desc')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },*/{
                    xtype: 'msrevaluation-grid-msrevaluation'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                }]
            },{
                title: _('help')
                ,defaults: { autoHeight: true }
                ,items: [{
                        html: _('help.text')
                        ,border: false
                        ,bodyCssClass: 'panel-desc'
                    }]
                }]
        }]
    });
    msRevaluation.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(msRevaluation.panel.Home,MODx.Panel);
Ext.reg('msrevaluation-panel-home',msRevaluation.panel.Home);