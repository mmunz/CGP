<?php

# Collectd olsrd Plugin

require_once 'conf/common.inc.php';
require_once 'type/Default.class.php';
require_once 'inc/collectd.inc.php';

$obj = new Type_Default($CONFIG);
$obj->data_sources = array('value');
$obj->ds_names = array('value' => 'Value');
$obj->colors = array('value' => '0000f0');
$obj->rrd_format = '%6.1lf';
$obj->width = 500;


switch($obj->args['pinstance']) {
	case 'links':
		switch($obj->args['type']) {
			case 'links':
				$obj->rrd_title = 'Number of links';
				$obj->rrd_format = '%6.0lf';
				break;
			case 'signal_quality':
				$obj->rrd_title = sprintf('Link Quality %s', $obj->args['tinstance']);
				$obj->colors = null;
				break;
		}
		break;
	case 'routes':
		switch($obj->args['type']) {
			case 'routes':
				$obj->rrd_title = 'Number of routes';
				$obj->rrd_format = '%6.0lf';
				break;
			case 'route_etx':
				$obj->rrd_title = 'etx avarage of routes';
				$obj->rrd_vertical = '%';
				break;
			case 'route_metric':
				$obj->rrd_title = 'metric avarge of routes';
				$obj->rrd_format = '%6.0lf';
				break;
		}
		break;
	case 'topology':
		switch($obj->args['type']) {
			case 'links':
				$obj->rrd_title = 'Number of Topo. Links';
				$obj->rrd_format = '%6.0lf';
				break;
			case 'signal_quality':
				$obj->rrd_title = sprintf('Link Quality of Topo. %s', $obj->args['tinstance']);
				break;
		}
		break;
}

collectd_flush($obj->identifiers);
$obj->rrd_graph();
