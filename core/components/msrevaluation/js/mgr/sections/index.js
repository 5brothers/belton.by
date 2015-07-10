Ext.onReady(function() {
    MODx.load({ xtype: 'msrevaluation-page-home'});
});
 
msRevaluation.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'msrevaluation-panel-home'
            ,renderTo: 'msrevaluation-panel-home-div'
        }]
    });
    msRevaluation.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(msRevaluation.page.Home,MODx.Component);
Ext.reg('msrevaluation-page-home',msRevaluation.page.Home); 