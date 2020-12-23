// Modals
function showCreateModal() {
    emptyCreateModal();
    pushError($('#create_modal'), '');
    $('#create_modal').toggleClass('is-active');
}

function showEditModal(elm) {
    fillEditModal(elm);
    pushError($('#edit_modal'), '');
    $('#edit_modal').attr('elmid',$(elm).attr('elmid'));
    $('#edit_modal').attr('offset',$(elm).attr('offset'));
    $('#edit_modal').toggleClass('is-active');
}

function showDetailsModal(elm) { 
    fillDetailsModal(elm);
    pushError($('#details_modal'), '');
    $('#details_modal').attr('elmid',$(elm).attr('elmid'));
    $('#details_modal').toggleClass('is-active');
}

function showDeleteModal(elm) {
    pushError($('#delete_modal'), '');
    $('#delete_modal').attr('elmid',$(elm).attr('elmid'));
    $('#delete_modal').toggleClass('is-active');
}

function showFilterModal() {
    emptyCreateModal();
    pushError($('#filter_modal'), '');
    $('#filter_modal').toggleClass('is-active');
}

function showChangePasswordModal(elm) {
    pushError($('#changepassword_modal'), '');
    $('#changepassword_modal').attr('elmid',$(elm).parents('div.modal').attr('elmid'));
    $('#changepassword_modal').toggleClass('is-active');
}

$('[aria-label=close]').click(function() {
    $(this).parentsUntil('[class=modal]').toggleClass('is-active');
});

function addRowKeyValue(id, keytype, valuetype, key='', value='') {
    var tbody = $('#'+id);
    var tr = $('<tr>');
    tr.append($('<td>').append($('<input>', {type: keytype, class: 'input', value:key})));
    tr.append($('<td>').append($('<input>', {type: valuetype, class: 'input', value:value})));
    var icon = $('<i>', {class:'fas fa-trash mx-1', 'aria-hidden':'true'});
    var delem = $('<a>', {class:'button is-small mx-1 my-1 is-danger', onClick: 'deleteRowKeyValue(this)'});
    delem.append(icon);
    delem.append('Delete');
    tr.append($('<td>').append(delem));
    tbody.append(tr);
}

function deleteRowKeyValue(elm) {
    var table = $(elm).parents('table');
    $(elm).parentsUntil('tbody').remove();
    updateTableJson(table);
}

function showTopResults(elm) {
    var e = $(elm);
    var drp = e.parents('.dropdown').first();
    
    var hid = drp.find('div[class="dropdown-trigger"] > input[type=hidden]');
    if(hid.val().length !== 0) hid.val('');
    
    if(!drp.hasClass('is-active'))
        drp.toggleClass('is-active');
    
    if (e.val().trim().length !== 0) {
        emptyDropDown(drp);
        $.post(e.attr('posturl'), {
            model: e.attr('model'),
            field: e.attr('field'),
            search: e.val(),
            count: 10 
        }).done(function(data){
            JSON.parse(data).forEach(function(v){
                addDropDown(drp, v[e.attr('field')], v.id, v);
            });
        });
    }
}

function emptyDropDown(elm) {
    $(elm).find('div[class="dropdown-content"]').empty();
}

function addDropDown(elm, val, val_id, emp) {
    var el = $('<a>', {class: 'dropdown-item', itemid: val_id, joindate: ''});
    el.text(val);
    $(elm).find('div[class="dropdown-content"]').append(el);
}

function emptyCreateModal() {
    var form = $('#create_modal').find('form');
    form.trigger('reset');
    $(form).find('input[type=date][filldate!=false]').each(function(i,e){
        e.valueAsDate = new Date();
    });
    
    form.find('tbody').each(function (i,e) {
        $(e).empty();
    });
}

function fillEditModal(elm) {
    var entry = entriesdata[$(elm).attr('offset')];
    
    $('#edit_modal').find('form').find('[fill]').each(function(i, e) {
        var path = $(e).attr('fill').split('.');
        var data = entry[path[0]];
        
        path.shift();
        path.forEach(function(c) {
            if (data === null || data === undefined) {
                return;
            }
            data = data[c];
        });
        
        if (data === null || data === undefined) {
            $(e).empty();
            $(e).val('');
            return;
        }
        
        if ($(e).is('table')) {
            var tbody = $(e).find('tbody');
            tbody.empty();
            for (var k in data) {
                addRowKeyValue(tbody.attr('id'), tbody.attr('keytype'), tbody.attr('valuetype'), k, data[k]);
            }
        } else if ($(e).is('select') && $(e).has('option').length === 0) {
            var opt = $('<option>', {value: data});
            opt.append(data);
            $(e).append(opt);
        } else if ($(e).is('input[type=date]')) {
            if (data.length > 0) {
                e.valueAsDate = new Date(data);
            } else {
                $(e).val('');
            }
        } else if ($(e).is('input[type=checkbox]')) {
            if ((+data) === 1) {
                $(e).attr('checked', true);
                $(e).val(+data);
            } else {
                $(e).attr('checked', false);
                $(e).val(+data);
            }
            
        } else if ($(e).is('input[type=hidden][valuetype=json]')) {
            $(e).val(JSON.stringify(data));
        } else {
            $(e).val(data);
        }
    });
}

function fillDetailsModal(elm) {
    var entry = entriesdata[$(elm).attr('offset')];
    
    $('#details_modal').find('form').find('[fill]').each(function(i, e) {
        var path = $(e).attr('fill').split('.');
        var data = entry[path[0]];
        path.shift();
        path.forEach(function(c) {
            if (data === null || data === undefined) {
                return;
            }
            data = data[c];
        });
        
        if (data !== undefined && data !== null && $(e).is('details')) {
            $(e).empty();
            var par = $('<div>', {class: 'details-layout'});
            for (var key in data) {
                var keylabel = $('<div>', {class: 'details-key'});
                keylabel.append(key);
                var valuelabel = $('<div>', {class: 'details-value'});
                valuelabel.append(data[key]);
                par.append(keylabel);
                par.append(valuelabel);
            }
            $(e).append(par);
        } else if ($(e).is('div[filltype=bool]')) {
            if (data !== undefined && data !== null && data === '1') {
                $(e).text('yes');
            } else {
                $(e).text('no');
            }
        } else if (data !== undefined && data !== null && $(e).is('div[filltype=date]')) {
            $(e).text(data.startsWith('0000-00-00')? 'NA': formatDate(data));
        } else if (typeof data === 'string' && data !== undefined && data !== null) {
            $(e).text((!isNaN(parseFloat(data)) && data.includes('.')) ? (+data).toFixed(2) : data);
        } else if (typeof data === 'number' && data !== null) {
            $(e).text((!isNaN(parseFloat(data))) ? (+data).toFixed(2) : data);
        }
    });
}
