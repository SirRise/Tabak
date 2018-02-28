clear();
var text = '\n';
$('.listing .product--box .product--info').each(function() {
  var title = $(this).find('.product--title').text();
  var org = title.substr(0, title.indexOf('-')-6).trim();
  var name = title.substr(title.indexOf('-')+2).trim();
  var ref = $(this).find('.product--title').attr('href');
  var imgCont = $(this).find('img');
  var image = $(imgCont).attr('srcset')? $(imgCont).attr('srcset'): '';
  var price = $(this).find('.price--default').text().trim().replace(/(\r\n|\n|\r)/gm,"").trim();
  if (price.indexOf('*') !== -1) {
    price = price.substr(0, price.indexOf('€')+1);
  }
  var weight = $(this).find('div.price--unit > span:eq(1)').text().trim();
  $.get(ref, data => {
    var pos = data.indexOf('>Geschmack:');
    var taste = data.substr(pos+11, 100).trim();
    taste = taste.substr(0, taste.indexOf('<')).trim();
    pos = data.indexOf('<img srcset="');
    text += org+' '+name+';'+weight+';'+price+';'+taste+';'+image+'\n';
  });
});