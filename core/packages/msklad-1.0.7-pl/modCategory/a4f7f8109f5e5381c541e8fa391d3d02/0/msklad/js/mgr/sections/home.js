function mskladCheckConfig(){
    var status=0;
    if(MODx.config['msklad_api_username']=='' || MODx.config['msklad_api_password']=='') {
        Ext.getCmp('msklad_button_sync_catalog').disable();
    }
}

Ext.onReady(function() {
	MODx.load({ xtype: 'msklad-page-home'});
    mskladCheckConfig();
});

mSklad.page.Home = function(config) {
	config = config || {};
	Ext.applyIf(config,{
		components: [{
			xtype: 'msklad-panel-home'
			,renderTo: 'msklad-panel-home-div'
		}]
	}); 
	mSklad.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(mSklad.page.Home,MODx.Component);
Ext.reg('msklad-page-home',mSklad.page.Home);