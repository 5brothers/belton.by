<?php
/**
 * Build the setup options form.
 */
$exists = false;
$values=array();
$output = null;
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:

    case xPDOTransport::ACTION_UPGRADE:

        break;

    case xPDOTransport::ACTION_UNINSTALL: break;
}

return $output;