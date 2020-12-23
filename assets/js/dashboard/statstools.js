// Chart
var colours = [
    'rgba(0, 153, 127, 0.5)',
    'rgba(0, 100, 255, 0.5)',
    'rgba(255, 80, 0, 0.5)',
    'rgba(0, 0, 225, 0.5)'
];

var months = ['Jan', 'Feb', 'March', 'April', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

function prepareChartArea(cav, timeperiod, val) {
    if($(window).width() <= 400) cav.attr('height',$(window).width() * 0.666);
    
    var chart = new Chart(cav, {
        type: 'line',
        data: {
            labels: [], 
            datasets: []
        }
    });
    
    var data = [];
    data = getChartData(data, val, drawChartArea, chart);

    $(timeperiod).on('change', function(e) {
        drawChartArea(chart, data, this.value.toLowerCase());
    });
}

function getChartData(data, val, fun, chart) {
    var dt = new Date();
    var v = val[0];
    $.post(v['api'], {
        model: v['model'],
        field: v['field'],
        date: dt.getFullYear() + "-" + (dt.getMonth()+1) + "-" + dt.getDate()
    }).done(function (da) {
        da = JSON.parse(da);
        da['label'] = v['label'];
        data.push(da);
        val.shift();
        if(val.length > 0) data = getChartData(data, val, fun, chart);
        else {
            fun(chart, data, 'month');
        }
    });
    return data;
}


function getTimeperiodLabel(val, type) {
    switch(type) {
        case 'week':
            val = val.split('-');
            val = months[(+val[2])-1] + ' ' + val[1];
            break;
        case 'month':
            val = val.split('-');
            val = months[(+val[0])-1] + ' ' + val[1];
            break;
        case 'year':
            val = val.split('-');
            val = months[(+val[1])-1] + ' ' + val[0];
            break;
    }
    return val;
}

function drawChartArea(chart, data, timeperiod) {    
    chart.data.datasets = [];
    chart.data.labels =[];
    data.forEach(function(dat, i) {
        var label = dat['label'];
        dat = dat[timeperiod];
        var keys = Object.keys(dat);
        var labels = [];
        var dataset = [];
        keys.forEach(function (key) {
            labels.push(getTimeperiodLabel(key, timeperiod));
            dataset.push(dat[key]);
        });
        chart.data.labels = labels;
        chart.data.datasets.push({
            label: label,
            data: dataset,
            backgroundColor: colours[i]
        });
    });
    
    chart.update();
}

function prepareBarArea(par, api, title, fields, expand) {    
    $.post(api).done(function (data){
        data = JSON.parse(data);
        
        if(!Array.isArray(data)) data = [data];
        
        data.forEach(function (dat) {
            var cnt = $('<div>',{ class: 'card-content'});
            
            cnt.append($('<div>', {class: 'has-text-centered'})
                    .append($('<label>', {class: 'subtitle has-text-weight-bold has-text-link-dark'})
                    .append((dat[title] !== undefined) ? dat[title] : title))).append('<hr>');
            
            var lev = $('<div>', {class: 'level'});
                        
            Object.keys(fields).forEach(function (da) {
                lev.append(
                    $('<div>', {class: 'level-item has-text-centered'}).append($('<div>')
                        .append($('<a>', {class: 'heading'}).append(fields[da]))
                        .append($('<a>', {class: 'subtitle'}).append((+dat[da]).toFixed(2)))
                    )
                );
            });
            cnt.append(lev);
            
            $(par).append(
                    $('<div>',{ class: expand ? 'flow-full' : 'flow-child'}).append(
                    $('<div>',{ class: 'card'}).append(cnt)));
        });
    });
}

function pad(n, width, z) {
  z = z || '0';
  n = n + '';
  return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}

function formatDate(value) {
    var date = new Date(value);
    return pad(date.getDate(),2)+'-'+pad(date.getMonth()+1,2)+'-'+date.getFullYear();
}

function getElmForType(value, type) {
    switch(type) {
        case undefined:
        case false:
        case null :
        case '':
            return 'NA';
        case 'bool':
            var label = $('<label>', {class: 'checkbox'});
            label.append($('<input>',{type: 'checkbox', disabled: true, checked: (value === '0')?false:true}));
            return label;
        case 'decimal':
            return (+value).toFixed(2);
        case 'date':
            return (value !== null && !value.startsWith('0000-00-00')) ? formatDate(value): 'NA';
        default: return value;
    }
}


function prepareTableArea(tbody, api, model, filters, fields) {   
    var request_params = {
        model: model, 
        count: 10, 
        offset: 0, 
        orderby: 'date', 
        order: 'DESC', 
        filters: JSON.stringify(filters)
    };

    $.post(api, request_params).done(function (data) {
        data = JSON.parse(data);
        data.forEach(function(dat) {
            var tr_elm = $('<tr>');
            
            Object.keys(fields).forEach(function(field) {
                var td_elm = $('<td>');
                var type = fields[field];
                if (field.split('.')[0] in dat) {
                    if (field.includes('.')) {
                        var v = null;
                        var path = field.split('.');
                        v = dat[path[0]];
                        path.shift();
                        path.forEach(function(c) {
                            if (v === null) {
                                return;
                            }
                            v = v[c];
                        });
                        td_elm.append(getElmForType(v,type));
                    } else {
                        td_elm.append(getElmForType(dat[field], type));
                    }
                }
                tr_elm.append(td_elm);
            });

            tbody.append(tr_elm);
        });
    });
}

function prepareAssetsArea(par, expand) {    
    $.post('/api/depots').done(function (depots) {
        depots = JSON.parse(depots);
        depots.forEach(function (depot) {
            $.post('/api/assets', {depot: depot['id']}).done(function (data){
                data = JSON.parse(data);
                
                var cnt = $('<div>',{ class: 'card-content'});

                cnt.append($('<div>', {class: 'has-text-centered'})
                        .append($('<label>', {class: 'subtitle has-text-weight-bold has-text-link-dark'})
                        .append(depot['name']))).append('<hr>');

                var table =$('<table>', {class: 'table is-bordered is-striped is-narrow is-hoverable is-fullwidth'});

                table.append($('<thead>', {class: 'table-head'}).append($('<tr>')
                        .append($('<th>').append('Type'))
                        .append($('<th>').append('Quantity'))));

                tbody = $('<tbody>');

                data.forEach(function (dat) {
                    tbody.append($('<tr>')
                            .append($('<td>').append(dat['name']))
                            .append($('<td>').append((+dat['amount']).toFixed(2))));
                });

                table.append(tbody);
                cnt.append($('<div>', {style: 'overflow-x: auto;'}).append(table));
                $(par).append(
                        $('<div>',{ class: expand ? 'flow-full' : 'flow-child'}).append(
                        $('<div>',{ class: 'card'}).append(cnt)));
            });
        });
    });
}