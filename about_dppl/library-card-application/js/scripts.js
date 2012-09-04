	var map;
		var geocoder;
		var dp;
		var marker;
		var counter = 0;
		
		$(document).ready(function(){
		
			initializeMap();
			
			$('#eligibility-street').focus(function(){
				$(this).val('');
				$('#eligibility-city').val('');
				$('#eligibility-zip').val('');
				$('#eligibility-response').empty().hide();
			});
			
			$('#submit-eligibility').click(function(){
				var response_div = '#eligibility-response';
				
				$(response_div).empty().hide();
				$('.load').show(0);
				
				var address = $('#eligibility-street').val() + ' ' + $('#eligibility-zip').val();
				codeAddress(address, response_div);
				
				return false;
			});
			
			/*validate and submit form*/
			$('#application').validate({
				invalidHandler: function(form, validator) {
					  var errors = validator.numberOfInvalids();
					  if (errors) {
						var message = errors == 1 ? 'You missed 1 field. It has been highlighted': 'You missed ' + errors + ' fields. They have been highlighted';
						$('div.errors').html(message);
						$('div.errors').show();
					  } else {
						$('div.errors').hide();
					  }
				},
				submitHandler: function(form){
					$(form).ajaxSubmit({
						success: function(data){
								$('div.errors').hide();
								$('.card-application').hide();
								
								if (data.search("Thank") == 0 ){
									$('#application-response').html(data).css({color: 'black'}).fadeIn(600);
								}
								else{
									$('.card-application').fadeIn(1000);
									$('#application-response').html(data).css({color: 'red'}).fadeIn(800).delay(5000).fadeOut(800);
								}	
							
							},
							failure: function(){
								$('#application-response').html("Something went wrong. Please check your form and try again.").css({backgroundColor: 'red'}).fadeIn(800).delay(5000).fadeOut(800);
							}
					});
				}
			});
			
			/*Google Maps/Eligiblity function*/
			
			function initializeMap() {
        		var mapOptions = {
		      		center: new google.maps.LatLng(42.033889, -87.899722),
		      		zoom: 12,
		      		mapTypeId: google.maps.MapTypeId.ROADMAP
        		};
        		
        		geocoder = new google.maps.Geocoder();
        		marker = new google.maps.Marker();
        		map = new google.maps.Map(document.getElementById("map"),
            		mapOptions);
            		
            	var dpCoords = [
            		new google.maps.LatLng( 42.07976, -87.90761 ),
					new google.maps.LatLng( 42.07978, -87.9029 ),
					new google.maps.LatLng( 42.0786, -87.90234 ),
					new google.maps.LatLng( 42.07852, -87.90194 ),
					new google.maps.LatLng( 42.0776, -87.90143 ),
					new google.maps.LatLng( 42.07574, -87.90155 ),
					new google.maps.LatLng( 42.07574, -87.90155 ),
					new google.maps.LatLng( 42.07324, -87.88744 ),
					new google.maps.LatLng( 42.06998, -87.89094 ),
					new google.maps.LatLng( 42.06913, -87.88814 ),
					new google.maps.LatLng( 42.06787, -87.88723 ),
					new google.maps.LatLng( 42.06611, -87.88729 ),
					new google.maps.LatLng( 42.06588, -87.8765 ),
					new google.maps.LatLng( 42.05814, -87.8764 ),
					new google.maps.LatLng( 42.0579, -87.88259 ),
					new google.maps.LatLng( 42.0579, -87.88259 ),
					new google.maps.LatLng( 42.05475, -87.8844 ),
					new google.maps.LatLng( 42.05363, -87.87234 ),
					new google.maps.LatLng( 42.0563, -87.87217 ),
					new google.maps.LatLng( 42.05636, -87.86971 ),
					new google.maps.LatLng( 42.0572, -87.86976 ),
					new google.maps.LatLng( 42.05724, -87.86863 ),
					new google.maps.LatLng( 42.0564, -87.86869 ),
					new google.maps.LatLng( 42.05514, -87.86972 ),
					new google.maps.LatLng( 42.05465, -87.86962 ),
					new google.maps.LatLng( 42.05457, -87.86886 ),
					new google.maps.LatLng( 42.05385, -87.86907 ),
					new google.maps.LatLng( 42.05393, -87.86237 ),
					new google.maps.LatLng( 42.05195, -87.86238 ),
					new google.maps.LatLng( 42.05175, -87.86959 ),
					new google.maps.LatLng( 42.05038, -87.8696 ),
					new google.maps.LatLng( 42.04988, -87.86756 ),
					new google.maps.LatLng( 42.04885, -87.86711 ),
					new google.maps.LatLng( 42.04869, -87.86573 ),
					new google.maps.LatLng( 42.04781, -87.86568 ),
					new google.maps.LatLng( 42.04777, -87.86471 ),
					new google.maps.LatLng( 42.04651, -87.86482 ),
					new google.maps.LatLng( 42.04654, -87.86298 ),
					new google.maps.LatLng( 42.04761, -87.86313 ),
					new google.maps.LatLng( 42.04769, -87.86379 ),
					new google.maps.LatLng( 42.05005, -87.86245 ),
					new google.maps.LatLng( 42.05015, -87.85968 ),
					new google.maps.LatLng( 42.03938, -87.85997 ),
					new google.maps.LatLng( 42.03908, -87.86974 ),
					new google.maps.LatLng( 42.03641, -87.86973 ),
					new google.maps.LatLng( 42.03648, -87.86825 ),
					new google.maps.LatLng( 42.03804, -87.86826 ),
					new google.maps.LatLng( 42.03773, -87.86755 ),
					new google.maps.LatLng( 42.0355, -87.86552 ),
					new google.maps.LatLng( 42.0359, -87.86608 ),
					new google.maps.LatLng( 42.03632, -87.86669 ),
					new google.maps.LatLng( 42.03634, -87.86713 ),
					new google.maps.LatLng( 42.03542, -87.8668 ),
					new google.maps.LatLng( 42.03542, -87.86971 ),
					new google.maps.LatLng( 42.02833, -87.86972 ),
					new google.maps.LatLng( 42.02827, -87.87465 ),
					new google.maps.LatLng( 42.02282, -87.87461 ),
					new google.maps.LatLng( 42.02058, -87.87212 ),
					new google.maps.LatLng( 42.01986, -87.8721 ),
					new google.maps.LatLng( 42.01805, -87.87406 ),
					new google.maps.LatLng( 42.01593, -87.87111 ),
					new google.maps.LatLng( 42.01647, -87.8698 ),
					new google.maps.LatLng( 42.01055, -87.86987 ),
					new google.maps.LatLng( 42.00275, -87.86477 ),
					new google.maps.LatLng( 41.99577, -87.86177 ),
					new google.maps.LatLng( 41.99526, -87.87338 ),
					new google.maps.LatLng( 41.9982, -87.88439 ),
					new google.maps.LatLng( 42.00957, -87.88574 ),
					new google.maps.LatLng( 42.00929, -87.89259 ),
					new google.maps.LatLng( 42.00693, -87.89271 ),
					new google.maps.LatLng( 42.00699, -87.89404 ),
					new google.maps.LatLng( 42.00584, -87.8941 ),
					new google.maps.LatLng( 42.00923, -87.90358 ),
					new google.maps.LatLng( 42.0091, -87.90767 ),
					new google.maps.LatLng( 42.00525, -87.90764 ),
					new google.maps.LatLng( 42.00495, -87.92027 ),
					new google.maps.LatLng( 42.00381, -87.92043 ),
					new google.maps.LatLng( 42.00764, -87.92536 ),
					new google.maps.LatLng( 42.0051, -87.92911 ),
					new google.maps.LatLng( 42.00557, -87.9334 ),
					new google.maps.LatLng( 42.00831, -87.93343 ),
					new google.maps.LatLng( 42.00842, -87.93128 ),
					new google.maps.LatLng( 42.01364, -87.9313 ),
					new google.maps.LatLng( 42.01364, -87.93048 ),
					new google.maps.LatLng( 42.00838, -87.93047 ),
					new google.maps.LatLng( 42.00857, -87.91881 ),
					new google.maps.LatLng( 42.01101, -87.92115 ),
					new google.maps.LatLng( 42.01106, -87.9236 ),
					new google.maps.LatLng( 42.01271, -87.92722 ),
					new google.maps.LatLng( 42.01547, -87.93211 ),
					new google.maps.LatLng( 42.01554, -87.93993 ),
					new google.maps.LatLng( 42.01671, -87.94081 ),
					new google.maps.LatLng( 42.01671, -87.94148 ),
					new google.maps.LatLng( 42.0174, -87.94209 ),
					new google.maps.LatLng( 42.01808, -87.94193 ),
					new google.maps.LatLng( 42.01967, -87.95015 ),
					new google.maps.LatLng( 42.02028, -87.95004 ),
					new google.maps.LatLng( 42.01977, -87.94657 ),
					new google.maps.LatLng( 42.02084, -87.94733 ),
					new google.maps.LatLng( 42.02079, -87.94289 ),
					new google.maps.LatLng( 42.0227, -87.94303 ),
					new google.maps.LatLng( 42.02254, -87.94042 ),
					new google.maps.LatLng( 42.03549, -87.9407 ),
					new google.maps.LatLng( 42.0355, -87.94141 ),
					new google.maps.LatLng( 42.03733, -87.9414 ),
					new google.maps.LatLng( 42.0374, -87.94059 ),
					new google.maps.LatLng( 42.04742, -87.94068 ),
					new google.maps.LatLng( 42.0478, -87.92835 ),
					new google.maps.LatLng( 42.04854, -87.92247 ),
					new google.maps.LatLng( 42.05174, -87.92244 ),
					new google.maps.LatLng( 42.05175, -87.92326 ),
					new google.maps.LatLng( 42.05537, -87.92329 ),
					new google.maps.LatLng( 42.05532, -87.9213 ),
					new google.maps.LatLng( 42.06611, -87.92143 ),
					new google.maps.LatLng( 42.06618, -87.92061 ),
					new google.maps.LatLng( 42.06495, -87.91827 ),
					new google.maps.LatLng( 42.0661, -87.91826 ),
					new google.maps.LatLng( 42.06602, -87.90875 ),
					new google.maps.LatLng( 42.06698, -87.90879 ),
					new google.maps.LatLng( 42.06705, -87.90777 )
            	];
            	
            	dp = new google.maps.Polygon({
            		paths: dpCoords,
					strokeColor: "blue",
					strokeOpacity: 0.8,
					strokeWeight: 2,
					fillColor: "blue",
					fillOpacity: 0.35
            	});
            	
            	dp.setMap(map);
      		}
      		
      		function codeAddress(address, response_div) {
      			counter = counter + 1;
      			
      			if (counter > 10){
      				$(response_div).html('I\'m sorry. You can\'t search for any more addresses at this time.').show();
      			}
      			else{
      				marker.setMap(null);
					geocoder.geocode( { 'address': address}, function(results, status) {
					  if (status == google.maps.GeocoderStatus.OK) {
					    var point = results[0].geometry.location;
					    
						map.setCenter(point);
						
						var markerOptions = {
							map : map,
							position : point
						};
					
						
						if(google.maps.geometry.poly.containsLocation(point, dp)){
							markerOptions.title = "You are eligible!";
							markerOptions.icon = 'https://chart.googleapis.com/chart?chst=d_map_pin_icon&chld=home|008000';
							
					    	$(response_div).html('<h4 class="big">Inside</h4><p>Your address appears to be <strong>inside</strong> the blue shape on the map. You should be eligible for a card. Library staff will review your application to be sure.</p><p><a href="#application" class="scroll">Proceed to the application</a></p>');
					    	$('#application-eligibility').val('Eligible');
					    	$('#address').val($('#eligibility-street').val());
					    	$('#zipcode').val($('#eligibility-zip').val());
					    }
					    else{
					    	markerOptions.title = "You are not eligible!";
					    	markerOptions.icon = 'https://chart.googleapis.com/chart?chst=d_map_pin_icon&chld=home|FF0000';
					    	
					    	$(response_div).html('<h4 class="big">Outside</h4><p>Your address seems to be <strong>outside</strong> the blue shape. You don\'t appear to be eligible for a library card. If feel this is an error, you may fill out the application. Library staff will review your application. You can consult our policies page for information about <a href="../library_cards_policies.shtml#non-resident">non-resident cards</a>.</p><p><a href="#application" class="scroll">Proceed to the application</a></p>');
					    	$('#application').before('<p class="error">Please be aware that you may not be eligible for a library card. Library staff will review your application. You can continue with the application or consult our library card policies page for more information about <a href="../library_cards_policies.shtml#non-resident">non-resident cards</a>.</p>');
					    	$('#application-eligibility').val('Not Eligible');
					    	$('#address').val($('#eligibility-street').val());
					    	$('#zipcode').val($('#eligibility-zip').val());
					    }
					    
					    marker.setOptions(markerOptions);
					    
					    $('.load').delay(1000).fadeOut('500');
					    $(response_div).delay(1000).fadeIn('500');
					    
					  } else {
						 $(response_div).html("Geocode was not successful for the following reason: " + status).show();
					  }
					});
				}
			  }
			
		});
