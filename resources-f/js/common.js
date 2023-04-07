	function studentautologin()
		{
			$('.loader-cont').show();
			$.ajax({
				url: WOSA_BASE_URL+'our_students/student_autoLogin',
				method:'POST',
				dataType:'json',
				success: function(resp)
				{
					if(resp.success == 1)
					{
						var url = 'http://'+resp.link;
						window.open(url, '_blank');
					}
					else if(resp.success == 0){
						$('#msg-content').html('Practice portal is not enabled');
						$('#responsemsgmodal').modal('show');
						setTimeout(function(){
							$('#responsemsgmodal').modal('hide');
						},1500);
					}
					else{
						$('#msg-content').html('Something went wrong. Please try again later');
						$('#responsemsgmodal').modal('show');
						setTimeout(function(){
							$('#responsemsgmodal').modal('hide');
						},1500);
					}
					$('.loader-cont').hide();
				}

			});
		}