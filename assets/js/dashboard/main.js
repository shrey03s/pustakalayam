function reloadview() {
    nav_height = $('nav[aria-label="main navigation"]').height();
    $('.sidenav').css('top', nav_height+'px');
    $('#main').css('padding-top', nav_height+'px');
    $('.sidenav').css('height', 'calc(100% - '+nav_height+'px)');
    if($(document).width() >= 1024) {
        if(!$(".sidenav").hasClass("sidenav-active")) $(".sidenav").toggleClass("sidenav-active");
    } else {
        if($(".sidenav").hasClass("sidenav-active")) $(".sidenav").toggleClass("sidenav-active");
    }
}
$(window).ready(function() {
    reloadview();
});

$(window).resize(function() {
    reloadview();
 });

$(".navbar-burger").click(function() {
    $(".navbar-burger").toggleClass("is-active");
    $(".navbar-menu").toggleClass("is-active");
});

$(".is-togglable").click(function() {
    $(this).toggleClass('is-active');
});

function sidenav() {
    $(".sidenav").toggleClass("sidenav-active");
}

function enable_item_sidenav(item,sub) {
    $(item).toggleClass("is-active");
    if(sub !== undefined) $(sub).attr('open','true');
}
