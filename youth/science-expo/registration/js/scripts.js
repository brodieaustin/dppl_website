
	$(document).ready(function(){
		
		$('#name').focus();
			
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
							$('#application').hide();
							
							if (data.search("Thank") == 0 ){
								$('div.response').html(data).css({color: 'green'}).fadeIn(600);
							}
							else{
								$('#application').fadeIn(1000);
								$('div.response').html(data).css({color: 'red'}).fadeIn(800).delay(5000).fadeOut(800);
							}	
							
						},
						failure: function(){
							$('div.response').html("Something went wrong. Please check your form and try again.").css({backgroundColor: 'red'}).fadeIn(800).delay(5000).fadeOut(800);
						}
				});
			}
			});
		
	});