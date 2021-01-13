var entriesdata = [];

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
        case 'datetime':
            return (value !== null && !value.startsWith('0000-00-00')) ? formatDateTime(value): 'NA';
        case 'img':
            var felm = $('<figure>', {class:'image is-96x96 is-4by5'});
            felm.append($('<img>', {src: value}));
            return felm;
        default: return value;
    }
}

function addFieldTable(tbody_elm, val, offset) {
    var tr_elm = $('<tr>', {'elmid':val.id, id:'elm-'+val.id});
    tr_elm.attr('offset', offset);
    
    tableattrs.fields.forEach(function(field) {
        var td_elm = $('<td>');
        var name = Object.keys(field)[0];
        var type = field[name];
        if (name.split('.')[0] in val) {
            if (name.includes('.')) {
                var v = null;
                var path = name.split('.');
                v = val[path[0]];
                path.shift();
                path.forEach(function(c) {
                    if (v === null) {
                        return;
                    }
                    v = v[c];
                });
                td_elm.append(getElmForType(v,type));
            } else {
                td_elm.append(getElmForType(val[name], type));
            }
        }
        tr_elm.append(td_elm);
    });
    
    td_elm = $('<td>');
    
    if(canDelete) {
        icon = $('<i>', {class:'fas fa-edit mx-1', 'aria-hidden':'true'});
        a_elm = $('<a>', {class:'button is-small mx-1 my-1 is-link', elmid:val.id, onclick:'showEditModal(this)'});
        a_elm.attr('offset', offset);
        a_elm.append(icon);
        a_elm.append('Edit');
        td_elm.append(a_elm);
    }
    
    icon = $('<i>', {class:'fas fa-info-circle mx-1', 'aria-hidden':'true'});
    a_elm = $('<a>', {class:'button is-small mx-1 my-1 is-info', elmid:val.id, onclick:'showDetailsModal(this)'});
    a_elm.attr('offset', offset);
    a_elm.append(icon);
    a_elm.append('Details');
    td_elm.append(a_elm);
    
    if(canDelete) {
        icon = $('<i>', {class:'fas fa-trash mx-1', 'aria-hidden':'true'});
        a_elm = $('<a>', {class:'button is-small mx-1 my-1 is-danger', elmid:val.id, onclick:'showDeleteModal(this)'});
        a_elm.append(icon);
        a_elm.append('Delete');
        td_elm.append(a_elm);
    }
    
    tr_elm.append(td_elm);
    
    tbody_elm.append(tr_elm);
}

function pushError(elm, error) {
    elm.find('label[name=message]').text(error);
}

function errorJSONDig(json) {
    json = json['errors'];
    if('validation' in json) {
        errs = Object.keys(json['validation']);
        return json['validation'][errs[0]];
    } else if('database' in json) {
        errs = Object.keys(json['database']);
        return json['database'][errs[0]];
    } else {
        return 'Failed to make entries!';
    }
}

function varselPrepare(modal, form){
    var sels = $(form).find('div.dropdown');
    var status = true;
    
    for(i = 0; i < sels.length; i++) {
        var sel = $(sels[i]);
        
        var hid = sel.find('input[type=hidden]');
        var inp = sel.find('input[class=input]');
        if(hid.val().length <= 0 && hid.attr('model') !== undefined) {            
            rdata = {
                model: hid.attr('model')
            };
            rdata[inp.attr('field')] = inp.val();
            
            jQuery.ajax({
                type: 'POST',
                url: '/api/putentry',
                data: rdata,
                async:   false,
                success: function(data){
                    data = JSON.parse(data);
                    if('errors' in data) {
                        status = false;
                        pushError(modal, errorJSONDig(data));
                    } else if('id' in data) {
                        hid.attr('value',data['id']);
                    }
                },
                error: function() {
                    pushError(modal,'Failed!');
                }
            });
            
        }
    }
    return status;
}

function addMissingChecks(form, fd){
    var boxes = $(form).find('input[type=checkbox]');
    
    for(i = 0; i < boxes.length; i++) {
        var box = $(boxes[i]);
        
        if (box.prop('disabled' === true))
            continue;
        
        if(box.prop('checked') === false) {
            fd.push({name: box.attr('name'), value: 0});
        }
    }
    
    return fd;
}

function uploadFiles(url, file, name) {
    
}

function resolveFiles(form, fd) {
    var uploads = $(form).find('input[type=file]');
    
    for(i = 0; i < uploads.length; i++) {
        var upload = $(uploads[i]);
        var files = (upload[0]).files;
        var name = upload.attr('name');
        var tourl = upload.attr('tourl');
        if (files.length >0 ) {
            var fdd = new FormData();
            fdd.append(name, files[0]);
            $.ajax({
                url: tourl,
                data: fdd,
                processData: false,
                contentType: false,
                type: 'POST',
                async: false,
                success: function(data){
                    fd.push({name: name, value: data});
                }
            });
        }
    }
    return fd;
}

function createEntry(modal, form) {
    if(!varselPrepare(modal,form)) return;
    
    var fd = form.serializeArray();
    fd = addMissingChecks(form, fd);
    fd = resolveFiles(form, fd);
    
    fd = fd.filter(function (val) {
        if (typeof val === 'string' && val && !val.startsWith('0000-00-00')) {
            return true;
        } else if (typeof val === 'number') {
            return true;
        } else if (typeof val !== 'number' && val) {
            return true;
        }
        return false;
    });
    
    fd.push({name: 'model', value: form.attr('model')});
    $.post(tableattrs.putentry, fd).done(function(data){
        data = JSON.parse(data);
        if('errors' in data) {
            pushError(modal, errorJSONDig(data));
        } else {
            activateProgress();
            resetTable(false);
            modal.toggleClass('is-active');
        }
    });
}
function editEntry(modal, form) {
    var id = $(modal).attr('elmid');
    var entry = entriesdata[$(modal).attr('offset')];
    
    if(!varselPrepare(modal,form)) return;
    var fd = form.serializeArray();
    
    fd = addMissingChecks(form, fd);
    fd = resolveFiles(form, fd);
    if (form.attr('model') === 'rent') {
        fd = fd.filter(function (val) {
            if (typeof val !== 'number' && val) {
                return true;
            } else if (typeof val === 'number') {
                return true;
            }
        });
    } else {
        fd = fd.filter(function (val) {
            var path = form.find('[name='+val.name+']').attr('fill').split('.');
            
            if (!(path[0] in entry)) return false;
            var data = entry[path[0]];
            path.shift();
            path.forEach(function(c) {
                if (data === null || data === undefined) {
                    return;
                }
                data = data[c];
            });
            
            if (typeof data === 'number') {
                return data !== parseFloat(val.value);
            } else if (typeof val.value === 'number') {
                return parseFloat(data) !== val.value;
            } else {
                return data !== val.value;
            }
        });
    }
    
    if (fd.length === 0) {
        form.parents('.modal').toggleClass('is-active');
        return;
    }
    fd.push({name: 'model', value: form.attr('model')});
    fd.push({name: 'id', value: id });
    
    $.post(tableattrs.putentry, fd).done(function(data){
        data = JSON.parse(data);
        if('errors' in data) {
            pushError(modal, errorJSONDig(data));
        } else {
            activateProgress();
            resetTable(false);
            modal.toggleClass('is-active');
        }
    });
}
function changepasswordEntry(modal, form) {
    var fd = form.serializeArray();
    fd.push({name: 'id', value: $(modal).attr('elmid')});
    
    $.post('/api/changepass', fd).done(function(data){
        data = JSON.parse(data);
        if('errors' in data) {
            pushError(modal, errorJSONDig(data));
        } else {
            activateProgress();
            resetTable(false);
            modal.toggleClass('is-active');
        }
    });
}
function filterEntry(modal, form) {
    var filter = {};
    var picked = false;
    
    var fd = $(form).serializeArray();
    
    fd = addMissingChecks(form, fd);
    
    fd.forEach(function(d, i) {
        var val = d['value'];
        if(typeof val === 'string' && val.length > 0) {
            filter[d['name']] = d['value'];
            picked = true;
        } else if (typeof val === 'number') {
            filter[d['name']] = d['value'];
            picked = true;
        }
    });

    if(picked)  {
        $('#filter_clean').addClass('is-info');
        $('#filter_clean').removeClass('is-light');
    } else {
        $('#filter_clean').addClass('is-light');
        $('#filter_clean').removeClass('is-info');
    }
    
    attrs.filters = filter;
    activateProgress();
    resetTable(true);
    modal.toggleClass('is-active');
}
function deleteEntry(modal, form) {
    var elmid = $(modal).attr('elmid');
    $.post(tableattrs.deleteentry, { model: form.attr('model'), id: elmid }).done(function(data){
        data = JSON.parse(data);
        if('errors' in data) {
            pushError(modal, errorJSONDig(data));
        } else {
            activateProgress();
            resetTable(false);
            $(modal).toggleClass('is-active');
        }
    });
}

$(window).on('load', function () {
    filter = [];
    $('button[name="filter"]').each(function (i,elm) {
        if($(elm).hasClass('is-active')) {
            filter.push($(elm).attr('val'));
        }
    });
    attrs.fields = filter;
    
    activateProgress();
    resetTable(true);
});
