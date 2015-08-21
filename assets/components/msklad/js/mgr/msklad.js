var mSklad = function(config) {
	config = config || {};
	mSklad.superclass.constructor.call(this,config);
};
Ext.extend(mSklad,Ext.Component,{
	page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {},view: {}
});
Ext.reg('msklad',mSklad);

mSklad = new mSklad();