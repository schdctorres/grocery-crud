$(function(){

	var save_and_close = false;

	$('.ptogtitle').click(function(){
		if($(this).hasClass('vsble'))
		{
			$(this).removeClass('vsble');
			$('#main-table-box #crudForm').slideDown("slow");
		}
		else
		{
			$(this).addClass('vsble');
			$('#main-table-box #crudForm').slideUp("slow");
		}
	});

	$('#save-and-go-back-button').click(function(){
		save_and_close = true;

		$('#crudForm').submit();
	});

	$('#crudForm').submit(function(){
		var my_crud_form = $(this);
		console.log('Submit to: ' + validation_url);

		$(this).ajaxSubmit({
			url: validation_url,
			dataType: 'json',
			cache: 'false',
			beforeSend: function(){
				$("#FormLoading").show();
			},
			success: function(data){
				$("#FormLoading").hide();
				console.log( JSON.stringify(data) );

				if(data.success)
				{
					$('#crudForm').ajaxSubmit({
						dataType: 'text',
						cache: 'false',
						beforeSend: function(){
							//$("#FormLoading").show();
						},
						success: function(result){
							//console.log( JSON.stringify(result) );

                            if(result.statusText == "error"){
                                window.location.replace("/authenticate");
                            } 
							$("#FormLoading").fadeOut("slow");
							//data = $.parseJSON( result );
							if(data.success)
							{
								var data_unique_hash = my_crud_form.closest(".flexigrid").attr("data-unique-hash");

								$('.flexigrid[data-unique-hash='+data_unique_hash+']').find('.ajax_refresh_and_loading').trigger('click');

								if(save_and_close)
								{
									console.log('Success url ' + data.success_list_url)
									if ($('#save-and-go-back-button').closest('.ui-dialog').length === 0) {
										window.location = data.success_list_url;
									} else {
										$(".ui-dialog-content").dialog("close");
										success_message(data.success_message);
									}

									return true;
								}

								form_success_message(data.success_message);
							}
							else
							{
								console.log( data.error_message );
                                form_error_message( data.error_message );
							}
						},
						error: function(msg){
							console.log( JSON.stringify(msg) );
                            if(msg.statusText == "error"){
                                window.location.replace("/authenticate");
                            }
							console.log( message_update_error );
							form_error_message( message_update_error );
						}
					});
				}
				else
				{
					$('.field_error').each(function(){
						$(this).removeClass('field_error');
					});
					$('#report-error').slideUp('fast');
					$('#report-error').html(data.error_message);
					$.each(data.error_fields, function(index,value){
						$('input[name='+index+']').addClass('field_error');
					});

					$('#report-error').slideDown('normal');
					$('#report-success').slideUp('fast').html('');

				}
			},
			error: function(){
				console.log( message_update_error );
				$("#FormLoading").hide();

			}
		});
		return false;
	});

	if( $('#cancel-button').closest('.ui-dialog').length === 0 ) {

		$('#cancel-button').click(function(){
			if( confirm( message_alert_edit_form ) )
			{
				window.location = list_url;
			}

			return false;
		});

	}
});