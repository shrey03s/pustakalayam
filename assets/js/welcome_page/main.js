$(document).ready(function() {
    searchBooks(null);
});

function addBooks(book) {
    var cont = $('#books-display');
    var child = $('<div>', {class:'flow-child'});
    var cardelm = $('<div>', {class:'card mx-3'});
    var cardimg = $('<div>', {class:'card-image my-1'});
    cardimg.append($('<figure>', {class:'image '}).append($('<img>', {src: book.img, style:'width:100%;height: 256px'})));
    cardelm.append(cardimg);
    
    var cardcont = $('<div>', {class:'card-content'});
    var media = $('<div>', {class:'media'});
    var media_content = $('<div>', {class:'media-content'});
    media_content.append($('<p>',{class:'title is-4'}).append(book.title));
    media_content.append($('<p>',{class:'subtitle is-6'}).append(book.subtitle));
    media.append(media_content);
    cardcont.append(media);
    
    cardelm.append(cardcont);
    child.append(cardelm);
    cont.append(child);
    
    return child;
}

function searchBooks(searchtext) {
    $.post('/search', {text: searchtext}, function(data) {
        var books = JSON.parse(data);
        $('#books-display').empty();
        books.forEach(function(b) {
            addBooks({
                img: b.cover,
                title: b.name,
                subtitle: b.author
            });
        });
    });
}

function actionSearchBar(elm) {
    searchBooks($(elm).val());
}

/*
addBooks({img:'/assets/img/Arduino.jpg',title:'Arduino', subtitle:'Markwoa'});
addBooks({img:'/assets/img/python03.jpg',title:'Python 3', subtitle:'Mark Da vinci'});
addBooks({img:'/assets/img/Realestate.jpg',title:'Millionaire real estate', subtitle:'Gary Keller'});
addBooks({img:'/assets/img/pythonDS.jpg',title:'Python DS', subtitle:'Guido V Russom'});
addBooks({img:'/assets/img/ml.jpg',title:'Hands on Machine Learning', subtitle:'O`really'});
addBooks({img:'/assets/img/arthashastra.png',title:'Arthashashtra', subtitle:'Kautilya'});
 */