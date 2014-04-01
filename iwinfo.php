<?php

# Collectd iwinfo Plugin

require_once 'conf/common.inc.php';
require_once 'type/GenericStacked.class.php';
require_once 'inc/collectd.inc.php';


$obj = new Type_GenericStacked($CONFIG);
$obj->data_sources = array('value');
$obj->ds_names = array('value' => 'Value');
$obj->colors = array('value' => '0000f0');
$obj->rrd_format = '%6.1lf';

switch($obj->args['type']) {
	case 'bitrate':
		$obj->rrd_title = sprintf('Bitrate (%s)', $obj->args['pinstance']);
		$obj->rrd_vertical = 'Mb/s';
		$obj->scale = '0.000001';
		break;
	case 'signal_noise':
		$obj->rrd_title = sprintf('Noise level (%s)', $obj->args['pinstance']);
		$obj->rrd_vertical = 'dBm';
		break;
	case 'signal_power':
		$obj->rrd_title = sprintf('Signal level (%s)', $obj->args['pinstance']);
		$obj->rrd_vertical = 'dBm';
		break;
	case 'signal_quality':
		$obj->rrd_title = sprintf('Link Quality (%s)', $obj->args['pinstance']);
		$obj->rrd_vertical = 'quality';
		break;
	case 'stations':
		$obj->rrd_title = sprintf('Number of Stations (%s)', $obj->args['pinstance']);
		$obj->rrd_vertical = 'No.';
		break;
}

collectd_flush($obj->identifiers);
$obj->rrd_graph();
