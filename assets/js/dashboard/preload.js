
function pad(n, width, z) {
  z = z || '0';
  n = n + '';
  return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}

function setv(elm, val) {
    $(elm).val((+val).toFixed(2));
}
function exv(elm) {
    return (!isNaN(parseFloat(elm)))?(+elm):(+($(elm).val()));
}
function sumjson(jsonstr) {
    var sum = 0;
    for (var [key, value] of Object.entries(JSON.parse(jsonstr))) {
        sum += +(value);
    }
    return sum;
}
function sum(elma, elmb) {
    return exv(elma) + exv(elmb);
}

function sub(elma, elmb) {
    return exv(elma) - exv(elmb);
}

function mul(elma, elmb) {
    return exv(elma) * exv(elmb);
}

function div(elma, elmb) {
    return exv(elma) / exv(elmb);
}
function tabval(elm) {
    return sumjson($(elm).val());
}
function ifchd(ckelm, a, b) {
    return ($(ckelm).prop('checked') === true)?exv(a):exv(b);
}

function formatDate(value) {
    var date = new Date(value);
    return pad(date.getDate(),2)+'-'+pad(date.getMonth()+1,2)+'-'+date.getFullYear();
}

function formatDateTime(value) {
    var date = new Date(value);
    return pad(date.getDate(),2)+'-'+pad(date.getMonth()+1,2)+'-'+date.getFullYear()
            +' '+date.getHours()+':'+date.getMinutes()+':'+date.getSeconds();
}

function datediff(a, b) {
    var da = ($(a).val())?new Date($(a).val()):new Date();
    var db = ($(b).val())?new Date($(b).val()):new Date();
    da.setHours(0);
    da.setMinutes(0);
    db.setHours(0);
    db.setMinutes(0);
    var res = Math.round(Math.abs(da - db)/(1000*3600*24));
    return res + 1; //(res === 0)?1:res;
}

function makeDropdownReady(id, model) {
    $(document).ready(function() {
        var drp = $('#'+id);
        
        drp.click(function () {
            $(this).toggleClass('is-active');
            
            e = drp.find('input[type="text"]');
            
            emptyDropDown(drp);
            $.post(e.attr('posturl'), {
                model: e.attr('model'),
                field: e.attr('field'),
                search: e.val(),
                count: 10 
            }).done(function(data){
                data = JSON.parse(data);
                if(Array.isArray(data)) data.forEach(function(v){
                    addDropDown(drp, v[e.attr('field')], v.id);
                });
            });
        });
        
        drp.on('click', 'a[class="dropdown-item"]', function (ev) {
            var inp = drp.find('div[class="dropdown-trigger"] > input[class=input][model='+model+']');
            inp.val($(ev.target).text());
            drp.find('div[class="dropdown-trigger"] > input[type=hidden]').val($(ev.target).attr('itemid'));
            
            if(inp.attr('customevt') !== undefined) {
                eval(inp.attr('customevt'));
            }
        });
    });
}

function fillCountry(elm) {
    countriesdata.countries.forEach(function(v) {
        $(elm).append($('<option>').append(v.country));
    });
}

function fillstates(elm) {
    var country = $(elm).parents('.columns').find('select[type=country]').val();
    var currentval = $(elm).val();
    var l = countriesdata.countries.filter(function(fv) {
        return fv.country === country;
    });
    if (l.length > 0 && !l[0].states.includes(currentval)) {
        $(elm).empty();
        l[0].states.forEach(function(v) {
            $(elm).append($('<option>').append(v));
        });
    } else if (l.length === 0) {
        $(elm).empty();
        $(elm).append($('<option>').append(currentval));
    }
}

function setCheckBoxValue(elm) {
    if ($(elm).is(':checked')) {
        $(elm).val(1);
    } else {
        $(elm).val(0);
    }
}

function updateTableJson(table) {
    var json = {};
        
    var rows = $(table).find('tbody > tr');
    for(j = 0; j < rows.length; j++) {
        var row = $(rows[j]);

        var dat = row.find('td > input');
        if(dat.length > 1) {
            json[dat[0].value] = dat[1].value;
        }
    }
    var jsn = JSON.stringify(json);
    $(table).parent().find('input[class="is-hidden"]').val((jsn.length > 0) ? jsn : '{}');
}

function updateCoalValue(elm) {
    var val = +($(elm).val());
    var sel = $(elm).parents('.columns').find('select').val();
    $(elm).parents('.field').find('input[type=hidden]').val(sel==='Cft' ? val*0.025:val );
}

function toogleDisable(elms) {
    elms.forEach(function (elm) {
        $(elm).prop('disabled', function(i, v) { return !v; });
    });
}

function updateFileName(fileelm) {
    var textelm = $(fileelm).parent().find('span[class=file-name]');
    textelm.text(fileelm.files[0].name);
}

// Only for payroll
function fillLastPaymentDate(modal) {
    var id = $('#payroll-create-employeeid').val();
    var fromdate = $('#payroll-create-frompay');
    var tilldate = $('#payroll-create-tillpay');
    var salarytype = $('#payroll-create-period');
    var payamt = $('#payroll-create-payamt');
    
    $.post('/api/entrybyid', {model: 'employee', id: id}).done(function(data) {
        data = JSON.parse(data);
        salarytype.val(data['salary_type']);
        payamt.val(data['salary_amt']);
        $.post('/api/lastpayment', {emp: id}).done(function(dat) {
            dat = JSON.parse(dat);
            if(!(dat['lastdate'] === '')) {
                var date = new Date(Date.parse(dat['lastdate']));
                data = date.setDate(date.getDate() + 1);
                fromdate.get()[0].valueAsDate = date;
                tilldate.get()[0].valueAsDate = date;
            } else {
                fromdate.val(data['date']);
                tilldate.val(data['date']);
            }
            
            fillAttendanceAndTime();
        });
    });
}

function fillAttendanceAndTime() {
    var id = $('#payroll-create-employeeid').val();
    var fromdate = $('#payroll-create-frompay');
    var tilldate = $('#payroll-create-tillpay');
    var salarytype = $('#payroll-create-period');
    var timeamt = $('#payroll-create-timeamt');
    var attendance = $('#payroll-create-attendance');
    
    $.post('/api/presentcount', {emp: id, fromdate: fromdate.val(), todate: tilldate.val()}).done(function(dat) {
        dat = JSON.parse(dat);
        attendance.val(dat['count']);
        
        var tim = datediff(fromdate, tilldate);
        
        switch(salarytype.val()) {
            case 'WEEKLY':
                tim /= 7;
                break;
            case 'MONTHLY':
                tim /= 30;
                break;
        }
        timeamt.val(tim.toFixed(4));
        setv('#payroll-create-gross', mul('#payroll-create-payamt', '#payroll-create-timeamt'));
        setv('#payroll-create-net', sub(sum(sub('#payroll-create-gross', 
        (mul('#payroll-create-gross','#payroll-create-tax')/100)), tabval('#payroll-create-addition')), tabval('#payroll-create-deduction')));
    });
}

function showAttendanceDetailModal(elm) {
    var id = $('#payroll-create-employeeid').val();
    
    if(!$('#attendance_modal').hasClass('is-active')) $('#attendance_modal').addClass('is-active');
    if(id === '') return;
    
    var fromdate = $('#payroll-create-frompay').val();
    var tilldate = $('#payroll-create-tillpay').val();
    
    var mod = $('#attendetails');
    mod.empty();
    $.post('/api/absentinfo', {emp: id, fromdate: fromdate, todate: tilldate}).done(function(dat) {
        dat = JSON.parse(dat);
        dat.forEach(function(d) {
            mod.append($('<div>', {class: 'details-key'}).append(d['date']));   
            mod.append($('<div>', {class: 'details-value'}).append(d['reason']));   
        });
    });
}

function assetAmountEvents(eamt, estock, erate, ecost, eused) {
    if ($(estock).prop('checked') === true) {
        setv(ecost, mul(eamt, erate));
    } else {
        $(eused).val($(eamt).val());
    }
}

function assetNewstockEvents(estock, erate, eused, ecost, estamt, eamt) {
    if ($(estock).prop('checked') === true) {
        $(erate).prop('readonly', false);
        $(eused).prop('readonly', false);
    } else {
        $(erate).val(0);
        $(eused).val($(eamt).val());
        $(ecost).val(0);
        $(estamt).val(0);
        $(erate).prop('readonly', true);
        $(eused).prop('readonly', true);
    }
}

////