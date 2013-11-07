jQuery(document).ready(function($){
	
	function mp_links_custom_toggle(){
		//Hide media type metaboxes by looping through each item in the drodown
		var link_type = $("#mp_links_metabox .link_type option:selected").val();
					
		//If custom icon is selected
		if ( link_type == 'mp-links-customicon' ){
			
			//Hide edd_api_url field
			$('.mp_field_link_custom_icon').css('display', 'block');	
				
		}
		//If EDD is foreign to this URL
		else {
				
			//Hide edd_api_url field
			$('.mp_field_link_custom_icon').css('display', 'none');	
			
		}
	}
	
	mp_links_custom_toggle();
	
	$('#mp_links_metabox .link_type').change(function() {
		mp_links_custom_toggle();
	});
		
});