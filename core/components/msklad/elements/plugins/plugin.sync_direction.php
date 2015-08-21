<?php

switch($modx->event->name) {
    case 'OnSiteSettingsRender':
        $modx->controller->addLexiconTopic('msklad:default');
        $modx->controller->addHtml('<script type="text/javascript">
                // This a demo combo, instead use your own with your processor to load your "options"
                var mskladDirectionXtype = function(config) {
                    Ext.apply(config, {
                        store: new Ext.data.SimpleStore({
                            fields: ["data","value"]
                            ,data: [
                                [_(\'msklad_sync_direction_ms2_to_service\'), "0"]
                                ,[_(\'msklad_sync_direction_service_to_ms2\'), "1"]
                            ]
                        })
                        ,displayField: "data"
                        ,valueField: "value"
                        ,mode: "local"
                    });
                    mskladDirectionXtype.superclass.constructor.call(this, config);
                };
                Ext.extend(mskladDirectionXtype, MODx.combo.ComboBox);
                Ext.reg("msklad-combo-direction", mskladDirectionXtype);

                Ext.onReady(function() {
                    Ext.override(MODx.combo.xType, {
                        listeners: {
                            afterRender: {
                                fn: function(elem) {
                                    var store = elem.getStore();
                                    // Add your custom xtype(s)
                                    var newXtypes = [
                                        new Ext.data.Record({
                                            d: "mSklad sync direction"
                                            ,v: "msklad-combo-direction"
                                        })
                                    ];
                                    store.add(newXtypes);
                                }
                                ,scope: this
                            }
                        }
                    });
            });
            </script>');
        break;
}

return;