<?php return array (
  '4d9ac6b6ceb52b1f88055da73b3c4b4a' => 
  array (
    'criteria' => 
    array (
      'name' => 'msprofile',
    ),
    'object' => 
    array (
      'name' => 'msprofile',
      'path' => '{core_path}components/msprofile/',
      'assets_path' => '',
    ),
  ),
  '1f3cbe8c5a765c3cb89b180cd91117a6' => 
  array (
    'criteria' => 
    array (
      'category' => 'msProfile',
    ),
    'object' => 
    array (
      'id' => 7,
      'parent' => 0,
      'category' => 'msProfile',
    ),
  ),
  '9c4123048e07e42f18c1d74282d96791' => 
  array (
    'criteria' => 
    array (
      'name' => 'tpl.msProfile.charge.form',
    ),
    'object' => 
    array (
      'id' => 34,
      'source' => 1,
      'property_preprocess' => 0,
      'name' => 'tpl.msProfile.charge.form',
      'description' => '',
      'editor_type' => 0,
      'category' => 7,
      'cache_type' => 0,
      'snippet' => '<form action="[[~[[*id]]]]" method="post">
	<div class="form-group">
		<label for="sum">[[%ms2_profile_enter_sum]]</label>
		<input type="text" class="form-control" name="sum" id="sum" value="[[+sum]]" />
		<div class="error">[[+error_sum]]</div>
	</div>

	<div class="form-group">
		<label>[[%ms2_profile_select_payment]]</label>
		[[+payments]]
		<div class="error">[[+error_payment ]]</div>
	</div>
	[[+error]]
	<input type="hidden" name="action" value="profile_charge" />
	<input type="submit" class="btn btn-primary" value="[[%ms2_profile_pay]]" />
</form>
<!--minishop2_error <div class="alert alert-danger">[[+error]]</div>-->',
      'locked' => 0,
      'properties' => NULL,
      'static' => 0,
      'static_file' => 'core/components/msprofile/elements/chunks/chunk.charge_form.tpl',
      'content' => '<form action="[[~[[*id]]]]" method="post">
	<div class="form-group">
		<label for="sum">[[%ms2_profile_enter_sum]]</label>
		<input type="text" class="form-control" name="sum" id="sum" value="[[+sum]]" />
		<div class="error">[[+error_sum]]</div>
	</div>

	<div class="form-group">
		<label>[[%ms2_profile_select_payment]]</label>
		[[+payments]]
		<div class="error">[[+error_payment ]]</div>
	</div>
	[[+error]]
	<input type="hidden" name="action" value="profile_charge" />
	<input type="submit" class="btn btn-primary" value="[[%ms2_profile_pay]]" />
</form>
<!--minishop2_error <div class="alert alert-danger">[[+error]]</div>-->',
    ),
  ),
  'b4d9c4fadcd3010c4c151f88ef834290' => 
  array (
    'criteria' => 
    array (
      'name' => 'tpl.msProfile.charge.payment',
    ),
    'object' => 
    array (
      'id' => 35,
      'source' => 1,
      'property_preprocess' => 0,
      'name' => 'tpl.msProfile.charge.payment',
      'description' => '',
      'editor_type' => 0,
      'category' => 7,
      'cache_type' => 0,
      'snippet' => '<div class="radio">
	<label>
		<input type="radio" name="payment" value="[[+id]]" id="payment_[[+id]]" [[+checked]] />
		[[+logo:default=`[[+name]]`]]
		[[+description]]
	</label>
</div>
<!--minishop2_logo <img src="[[+logo]]" />-->
<!--minishop2_description <p><small>[[+description]]</small></p>-->',
      'locked' => 0,
      'properties' => NULL,
      'static' => 0,
      'static_file' => 'core/components/msprofile/elements/chunks/chunk.payment_row.tpl',
      'content' => '<div class="radio">
	<label>
		<input type="radio" name="payment" value="[[+id]]" id="payment_[[+id]]" [[+checked]] />
		[[+logo:default=`[[+name]]`]]
		[[+description]]
	</label>
</div>
<!--minishop2_logo <img src="[[+logo]]" />-->
<!--minishop2_description <p><small>[[+description]]</small></p>-->',
    ),
  ),
  '6fcdef53120d0aa518f6e149579ba0f0' => 
  array (
    'criteria' => 
    array (
      'name' => 'msProfile',
    ),
    'object' => 
    array (
      'id' => 19,
      'source' => 1,
      'property_preprocess' => 0,
      'name' => 'msProfile',
      'description' => '',
      'editor_type' => 0,
      'category' => 7,
      'cache_type' => 0,
      'snippet' => '/** @var array $scriptProperties */
/** @var msProfile $msProfile */
$msProfile = $modx->getService(\'msprofile\',\'msProfile\', MODX_CORE_PATH . \'components/msprofile/model/msprofile/\', $scriptProperties);
if (!($msProfile instanceof msProfile)) return \'\';
if (!$modx->user->isAuthenticated($modx->context->key)) {
	return $modx->lexicon(\'ms2_profile_err_auth\');
}
/** @var pdoFetch $pdoFetch */
$fqn = $modx->getOption(\'pdoFetch.class\', null, \'pdotools.pdofetch\', true);
if ($pdoClass = $modx->loadClass($fqn, \'\', false, true)) {
	$pdoFetch = new $pdoClass($modx, $scriptProperties);
}
elseif ($pdoClass = $modx->loadClass($fqn, MODX_CORE_PATH . \'components/pdotools/model/\', false, true)) {
	$pdoFetch = new $pdoClass($modx, $scriptProperties);
}
else {
	$modx->log(modX::LOG_LEVEL_ERROR, \'Could not load pdoFetch from "MODX_CORE_PATH/components/pdotools/model/".\');
	return false;
}

if (empty($id)) {
	$id = $modx->user->get(\'id\');
}

if ($profile = $modx->getObject(\'msCustomerProfile\', $id)) {
	return empty($tpl)
		? \'<pre>\'.$pdoFetch->getChunk(\'\', $profile->toArray()).\'</pre>\'
		: $pdoFetch->getChunk($tpl, $profile->toArray());
}',
      'locked' => 0,
      'properties' => 'a:2:{s:2:"id";a:7:{s:4:"name";s:2:"id";s:4:"desc";s:17:"msprofile_prop_id";s:4:"type";s:11:"numberfield";s:7:"options";a:0:{}s:5:"value";i:0;s:7:"lexicon";s:20:"msprofile:properties";s:4:"area";s:0:"";}s:3:"tpl";a:7:{s:4:"name";s:3:"tpl";s:4:"desc";s:18:"msprofile_prop_tpl";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:20:"msprofile:properties";s:4:"area";s:0:"";}}',
      'moduleguid' => '',
      'static' => 0,
      'static_file' => 'core/components/msprofile/elements/snippets/snippet.msprofile.php',
      'content' => '/** @var array $scriptProperties */
/** @var msProfile $msProfile */
$msProfile = $modx->getService(\'msprofile\',\'msProfile\', MODX_CORE_PATH . \'components/msprofile/model/msprofile/\', $scriptProperties);
if (!($msProfile instanceof msProfile)) return \'\';
if (!$modx->user->isAuthenticated($modx->context->key)) {
	return $modx->lexicon(\'ms2_profile_err_auth\');
}
/** @var pdoFetch $pdoFetch */
$fqn = $modx->getOption(\'pdoFetch.class\', null, \'pdotools.pdofetch\', true);
if ($pdoClass = $modx->loadClass($fqn, \'\', false, true)) {
	$pdoFetch = new $pdoClass($modx, $scriptProperties);
}
elseif ($pdoClass = $modx->loadClass($fqn, MODX_CORE_PATH . \'components/pdotools/model/\', false, true)) {
	$pdoFetch = new $pdoClass($modx, $scriptProperties);
}
else {
	$modx->log(modX::LOG_LEVEL_ERROR, \'Could not load pdoFetch from "MODX_CORE_PATH/components/pdotools/model/".\');
	return false;
}

if (empty($id)) {
	$id = $modx->user->get(\'id\');
}

if ($profile = $modx->getObject(\'msCustomerProfile\', $id)) {
	return empty($tpl)
		? \'<pre>\'.$pdoFetch->getChunk(\'\', $profile->toArray()).\'</pre>\'
		: $pdoFetch->getChunk($tpl, $profile->toArray());
}',
    ),
  ),
  '6798b0d645e214d27b98204f15df9a11' => 
  array (
    'criteria' => 
    array (
      'name' => 'msProfileCharge',
    ),
    'object' => 
    array (
      'id' => 20,
      'source' => 1,
      'property_preprocess' => 0,
      'name' => 'msProfileCharge',
      'description' => '',
      'editor_type' => 0,
      'category' => 7,
      'cache_type' => 0,
      'snippet' => '/** @var array $scriptProperties */
/** @var msProfile $msProfile */
$msProfile = $modx->getService(\'msprofile\',\'msProfile\', MODX_CORE_PATH . \'components/msprofile/model/msprofile/\', $scriptProperties);
if (!($msProfile instanceof msProfile)) return \'\';
if (!$modx->user->isAuthenticated($modx->context->key)) {
	return $modx->lexicon(\'ms2_profile_err_auth\');
}
/** @var pdoFetch $pdoFetch */
$fqn = $modx->getOption(\'pdoFetch.class\', null, \'pdotools.pdofetch\', true);
if ($pdoClass = $modx->loadClass($fqn, \'\', false, true)) {
	$pdoFetch = new $pdoClass($modx, $scriptProperties);
}
elseif ($pdoClass = $modx->loadClass($fqn, MODX_CORE_PATH . \'components/pdotools/model/\', false, true)) {
	$pdoFetch = new $pdoClass($modx, $scriptProperties);
}
else {
	$modx->log(modX::LOG_LEVEL_ERROR, \'Could not load pdoFetch from "MODX_CORE_PATH/components/pdotools/model/".\');
	return false;
}

if (!isset($minSum)) {$minSum = 200;}
if (!isset($maxSum)) {$maxSum = 1000;}
if (empty($outputSeparator)) {$outputSeparator = "\\n";}
if (empty($tplOrder)) {$tplOrder = \'tpl.msOrder.success\';}
if (empty($tplPayment)) {$tplPayment = \'tpl.msProfile.charge.payment\';}
if (empty($tplForm)) {$tplForm = \'tpl.msProfile.charge.form\';}

if (!empty($_GET[\'msorder\'])) {
	if ($order = $modx->getObject(\'msOrder\', $_GET[\'msorder\'])) {
		if ((!empty($_SESSION[\'minishop2\'][\'orders\']) && in_array($_GET[\'msorder\'], $_SESSION[\'minishop2\'][\'orders\'])) || $order->get(\'user_id\') == $modx->user->id || $modx->context->key == \'mgr\') {
			return $pdoFetch->getChunk($tplOrder, array(\'id\' => $_GET[\'msorder\']));
		}
	}
}

$error = \'\';
$errors = array();
if (!empty($_POST[\'action\']) && $_POST[\'action\'] == \'profile_charge\') {
	$response = $msProfile->createPayment($_POST);
	if (!$response[\'success\']) {
		$error = $response[\'message\'];
		$errors = $response[\'data\'];
	}
}

$where = array(\'class:NOT LIKE\' => \'CustomerAccount%\', \'class:!=\' => \'\');
if (empty($showInactive)) {
	$where[\'active\'] = true;
}
if (!empty($payments)) {
	$payments = array_map(\'trim\', explode(\',\', $payments));
	$in = $out = array();
	foreach ($payments as $payment) {
		if ($payment > 0) {
			$in[] = $payment;
		}
		elseif ($payment < 0) {
			$out[] = abs($payment);
		}
	}
	if (!empty($in)) {
		$where[\'id:IN\'] = $in;
	}
	elseif (!empty($out)) {
		$where[\'id:NOT IN\'] = $out;
	}
}

// Add custom parameters
foreach (array(\'where\') as $v) {
	if (!empty($scriptProperties[$v])) {
		$tmp = $modx->fromJSON($scriptProperties[$v]);
		if (is_array($tmp)) {
			$$v = array_merge($$v, $tmp);
		}
	}
	unset($scriptProperties[$v]);
}

$options = array(
	\'class\' => \'msPayment\',
	\'where\' => $where,
	\'sortby\' => \'rank\',
	\'sortdir\' => \'ASC\',
	\'nestedChunkPrefix\' => \'minishop2_\',
);

// Merge all properties and run!
$pdoFetch->addTime(\'Query parameters are prepared.\');
$pdoFetch->setConfig(array_merge($options, $scriptProperties));

$methods = $pdoFetch->getCollection(\'msPayment\', $where, $options);
if (empty($methods)) {
	return $modx->lexicon(\'ms2_profile_err_payments\');
}
$payments = array();
foreach ($methods as $key => $method) {
	$method[\'checked\'] = (empty($_POST[\'payment\']) && $key == 0) || (!empty($_POST[\'payment\']) && $_POST[\'payment\'] == $method[\'id\'])
		? \'checked\'
		: \'\';
	$payments[] = $pdoFetch->getChunk($tplPayment, $method);
}
$payments = implode($outputSeparator, $payments);

$data = array(
	\'payments\' => $payments,
	\'sum\' => !empty($_POST[\'sum\']) ? $_POST[\'sum\'] : $minSum,
	\'min_sum\' => $minSum,
	\'max_sum\' => $maxSum,
	\'error\' => $error,
);
foreach ($errors as $key => $error) {
	$data[\'error_\' . $key] = $error;
}

return $pdoFetch->getChunk($tplForm, $data);',
      'locked' => 0,
      'properties' => 'a:11:{s:7:"tplForm";a:7:{s:4:"name";s:7:"tplForm";s:4:"desc";s:22:"msprofile_prop_tplForm";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:25:"tpl.msProfile.charge.form";s:7:"lexicon";s:20:"msprofile:properties";s:4:"area";s:0:"";}s:10:"tplPayment";a:7:{s:4:"name";s:10:"tplPayment";s:4:"desc";s:25:"msprofile_prop_tplPayment";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:28:"tpl.msProfile.charge.payment";s:7:"lexicon";s:20:"msprofile:properties";s:4:"area";s:0:"";}s:8:"tplOrder";a:7:{s:4:"name";s:8:"tplOrder";s:4:"desc";s:23:"msprofile_prop_tplOrder";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:19:"tpl.msOrder.success";s:7:"lexicon";s:20:"msprofile:properties";s:4:"area";s:0:"";}s:8:"payments";a:7:{s:4:"name";s:8:"payments";s:4:"desc";s:23:"msprofile_prop_payments";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:0:"";s:7:"lexicon";s:20:"msprofile:properties";s:4:"area";s:0:"";}s:6:"sortby";a:7:{s:4:"name";s:6:"sortby";s:4:"desc";s:21:"msprofile_prop_sortby";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:5:"order";s:7:"lexicon";s:20:"msprofile:properties";s:4:"area";s:0:"";}s:7:"sortdir";a:7:{s:4:"name";s:7:"sortdir";s:4:"desc";s:22:"msprofile_prop_sortdir";s:4:"type";s:4:"list";s:7:"options";a:2:{i:0;a:2:{s:4:"text";s:3:"ASC";s:5:"value";s:3:"ASC";}i:1;a:2:{s:4:"text";s:4:"DESC";s:5:"value";s:4:"DESC";}}s:5:"value";s:3:"ASC";s:7:"lexicon";s:20:"msprofile:properties";s:4:"area";s:0:"";}s:5:"limit";a:7:{s:4:"name";s:5:"limit";s:4:"desc";s:20:"msprofile_prop_limit";s:4:"type";s:11:"numberfield";s:7:"options";a:0:{}s:5:"value";i:0;s:7:"lexicon";s:20:"msprofile:properties";s:4:"area";s:0:"";}s:15:"outputSeparator";a:7:{s:4:"name";s:15:"outputSeparator";s:4:"desc";s:30:"msprofile_prop_outputSeparator";s:4:"type";s:9:"textfield";s:7:"options";a:0:{}s:5:"value";s:1:"
";s:7:"lexicon";s:20:"msprofile:properties";s:4:"area";s:0:"";}s:6:"minSum";a:7:{s:4:"name";s:6:"minSum";s:4:"desc";s:21:"msprofile_prop_minSum";s:4:"type";s:11:"numberfield";s:7:"options";a:0:{}s:5:"value";i:200;s:7:"lexicon";s:20:"msprofile:properties";s:4:"area";s:0:"";}s:6:"maxSum";a:7:{s:4:"name";s:6:"maxSum";s:4:"desc";s:21:"msprofile_prop_maxSum";s:4:"type";s:11:"numberfield";s:7:"options";a:0:{}s:5:"value";i:0;s:7:"lexicon";s:20:"msprofile:properties";s:4:"area";s:0:"";}s:12:"showInactive";a:7:{s:4:"name";s:12:"showInactive";s:4:"desc";s:27:"msprofile_prop_showInactive";s:4:"type";s:13:"combo-boolean";s:7:"options";a:0:{}s:5:"value";b:1;s:7:"lexicon";s:20:"msprofile:properties";s:4:"area";s:0:"";}}',
      'moduleguid' => '',
      'static' => 0,
      'static_file' => 'core/components/msprofile/elements/snippets/snippet.msprofile_charge.php',
      'content' => '/** @var array $scriptProperties */
/** @var msProfile $msProfile */
$msProfile = $modx->getService(\'msprofile\',\'msProfile\', MODX_CORE_PATH . \'components/msprofile/model/msprofile/\', $scriptProperties);
if (!($msProfile instanceof msProfile)) return \'\';
if (!$modx->user->isAuthenticated($modx->context->key)) {
	return $modx->lexicon(\'ms2_profile_err_auth\');
}
/** @var pdoFetch $pdoFetch */
$fqn = $modx->getOption(\'pdoFetch.class\', null, \'pdotools.pdofetch\', true);
if ($pdoClass = $modx->loadClass($fqn, \'\', false, true)) {
	$pdoFetch = new $pdoClass($modx, $scriptProperties);
}
elseif ($pdoClass = $modx->loadClass($fqn, MODX_CORE_PATH . \'components/pdotools/model/\', false, true)) {
	$pdoFetch = new $pdoClass($modx, $scriptProperties);
}
else {
	$modx->log(modX::LOG_LEVEL_ERROR, \'Could not load pdoFetch from "MODX_CORE_PATH/components/pdotools/model/".\');
	return false;
}

if (!isset($minSum)) {$minSum = 200;}
if (!isset($maxSum)) {$maxSum = 1000;}
if (empty($outputSeparator)) {$outputSeparator = "\\n";}
if (empty($tplOrder)) {$tplOrder = \'tpl.msOrder.success\';}
if (empty($tplPayment)) {$tplPayment = \'tpl.msProfile.charge.payment\';}
if (empty($tplForm)) {$tplForm = \'tpl.msProfile.charge.form\';}

if (!empty($_GET[\'msorder\'])) {
	if ($order = $modx->getObject(\'msOrder\', $_GET[\'msorder\'])) {
		if ((!empty($_SESSION[\'minishop2\'][\'orders\']) && in_array($_GET[\'msorder\'], $_SESSION[\'minishop2\'][\'orders\'])) || $order->get(\'user_id\') == $modx->user->id || $modx->context->key == \'mgr\') {
			return $pdoFetch->getChunk($tplOrder, array(\'id\' => $_GET[\'msorder\']));
		}
	}
}

$error = \'\';
$errors = array();
if (!empty($_POST[\'action\']) && $_POST[\'action\'] == \'profile_charge\') {
	$response = $msProfile->createPayment($_POST);
	if (!$response[\'success\']) {
		$error = $response[\'message\'];
		$errors = $response[\'data\'];
	}
}

$where = array(\'class:NOT LIKE\' => \'CustomerAccount%\', \'class:!=\' => \'\');
if (empty($showInactive)) {
	$where[\'active\'] = true;
}
if (!empty($payments)) {
	$payments = array_map(\'trim\', explode(\',\', $payments));
	$in = $out = array();
	foreach ($payments as $payment) {
		if ($payment > 0) {
			$in[] = $payment;
		}
		elseif ($payment < 0) {
			$out[] = abs($payment);
		}
	}
	if (!empty($in)) {
		$where[\'id:IN\'] = $in;
	}
	elseif (!empty($out)) {
		$where[\'id:NOT IN\'] = $out;
	}
}

// Add custom parameters
foreach (array(\'where\') as $v) {
	if (!empty($scriptProperties[$v])) {
		$tmp = $modx->fromJSON($scriptProperties[$v]);
		if (is_array($tmp)) {
			$$v = array_merge($$v, $tmp);
		}
	}
	unset($scriptProperties[$v]);
}

$options = array(
	\'class\' => \'msPayment\',
	\'where\' => $where,
	\'sortby\' => \'rank\',
	\'sortdir\' => \'ASC\',
	\'nestedChunkPrefix\' => \'minishop2_\',
);

// Merge all properties and run!
$pdoFetch->addTime(\'Query parameters are prepared.\');
$pdoFetch->setConfig(array_merge($options, $scriptProperties));

$methods = $pdoFetch->getCollection(\'msPayment\', $where, $options);
if (empty($methods)) {
	return $modx->lexicon(\'ms2_profile_err_payments\');
}
$payments = array();
foreach ($methods as $key => $method) {
	$method[\'checked\'] = (empty($_POST[\'payment\']) && $key == 0) || (!empty($_POST[\'payment\']) && $_POST[\'payment\'] == $method[\'id\'])
		? \'checked\'
		: \'\';
	$payments[] = $pdoFetch->getChunk($tplPayment, $method);
}
$payments = implode($outputSeparator, $payments);

$data = array(
	\'payments\' => $payments,
	\'sum\' => !empty($_POST[\'sum\']) ? $_POST[\'sum\'] : $minSum,
	\'min_sum\' => $minSum,
	\'max_sum\' => $maxSum,
	\'error\' => $error,
);
foreach ($errors as $key => $error) {
	$data[\'error_\' . $key] = $error;
}

return $pdoFetch->getChunk($tplForm, $data);',
    ),
  ),
  '5025fd98e305fe16cad4066a5ff657ed' => 
  array (
    'criteria' => 
    array (
      'name' => 'msProfile',
    ),
    'object' => 
    array (
      'id' => 6,
      'source' => 1,
      'property_preprocess' => 0,
      'name' => 'msProfile',
      'description' => '',
      'editor_type' => 0,
      'category' => 7,
      'cache_type' => 0,
      'plugincode' => 'switch ($modx->event->name) {

	case \'OnManagerPageBeforeRender\':
		/** @var modManagerController $controller */
		$controller->msProfile = $msProfile = $modx->getService(\'msprofile\',\'msProfile\', MODX_CORE_PATH . \'components/msprofile/model/msprofile/\');
		$controller->addLexiconTopic(\'msprofile:default\');

		$controller->addJavascript($msProfile->config[\'jsUrl\'] . \'mgr/msprofile.js\');
		$controller->addLastJavascript($msProfile->config[\'jsUrl\'] . \'mgr/widgets/profiles.grid.js\');
		$controller->addLastJavascript($msProfile->config[\'jsUrl\'] . \'mgr/widgets/referrals.grid.js\');
		$controller->addHtml(\'<script type="text/javascript">
		msProfile.config = \'.$modx->toJSON($msProfile->config).\';
		msProfile.config.connector_url = "\'.$msProfile->config[\'connectorUrl\'].\'";
		Ext.ComponentMgr.onAvailable("minishop2-orders-tabs", function() {
			this.on("beforerender", function() {
				this.add({
					title: _("msprofile")
					,id: "msprofile-tab-profiles"
					,items: [{
						html: _("msprofile_intro_msg")
						,border: false
						,bodyCssClass: "panel-desc"
						,bodyStyle: "margin-bottom: 10px"
					},{
						xtype: "msprofile-grid-profiles"
						,preventRender: true
					}]
				});
			});
			Ext.apply(this, {
				activeTab: 0
				,stateful: true
				,stateId: "minishop2-orders-tabs"
				,stateEvents: ["tabchange"]
				,getState: function() {
					return {
						activeTab:this.items.indexOf(this.getActiveTab())
					};
				}
			});
		});
		</script>\');
		break;

	case \'msOnChangeOrderStatus\':
		if (empty($status) || $status != 2) {return;}
		/** @var msOrder $order */
		$properties = $order->get(\'properties\');
		if (empty($properties[\'account_charge\'])) {return;}
		/** @var modUser $user */
		elseif ($user = $order->getOne(\'User\')) {
			/** @var msCustomerProfile $profile */
			if ($profile = $order->getOne(\'CustomerProfile\')) {
				$profile->set(\'account\', $profile->get(\'account\') + $order->get(\'cost\'));
				$profile->save();
			}
			unset($properties[\'account_charge\']);
			$order->set(\'properties\', $properties);
			$order->save();
		}
		break;

	case \'msOnBeforeCreateOrder\':
		/** @var msOrder $msOrder */
		if ($payment = $msOrder->getOne(\'Payment\')) {
			$class = $payment->get(\'class\');
			if (preg_match(\'/^CustomerAccount/i\', $class)) {
				/** @var msPayment $payment */
				$payment->loadHandler();
				if ($payment->handler instanceof CustomerAccount && !$payment->handler->check($msOrder)) {
					$modx->lexicon->load(\'msprofile:default\');
					$modx->event->output($modx->lexicon(\'ms2_profile_err_balance\'));
				}
			}
		}
		break;

}',
      'locked' => 0,
      'properties' => NULL,
      'disabled' => 0,
      'moduleguid' => '',
      'static' => 0,
      'static_file' => 'core/components/msprofile/elements/plugins/plugin.msprofile.php',
      'content' => 'switch ($modx->event->name) {

	case \'OnManagerPageBeforeRender\':
		/** @var modManagerController $controller */
		$controller->msProfile = $msProfile = $modx->getService(\'msprofile\',\'msProfile\', MODX_CORE_PATH . \'components/msprofile/model/msprofile/\');
		$controller->addLexiconTopic(\'msprofile:default\');

		$controller->addJavascript($msProfile->config[\'jsUrl\'] . \'mgr/msprofile.js\');
		$controller->addLastJavascript($msProfile->config[\'jsUrl\'] . \'mgr/widgets/profiles.grid.js\');
		$controller->addLastJavascript($msProfile->config[\'jsUrl\'] . \'mgr/widgets/referrals.grid.js\');
		$controller->addHtml(\'<script type="text/javascript">
		msProfile.config = \'.$modx->toJSON($msProfile->config).\';
		msProfile.config.connector_url = "\'.$msProfile->config[\'connectorUrl\'].\'";
		Ext.ComponentMgr.onAvailable("minishop2-orders-tabs", function() {
			this.on("beforerender", function() {
				this.add({
					title: _("msprofile")
					,id: "msprofile-tab-profiles"
					,items: [{
						html: _("msprofile_intro_msg")
						,border: false
						,bodyCssClass: "panel-desc"
						,bodyStyle: "margin-bottom: 10px"
					},{
						xtype: "msprofile-grid-profiles"
						,preventRender: true
					}]
				});
			});
			Ext.apply(this, {
				activeTab: 0
				,stateful: true
				,stateId: "minishop2-orders-tabs"
				,stateEvents: ["tabchange"]
				,getState: function() {
					return {
						activeTab:this.items.indexOf(this.getActiveTab())
					};
				}
			});
		});
		</script>\');
		break;

	case \'msOnChangeOrderStatus\':
		if (empty($status) || $status != 2) {return;}
		/** @var msOrder $order */
		$properties = $order->get(\'properties\');
		if (empty($properties[\'account_charge\'])) {return;}
		/** @var modUser $user */
		elseif ($user = $order->getOne(\'User\')) {
			/** @var msCustomerProfile $profile */
			if ($profile = $order->getOne(\'CustomerProfile\')) {
				$profile->set(\'account\', $profile->get(\'account\') + $order->get(\'cost\'));
				$profile->save();
			}
			unset($properties[\'account_charge\']);
			$order->set(\'properties\', $properties);
			$order->save();
		}
		break;

	case \'msOnBeforeCreateOrder\':
		/** @var msOrder $msOrder */
		if ($payment = $msOrder->getOne(\'Payment\')) {
			$class = $payment->get(\'class\');
			if (preg_match(\'/^CustomerAccount/i\', $class)) {
				/** @var msPayment $payment */
				$payment->loadHandler();
				if ($payment->handler instanceof CustomerAccount && !$payment->handler->check($msOrder)) {
					$modx->lexicon->load(\'msprofile:default\');
					$modx->event->output($modx->lexicon(\'ms2_profile_err_balance\'));
				}
			}
		}
		break;

}',
    ),
  ),
  'd555bd533bb71d8964c1fbc62c6e4871' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 6,
      'event' => 'OnManagerPageBeforeRender',
    ),
    'object' => 
    array (
      'pluginid' => 6,
      'event' => 'OnManagerPageBeforeRender',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '241b395b16ab5f884f2242f40d4fba81' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 6,
      'event' => 'msOnChangeOrderStatus',
    ),
    'object' => 
    array (
      'pluginid' => 6,
      'event' => 'msOnChangeOrderStatus',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
  '30e8ac61507d135da6d5285a2f9ac7c9' => 
  array (
    'criteria' => 
    array (
      'pluginid' => 6,
      'event' => 'msOnBeforeCreateOrder',
    ),
    'object' => 
    array (
      'pluginid' => 6,
      'event' => 'msOnBeforeCreateOrder',
      'priority' => 0,
      'propertyset' => 0,
    ),
  ),
);