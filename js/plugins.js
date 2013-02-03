// place any jQuery/helper plugins in here, instead of separate, slower script files.
(function( $ ){
$.fn.serializeJSON=function() {
var json = {};
jQuery.map($(this).serializeArray(), function(n, i){
json[n['name']] = n['value'];
});
return json;
};
})( jQuery );