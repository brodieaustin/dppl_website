    $(document).ready(function(){
	
		var storage = resumeForm();
		
		if (storage == false){
			var today = new Date();
			var y = today.getFullYear();
			var m = today.getMonth() + 1;
			var d = today.getDate();
			
			$('#app-date').val(m + '/' + d + '/' + y);
		
			var param = window.location.search.substring(1).split('=');
			if (param[0] == 'p'){
			    var pos = param[1].replace(/\+/g, ' ')
			    $('#position').val(pos);
			}
		}
		
		$('#name').focus();
			
		$('#save').click(saveForm);
			
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
			    //$('.form').hide();
			    $('.load').show();
			    $('#name').focus();
			    $('.response').hide();
			    $('#print-message').hide();
			    $('.response-message').html('').removeClass('success').removeClass('failure');
				$(form).ajaxSubmit({
					success: function(data){
					    $('.load').hide();
					    if (data.status == 'success'){
					        $(form)[0].reset();
					    }
						$('.response-message').addClass(data.status).html(data.message).parent().fadeIn().delay(10000).fadeOut();
						$('.form').show();
							
					},
					failure: function(){
							
					}
				});
			}
			});
		
	});
	
	function resumeForm(){
		if (localStorage.length > 0) {
			var r = confirm("Do you want to resume your application?");
		
			if (r == true){
				var f;
				
				for (var key in localStorage){
					if ((key != null) || (key != "")){
						//console.log(key, localStorage[key]);
						f = document.getElementById(key);
							if (f.type == "radio"){
								f.checked = true;
							}
							else{
								f.value = localStorage[key];
							}
					}
				}
				
				return true;
			}
			else{
				localStorage.clear();
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	function saveForm(){
		if (window["localStorage"]){
			localStorage.clear();
			var elems = document.getElementById("application").elements;
			
			for (i = 0; i < elems.length; i++){
				if (elems[i].id=="challenge-response"){
					i++;
				}
				else if ((elems[i].type=="radio") && (elems[i].checked == true)){
					localStorage.setItem(elems[i].id, elems[i].value);
				}
				else if ((elems[i].value != "" ) && (elems[i].type != "button") && (elems[i].type != "submit") && (elems[i].type != "radio") && (elems[i].value != undefined)){
					localStorage.setItem(elems[i].id, elems[i].value);
				}
			}
			alert("Your application has been saved!\n\nWhen you use this browser again, you can resume your application.");
		}
		else{
			alert("I'm sorry. Local storage is not avaible for your browser");
		}
	}
