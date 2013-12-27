    $(document).ready(function(){
        //json formatted list of current jobs, used for pretty urls params below
        //{"job-title" : "Job Title"}
        var current_jobs = {"part-time-building-monitor": "Part-Time Building Monitor", "part-time-building-services-assistant": "Part-Time Building Services Assistant", "circulation-services-clerk": "Circulation Services Clerk", "readers-services-assistant" : "Readers Services Assistant"};
        var param, pos;
        
        //test for local storage
		var storage = resumeForm();
		
		//if no storage, add today's date to form and check for url params (or pretty url)
		if (storage == false){
			var today = new Date();
			var y = today.getFullYear();
			var m = today.getMonth() + 1;
			var d = today.getDate();
			
			$('#app-date').val(m + '/' + d + '/' + y);
			
		    
		    //check for params or do regex search for position in url
			if (window.location.search != ""){
			    param = window.location.search.substring(1).split('=');
			    if (param[0] == 'p'){
			        pos = param[1].replace(/\+/g, ' ');
			    }
			}
			else{
			    var p = /job-application\/([a-z0-9-]+)/;
			    param = p.exec(window.location.href);
			    
			    if (param){
			        pos = current_jobs[param[1]];
			    }
			}
			
			if (pos){
				//console.log(pos);
				if ($('#position option[value="' + pos + '"]').length == 0){
					$('#position').append('<option value="' + pos + '">' + pos + '</option>');
				}
			    $('#position').val(pos);
			}
		}

		$('#save').click(saveForm);
			
		$('#application').validate({
			invalidHandler: function(form, validator) {
				  var errors = validator.numberOfInvalids();
				  if (errors) {
					var message = errors == 1 ? 'You missed 1 field. It has been highlighted': 'You missed ' + errors + ' fields. They have been highlighted';
					$('html, body').animate({ scrollTop: 0 }, 0);
					$('div.errors').html(message).show();
				  } else {
					$('div.errors').html('').hide();
				  }
			},
			submitHandler: function(form){
			    $('html, body').animate({ scrollTop: 0 }, 0);
			    $('.form').hide();
			    $('.load').show();
			    $('div.errors').html('').hide();
			    $('.response').hide();
			    $('#print-message').hide();
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
					        $('#challenge-image').attr('src', $('#challenge-image').attr('src'));
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
	
	function getJobTitle(pos){
	    
	    return current_jobs[pos];
	}
