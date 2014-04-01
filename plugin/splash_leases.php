<?php

# Collectd Load plugin

require_once 'conf/common.inc.php';
require_once 'type/Default.class.php';
require_once 'inc/collectd.inc.php';

## LAYOUT
# splash_leases/splash_leases.rrd

$obj = new Type_Default($CONFIG);
$obj->data_sources = array('leased', 'blacklisted', 'whitelisted');
$obj->ds_names = array(
	'leased' => 'Leased',
	'whitelisted' => 'Whitelisted',
	'blacklisted' => 'Blacklisted',
);
$obj->colors = array(
	'leased' => '0000ff',
	'whitelisted' => '00ff00',
	'blacklisted' => '000000',
);
$obj->rrd_title = 'Splash Leases';
$obj->rrd_vertical = 'Splash Leases';
$obj->rrd_format = '%.2lf';

collectd_flush($obj->identifiers);
$obj->rrd_graph();
