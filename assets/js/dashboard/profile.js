$('[aria-label=close]').click(function() {
    $(this).parentsUntil('[class=modal]').toggleClass('is-active');
});

function pushError(elm, error) {
    elm.find('label[name=message]').text(error);
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

$('#change_password_btn').click(function() {
    pushError($('#change_password'),'');
    $('#change_password').toggleClass("is-active");
});

function changepasswordEntry(modal, form) {
    var fd = form.serializeArray();
    fd.push({name: 'id', value: $(modal).attr('elmid')});
    
    $.post('/api/changepass', fd).done(function(data){
        data = JSON.parse(data);
        if('errors' in data) {
            pushError(modal, errorJSONDig(data));
        } else {
            form.parents('.modal').toggleClass('is-active');
        }
    });
}