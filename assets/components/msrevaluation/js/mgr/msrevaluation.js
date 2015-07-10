var msRevaluation = function(config) {
    config = config || {};
    msRevaluation.superclass.constructor.call(this,config);
};
Ext.extend(msRevaluation,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config:{},form:{}
});
Ext.reg('msrevaluation',msRevaluation);
msRevaluation = new msRevaluation();