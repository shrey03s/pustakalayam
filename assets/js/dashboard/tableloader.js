// Cookies
function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) === ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) === 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function checkCookie(cname) {
  var cookies = getCookie(cname);
  if (cookies !== "") {
    return true;
  } else {
    return false;
  }
}

// Works
var attrs = {
    count: checkCookie('item_per_page') ? getCookie('item_per_page') : 15,
    offset: 0,
    orderby: ('orderby' in tableattrs) ? tableattrs.orderby : 'id',
    order: ('order' in tableattrs) ? tableattrs.order : 'ASC',
    search: null,
    fields: ('filter' in tableattrs) ? tableattrs.filter : [],
    filters: {},
    fromdate: null,
    todate: null,
    last_offset: 0
};

function addPage(par, page, is_active = false) {
    li_elm = $('<li>');
    a_elm = $('<a>', {class:'pagination-link'+((is_active)? ' is-current': ''), page:page, onclick:'changePageClick(this)'});
    a_elm.append(page);
    li_elm.append(a_elm);
    par.append(li_elm);
}

function resetTable(reset_offset) {
    if(reset_offset)  {
        attrs.offset = 0;
    }
    var tbody_elm = $('#main-tbody');
    var tfoot_elm = $('#main-tfoot');
    var paginate = $('#main-paginate');
    
    var request_params = {
        model: tableattrs.model, 
        count: attrs.count, 
        offset: attrs.offset, 
        search: (attrs.search || null), 
        orderby: attrs.orderby, 
        order: attrs.order, 
        fields: JSON.stringify(attrs.fields),
        filters: JSON.stringify(attrs.filters),
        fromdate: (attrs.fromdate || null),
        todate: (attrs.todate || null)
    };
    
    if($('#main-date').length > 0) request_params['date'] = $('#main-date').val(); // For bulk attendance
    
    activateProgress();
    $.post(tableattrs.getentries, request_params)
    .done(function( data ) {
        entriesdata = JSON.parse(data);
       
        // table
        $('#main-tbody').empty();
        for (var i = 0; i < entriesdata.length; i++) {
            addFieldTable($('#main-tbody'), entriesdata[i], i);
        }
        
        $.post(tableattrs.entrycount, request_params).done(function( data ) {
            var jdata = JSON.parse(data);
            
            $('#result_count').empty();
            $('#result_count').append(jdata.count + ' Results')
            
            var keys = Object.keys(jdata);
            if(keys.length > 1 && entriesdata.length > 0) {
                tfoot_elm.empty();
                var tr = $('<tr>');
                tableattrs.fields.forEach(function(d, i) {
                    var d = Object.keys(d)[0];
                    var th = $('<th>');
                    if(keys.includes(d)) {
                        th.append((+jdata[d]).toFixed(2));
                    }
                    tr.append(th);
                });
                tfoot_elm.append(tr);
            }
            
            attrs.last_offset = parseInt(jdata.count);
            total_size = Math.floor(parseInt(jdata.count)/attrs.count)+1;
            page = Math.floor(attrs.offset/attrs.count)+1;
            
            // add pages
            paginate.empty();

            if(page !== 1) addPage(paginate, 1);

            if(page-1 > 2) addPage(paginate, '\u2026');
            if(page-1 > 1) addPage(paginate, page-1);

            addPage(paginate, page, true);

            if(page+1 < total_size) addPage(paginate, page+1);
            if(page+1 < total_size-1) addPage(paginate, '\u2026');

            if(page !== total_size && total_size !== 0) addPage(paginate, total_size);

            deactivateProgress();
        });
    });
}


function activateProgress() {
    $('.progress').attr('value', '');
    if (!$('.progress').hasClass('is-hidden'))
        $('.progress').toggleClass('is-hidden');
}

function deactivateProgress() {
    $('.progress').attr('value', '100');
    if (!$('.progress').hasClass('is-hidden'))
            $('.progress').toggleClass('is-hidden');
}

// Navigations
$('#orderby').on('change', function () {
    attrs.orderby = $('#orderby option:selected').attr('val');
    
    activateProgress();
    resetTable(true);
});

$('#order').on('change', function () {
    attrs.order = $('#order option:selected').attr('val');
    
    activateProgress();
    resetTable(true);
});

$('#fromdate').on('change', function () {
    attrs.fromdate = $('#fromdate').val();
    resetTable(true);
});

$('#todate').on('change', function () {
    attrs.todate = $('#todate').val();
    resetTable(true);
});

$('#perpage').on('change', function () {
    attrs.count = parseInt($('#perpage option:selected').attr('val'));
    
    if(!checkCookie('item_per_page') || getCookie('item_per_page') !== attrs.count) {
        setCookie('item_per_page', attrs.count, 30);
    }
    
    activateProgress();
    resetTable(true);
});

$('#searchbox').keypress(function (e) {
    if (e.which === 13) {
        if($(this).val().trim().length === 0) {
            attrs.search = null;
        } else {
            attrs.search = $(this).val();
        }
        
        activateProgress();
        resetTable(true);
    }
});

$('#searchbtn').click(function() {
    if($('#searchbox').val().trim().length === 0) {
        attrs.search = null;
    } else {
        attrs.search = $('#searchbox').val();
    }
    
    activateProgress();
    resetTable(true);
});

$('button[name="filter"]').click(function() {
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

function cleanFilter() {
    attrs.filters = {};
    $('#filter_modal').find('form').trigger('reset');
    $('#filter_clean').addClass('is-light');
    $('#filter_clean').removeClass('is-info');
    
    activateProgress();
    resetTable(true);
}

function changePageClick(elm) {
    if($(elm).text() !== '\u2026') {
        attrs.offset = (parseInt($(elm).attr('page'))-1)*attrs.count;
        
        activateProgress();
        resetTable(false);
    }
}

function nextPage() {
    if(attrs.offset !== Math.floor(attrs.last_offset/attrs.count)*attrs.count) {
        attrs.offset += attrs.count;
        
        activateProgress();
        resetTable(false);
    }
}

function previousPage() {
    if(attrs.offset !== 0) {
        attrs.offset -= attrs.count;
        
        activateProgress();
        resetTable(false);
    }
}

function exportCSV() {
    var request_params = {
        model: tableattrs.model, 
        count: attrs.count, 
        offset: attrs.offset, 
        search: (attrs.search || null), 
        orderby: attrs.orderby, 
        order: attrs.order, 
        fields: JSON.stringify(attrs.fields),
        filters: JSON.stringify(attrs.filters),
        fromdate: (attrs.fromdate || null),
        todate: (attrs.todate || null)
    };
    
    window.open('/api/exportcsv?' + $.param(request_params), '_blank');
}
