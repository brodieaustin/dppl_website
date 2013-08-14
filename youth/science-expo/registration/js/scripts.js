
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
				$('html, body').animate({ scrollTop: 0 }, 0);
			    $('.form').hide();
			    $('.load').show();
			    $('div.errors').html('').hide();
			    $('.response').hide();
			    $('.response-message').html('').removeClass('success').removeClass('failure');
				$(form).ajaxSubmit({
					success: function(data){
                        var response = $.parseJSON(data);
						//console.log(data);
					    $('.load').hide();
					    if (response.status == 'success'){
					        $(form)[0].reset();
					    }
					    else{
					        $('.form').show();
					    }
						$('.response-message').addClass(response.status).html(response.message).parent().fadeIn();
							
					},
					failure: function(){
						$('.load').hide();
						$('.form').show();
						$('.response-message').addClass('failure').html("Something went wrong and your application cannot be submitted at this time. Click Save to save your progress or print the form out.").parent().fadeIn();
					}
				});
			}
			});
		
	});