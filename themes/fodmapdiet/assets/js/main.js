/* Author: Max Annear

*/

var foodList = {};

jQuery(document).ready(function($) {
	//we want the search box to have focus
	jQuery('#search-box').focus();
	
	//load the foods into the search box via ajax
	jQuery.post(ajaxurl, {action: 'get_foods'}, function(response) {		
		var foodArray = [];
		foodList = response;
	   for(var key in foodList){
		  foodArray.push(key);
	   }
		jQuery('#search-box').typeahead().data('typeahead').source = foodArray; 		
	});
});






jQuery('#search-box').typeahead({
	
	highlighter: function(item){
      var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&')
		
		//this function replaces any matching strings in the item with <strong></strong> if they are in the item
      updated_name = item.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
        return '<strong>' + match + '</strong>'
      })
	  
	  
	  //"<i class='icon-ok-sign'></i> "
	  return '<img src="assets/img/icon_'+foodList[item]+'.png"> ' + updated_name;	  
    },
	
	updater: function (item) {

        //item = selected item
        //do your stuff.
			
        //dont forget to return the item to reflect them into input
        return item;
    },
});


/*
select: function () {
      var val = this.$menu.find('.active').attr('data-value')
      this.$element
        .val(this.updater(val))
        .change()
      return this.hide()
    }
	
	
	$("input").keypress(function(event) {
    if (event.which == 13) {
        event.preventDefault();
        $("#search-form").submit();
    }
});
$('#search-form').submit(function() {
  alert('hello');
  return false;
});
	
	*/