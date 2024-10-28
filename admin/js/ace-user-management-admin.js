(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );
jQuery( document ).ready(function() {

	 jQuery(".delete_").on("click", function(){
	    if ( confirm("Are you sure?" ) ) { 
			var id = jQuery(this).data('id');
			jQuery.ajax({
				url: ajax.url,
				type: "post",
				data:{ action: "delete_user", id: id },
				success: function(responce){
					location.reload();
		            /*console.log( responce ); 
					  function ahref() {
					    jQuery(".delete_fi").text( responce );
					  };
					  setTimeout(function(){ ahref(); }, 5000);*/
		        },
		        error: function( error ){
		        	console.log(error);
		        }
			});
	    }return false;
	 });

	 jQuery("#input_type").change(function(){
		        if(jQuery(this).val() == 'dropdown')
		        {
		        	html = '';
					html+=	'<div class="col-md-2">';
					html+=		'<label> Options</label>';
					html+=	'</div>';
					html+=	'<div class="col-md-10">';
				    html+=    	'<input class="form-control" type="textarea" name="dropdown_options" value="" rows="3" placeholder="type your Options of Drop Down">';
					html+=    '<span class="exampl">Example(male:Male) First one is option value and second is option text</span>';
					html+=    '</div>';
					jQuery("#row").html(html);
		        	jQuery("#row").show();
		        }
		        else
		        {
		        	jQuery("#row").hide();
		        }
		    });
			jQuery( "table tbody" ).sortable( {
			    update: function( event, ui ) {
			      jQuery(this).children().each(function(index) {
			      });
			  }  
		  	});


});
