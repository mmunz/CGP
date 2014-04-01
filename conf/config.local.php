<?php

# collectd version
$CONFIG['version'] = 5;

# collectd's datadir
$CONFIG['datadir'] = '/var/lib/collectd/rrd';

# rrdtool executable
$CONFIG['rrdtool'] = '/usr/bin/rrdtool';

# rrdtool special options
$CONFIG['rrdtool_opts'] = '';

# category of hosts to show on main page
#$CONFIG['cat']['category1'] = array('host1', 'host2');

# default plugins to show on host page
$CONFIG['overview'] = array('load', 'cpu', 'memory');

# example of filter to show only the if_octets of eth0 on host page
# (interface must be enabled in the overview config array)
#$CONFIG['overview_filter']['interface'] = array('ti' => 'eth0', 't' => 'if_octets');

# default plugins time range
$CONFIG['time_range']['default'] = 86400;
$CONFIG['time_range']['uptime']  = 31536000;

# show load averages on overview page
$CONFIG['showload'] = true;

#show leases on overview page
$CONFIG['showleases'] = true;

#show leases on overview page
$CONFIG['showuptime'] = true;

#make overview table sortable (uses sortable.js)
$CONFIG['sortable'] = true;



$CONFIG['term'] = array(
	'2hour'	 => 3600 * 2,
	'8hour'	 => 3600 * 8,
	'day'	 => 86400,
	'week'	 => 86400 * 7,
	'month'	 => 86400 * 31,
	'quarter'=> 86400 * 31 * 3,
	'year'	 => 86400 * 365,
);

# show graphs in bits or bytes
$CONFIG['network_datasize'] = 'bytes';

# "png", "svg", "canvas" or "hybrid" (canvas on detail page, png on the others) graphs
$CONFIG['graph_type'] = 'png';

# For canvas graphs, use 'async' or 'sync' fetch method
$CONFIG['rrd_fetch_method'] = 'async';

# use the negative X-axis in I/O graphs
$CONFIG['negative_io'] = false;

# create smooth graphs (rrdtool -E)
$CONFIG['graph_smooth'] = true;

# browser cache time for the graphs (in seconds)
$CONFIG['cache'] = 59;

# page refresh (in seconds)
$CONFIG['page_refresh'] = '60';

# default width/height of the graphs
$CONFIG['width'] = 400;
$CONFIG['height'] = 175;
# default width/height of detailed graphs
$CONFIG['detail-width'] = 800;
$CONFIG['detail-height'] = 350;
# max width/height of a graph (to prevent from OOM)
$CONFIG['max-width'] = $CONFIG['detail-width'] * 2;
$CONFIG['max-height'] = $CONFIG['detail-height'] * 2;

# collectd's unix socket (unixsock plugin)
# enabled: 'unix:///var/run/collectd-unixsock'
# enabled (rrdcached): 'unix:///var/run/rrdcached.sock'
# disabled: NULL
$CONFIG['socket'] = 'unix:///var/run/collectd-unixsock';

# flush rrd data to disk using "collectd" (unixsock plugin)
# or a "rrdcached" server
$CONFIG['flush_type'] = 'collectd';

# system default timezone when not set
$CONFIG['default_timezone'] = 'UTC';


?>
