function addFieldTable(tbody_elm, val, offset) {
    
    var tr_elm = $('<tr>', {'elmid':val.id, id:'elm-'+val.id});
    tr_elm.attr('offset', offset);
    
    // id
    var td_elm = $('<td>');
    td_elm.append(val.id);
    tr_elm.append(td_elm);
    
    // name
    var td_elm = $('<td>');
    td_elm.append(val.name);
    tr_elm.append(td_elm);
    
    
    // reason
    var td_elm = $('<td>');
    td_elm.append($('<input>', {type: 'text', class: 'input', elmid:val.id}));
    tr_elm.append(td_elm);
    
    // present
    var td_elm = $('<td>');
    td_elm.append($('<div>', {class: 'checkbox'}).append($('<input>', {type: 'checkbox', elmid:val.id})));
    tr_elm.append(td_elm);
    
    td_elm = $('<td>');
    
    icon = $('<i>', {class:'fas fa-plus-circle mx-1', 'aria-hidden':'true'});
    a_elm = $('<a>', {class:'button is-togglable is-small mb-1', elmid:val.id, onclick:'saveAttendance(this)'});
    a_elm.attr('offset', offset);
    a_elm.append(icon);
    a_elm.append('Save');
    td_elm.append(a_elm);
    
    td_elm.append($('<label>', {class:'label has-text-weight-light', elmid:val.id}));
    
    tr_elm.append(td_elm);
    
    tbody_elm.append(tr_elm);
}

$(window).on('load', function () {
    activateProgress();
    resetTable(true);
});

function dateChanged() {
    activateProgress();
    resetTable(true);
}

function pushError(elm, error) {
    $('label[elmid='+elm.attr('elmid')+']').text(error);
}

function errorJSONDig(json) {
    json = json['errors'];
    if('validation' in json) {
        errs = Object.keys(json['validation']);
        return json['validation'][errs[0]];
    } else {
        return 'Failed to make entries!';
    }
}

function saveAttendance(elm) {
    elm = $(elm);
    var present = $('[elmid='+elm.attr('elmid')+'][type=checkbox]').is(':checked');
    var reason = $('[elmid='+elm.attr('elmid')+'][type=text]').val();
    
    activateProgress();
    
    var requestparam = {
        model: 'attendance',
        employee_id: elm.attr('elmid'),
        is_present: present ? 1 : 0,
        reason: reason,
        date: $('#main-date').val()
    };
    
    if(elm.attr('saveid') !== undefined) requestparam['id'] = elm.attr('saveid');
    
    $.post('/api/putentry', requestparam).done(function(data){
        data = JSON.parse(data);
        if('errors' in data) {
            pushError(elm, errorJSONDig(data));
        } else {
            elm.attr('saveid', data['id']);
            if(!elm.hasClass('is-active')) elm.addClass('is-active');
            deactivateProgress();
        }
    });
}
