/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//var spinner = new Spinner().spin();

function addListener(element, type, callBack) {
	if(window.addEventListener)	{
		element.addEventListener(type, callBack, false);
	} else if(window.attachEvent) {
		element.attachEvent('on' + type, callBack);
	}
}

function show() {
	this.style.background = '#e3e3e3';
	this.children[1].style.display = 'block';
//        this.children[1].appendChild(spinner.el);
        data = this.children[1].children[2].dataset;
       
        if(data.src != '' && data.src != 'undefined') {
            // add a timestamp that changes every minute to force reloading the image
            var d=new Date();
            var ts=Math.round(d.getTime() / 60000);
            this.children[1].children[2].innerHTML = '<img src="' + data.src + '&ts=' + ts +'" />';
        }
        
}

function hide() {
	this.style.background = '#eee';
	this.children[1].style.display = 'none';
        //this.children[1].removeChild(spinner.el);
        this.children[1].children[2].innerHTML = '';
        
} 

function init() {
	var divArray = document.getElementsByTagName('div'); 
	for (i=0;i<divArray.length;i++) {
		if (divArray[i].getAttribute('class') === 'container') {
			addListener(divArray[i], 'mouseover', show);
			addListener(divArray[i], 'mouseout', hide);
		}
	}
} 



// let's get ready to rumble!
addListener(window, 'load', init);

function listItem(label, value) {
    return '<li><label>' + label + '</label> ' + value;
}

function formatDetail(sum, details, legend, graphUrl) {
    if (graphUrl === null) {
        graphUrl = '';
    }
    return '<div class="container">' + sum + '<div class="detail"><ul>' + details + '</ul><legend>' + legend + '</legend><div class="graph" data-src="' + graphUrl + '"></div></div></div>'
}

function detailLink(host, plugin, value, summary) {
    if (summary === true) {
        return '<a href=host.php?h=' + host + '&p=' + plugin + ' title="Show all graphs">' + value + '</a>';
    } else {
        return '<a href="detail.php?p=' + plugin + '&c=&pi=&t=' + plugin + '&h=' + host + '&s=86400&x=800&y=350" title="Show detail graph">' + value + '</a>';
    }
}

function graphUrl(host, plugin, timespan) {
    return 'graph.php?p=' + plugin + '&c=&pi=&t=' + plugin + '&h=' + host + '&s=' + timespan + '&x=220&y=80'
}

function toKbit(value) {
    return Math.round(value / 1024 * 8);
}

if (window.XMLHttpRequest){
    xmlhttpp=new XMLHttpRequest();
} else {
    xmlhttpp=new ActiveXObject("Microsoft.XMLHTTP");
}

function ajaxreq() {
    xmlhttpp.onreadystatechange=function() {
    if (xmlhttpp.readyState==4 && xmlhttpp.status==200) {
            var hostsTotal = 0;
            json = JSON.parse(xmlhttpp.responseText);
            hostsTotal = Object.keys(json).length;
            for (var host in json) {
                // uptime
                if ('uptime' in json[host] ) {
                    uptime = json[host]['uptime']
                    if (uptime && 'value' in uptime) {
                        uptime = uptime['value'] / 86400
                        var graph = graphUrl(host, 'uptime', '5184000');
                        document.getElementById(host + '-uptime').innerHTML=formatDetail(detailLink(host, 'uptime', uptime.toFixed(2) + ' days', false), '', '', graph);
                    }
                    else {
                        document.getElementById(host + '-uptime').innerHTML='-';
                    }
                } else {
                    document.getElementById(host + '-uptime').innerHTML='-';
                }
                // load
                if ('load' in json[host] ) {
                    load = json[host]['load']
                    if (load && 'shortterm' in load) {
                        loadshort = load['shortterm']
                        var details = listItem("1 min avg", loadshort);
                        if('midterm' in load) details += listItem("5 min avg", load['midterm']);
                        if('longterm' in load) details += listItem("15 min avg", load['longterm']);
                        var graph = graphUrl(host, 'load', '3600');
                        document.getElementById(host + '-load').innerHTML=formatDetail(detailLink(host, 'load', loadshort.toFixed(2), false), details, '', graph);
                    } else {
                       document.getElementById(host + '-load').innerHTML='-';
                    }
                } else {
                    document.getElementById(host + '-load').innerHTML='-';
                }
                // leases
                if ('splash_leases' in json[host] ) {
                    leases = json[host]['splash_leases'];
                    if (leases && 'leased' in leases && 'whitelisted' in leases) {
                        leased = leases['leased'];
                        whitelisted = leases['whitelisted'];
                        total = leased + whitelisted;
                        var graph = graphUrl(host, 'splash_leases', '43200');
                        document.getElementById(host + '-clients').innerHTML=formatDetail(detailLink(host, 'splash_leases', total, false), '', '', graph);
                    } else {
                        document.getElementById(host + '-clients').innerHTML='-';
                    } 
                } else {
                    document.getElementById(host + '-clients').innerHTML='-';
                }
                // traffic
                if ('interface' in json[host] ) {

                    interfaces = json[host]['interface'];

                    tx = false;
                    rx = false;
                    details = ''
                    for (i in interfaces) {
                        var txif = interfaces[i]['tx']
                        var rxif = interfaces[i]['rx']

                        if (typeof(txif) === 'number' && typeof(rxif) === 'number') {
                            if (tx == false) tx = 0
                            if (rx == false) rx = 0                        
                            tx = tx + txif
                            rx = rx + rxif
                            details += listItem(i, toKbit(txif) + ' / ' + toKbit(rxif))
                        }
                    }
                    if (rx != false && tx != false) {
                        var sum = toKbit(tx + rx)

                        document.getElementById(host + '-interfaces').innerHTML=formatDetail(detailLink(host, 'interface', sum, true), details, 'TX/RX in kbit/s', null);
                    } else {
                        document.getElementById(host + '-interfaces').innerHTML='-';
                    }
                } else {
                    document.getElementById(host + '-interfaces').innerHTML='-';
                }
            }
            init();
            document.getElementById('hosts-total').innerHTML=hostsTotal;
            window.setTimeout("ajaxreq()", 10000);
        }
    }

    xmlhttpp.open("GET","json/latest.json",true);
    xmlhttpp.send();
}

ajaxreq();