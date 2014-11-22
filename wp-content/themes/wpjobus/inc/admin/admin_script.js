/*-----------------------------------------------------------------------------------*/
/*	Custom Script
/*-----------------------------------------------------------------------------------*/

jQuery(document).ready(function($) {

	//ADD
	$('#template_criterion').hide();
	$('#submit_add_criteria').on('click', function() {		
		$newItem = $('#template_criterion .option_item').clone().appendTo('#review_criteria').show();
		if ($newItem.prev('.option_item').size() == 1) {
			var id = parseInt($newItem.prev('.option_item').attr('id')) + 1;
		} else {
			var id = 0;	
		}
		$newItem.attr('id', id);

		var criterionText = 'Skill ' + (id+1);
		$newItem.children('span:eq(0)').text(criterionText);

		var nameText = 'wpjobus_resume_skills[' + id + '][0]';
		$newItem.children('.criteria_name').attr('id', nameText).attr('name', nameText);

		var sliderValue = 'wpjobus_resume_skills['+ id +'][1]';
		$newItem.children('.slider_value').attr('id', sliderValue).attr('name', sliderValue);

		//event handler for newly created element
		$newItem.children('.button_del_criteria').on('click', function () {
			$(this).parent('.option_item').remove();
		});

	});
	
	//DELETE
	$('.button_del_criteria').on('click', function() {
		$(this).parent('.option_item').remove();
	});





	//ADD JOB BENEFITS
	$('#template_job_benefit').hide();
	$('#submit_add_job_benefit').on('click', function() {		
		$newItem = $('#template_job_benefit .option_item').clone().appendTo('#review_job_benefit').show();
		if ($newItem.prev('.option_item').size() == 1) {
			var id = parseInt($newItem.prev('.option_item').attr('id')) + 1;
		} else {
			var id = 0;	
		}
		$newItem.attr('id', id);

		var criterionText = 'Benefit ' + (id+1);
		$newItem.children('span:eq(0)').text(criterionText);

		var nameText = 'wpjobus_job_benefits[' + id + '][0]';
		$newItem.find('.criteria_name').attr('id', nameText).attr('name', nameText);

		var sliderValue = 'wpjobus_job_benefits['+ id +'][1]';
		$newItem.find('.job-benefit-desc').attr('id', sliderValue).attr('name', sliderValue);

		//event handler for newly created element
		$newItem.children('.button_del_job_benefit').on('click', function () {
			$(this).parent('.option_item').remove();
		});

	});
	
	//DELETE
	$('.button_del_job_benefit').on('click', function() {
		$(this).parent('.option_item').remove();
	});





	//ADD JOB SKILLS
	$('#template_job_criterion').hide();
	$('#submit_add_job_criteria').on('click', function() {		
		$newItem = $('#template_job_criterion .option_item').clone().appendTo('#review_job_criteria').show();
		if ($newItem.prev('.option_item').size() == 1) {
			var id = parseInt($newItem.prev('.option_item').attr('id')) + 1;
		} else {
			var id = 0;	
		}
		$newItem.attr('id', id);

		var criterionText = 'Skill ' + (id+1);
		$newItem.children('span:eq(0)').text(criterionText);

		var nameText = 'wpjobus_job_skills[' + id + '][0]';
		$newItem.children('.criteria_name').attr('id', nameText).attr('name', nameText);

		var sliderValue = 'wpjobus_job_skills['+ id +'][1]';
		$newItem.children('.slider_value').attr('id', sliderValue).attr('name', sliderValue);

		//event handler for newly created element
		$newItem.children('.button_del_job_criteria').on('click', function () {
			$(this).parent('.option_item').remove();
		});

	});
	
	//DELETE
	$('.button_del_job_criteria').on('click', function() {
		$(this).parent('.option_item').remove();
	});




	//ADD LANGUAGE
	$('#template_language').hide();
	$('#submit_add_language').on('click', function() {		
		$newItem = $('#template_language .option_item').clone().appendTo('#resume_languages').show();
		if ($newItem.prev('.option_item').size() == 1) {
			var id = parseInt($newItem.prev('.option_item').attr('id')) + 1;
		} else {
			var id = 0;	
		}
		$newItem.attr('id', id);

		var criterionText = 'Language ' + (id+1);
		$newItem.children('span:eq(0)').text(criterionText);

		var nameText = 'wpjobus_resume_languages[' + id + '][0]';
		$newItem.find('.resume_lang_title').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_resume_languages[' + id + '][1]';
		$newItem.find('.resume_lang_understanding').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_resume_languages[' + id + '][2]';
		$newItem.find('.resume_lang_speaking').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_resume_languages[' + id + '][3]';
		$newItem.find('.resume_lang_writing').attr('id', nameText).attr('name', nameText);

		//event handler for newly created element
		$newItem.children('.button_del_language').on('click', function () {
			$(this).parent('.option_item').remove();
		});

	});
	
	//DELETE
	$('.button_del_language').on('click', function() {
		$(this).parent('.option_item').remove();
	});





	//ADD JOB LANGUAGE
	$('#template_job_language').hide();
	$('#submit_add_job_language').on('click', function() {		
		$newItem = $('#template_job_language .option_item').clone().appendTo('#job_languages').show();
		if ($newItem.prev('.option_item').size() == 1) {
			var id = parseInt($newItem.prev('.option_item').attr('id')) + 1;
		} else {
			var id = 0;	
		}
		$newItem.attr('id', id);

		var criterionText = 'Language ' + (id+1);
		$newItem.children('span:eq(0)').text(criterionText);

		var nameText = 'wpjobus_job_languages[' + id + '][0]';
		$newItem.find('.resume_lang_title').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_job_languages[' + id + '][1]';
		$newItem.find('.resume_lang_understanding').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_rjob_languages[' + id + '][2]';
		$newItem.find('.resume_lang_speaking').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_job_languages[' + id + '][3]';
		$newItem.find('.resume_lang_writing').attr('id', nameText).attr('name', nameText);

		//event handler for newly created element
		$newItem.children('.button_del_job_language').on('click', function () {
			$(this).parent('.option_item').remove();
		});

	});
	
	//DELETE
	$('.button_del_job_language').on('click', function() {
		$(this).parent('.option_item').remove();
	});


	//ADD INSTITUTION
	$('#template_education').hide();
	$('#submit_add_institution').on('click', function() {		
		$newItem = $('#template_education .option_item').clone().appendTo('#resume_institution').show();
		if ($newItem.prev('.option_item').size() == 1) {
			var id = parseInt($newItem.prev('.option_item').attr('id')) + 1;
		} else {
			var id = 0;	
		}
		$newItem.attr('id', id);

		var criterionText = 'Institution ' + (id+1);
		$newItem.children('span:eq(0)').text(criterionText);

		var nameText = 'wpjobus_resume_education[' + id + '][0]';
		$newItem.find('.criteria_name').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_resume_education[' + id + '][1]';
		$newItem.find('.criteria_name_two').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_resume_education[' + id + '][2]';
		$newItem.find('.criteria_from_time').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_resume_education[' + id + '][3]';
		$newItem.find('.criteria_to_time').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_resume_education[' + id + '][4]';
		$newItem.find('.criteria_location').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_resume_education[' + id + '][5]';
		$newItem.find('.criteria_notes').attr('id', nameText).attr('name', nameText);


		//event handler for newly created element
		$newItem.children('.button_del_institution').on('click', function () {
			$(this).parent('.option_item').remove();
		});

	});
	
	//DELETE
	$('.button_del_institution').on('click', function() {
		$(this).parent('.option_item').remove();
	});



	//ADD AWARD
	$('#template_award').hide();
	$('#submit_add_award').on('click', function() {		
		$newItem = $('#template_award .option_item').clone().appendTo('#resume_award').show();
		if ($newItem.prev('.option_item').size() == 1) {
			var id = parseInt($newItem.prev('.option_item').attr('id')) + 1;
		} else {
			var id = 0;	
		}
		$newItem.attr('id', id);

		var criterionText = 'Award ' + (id+1);
		$newItem.children('span:eq(0)').text(criterionText);

		var nameText = 'wpjobus_resume_award[' + id + '][0]';
		$newItem.find('.criteria_name').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_resume_award[' + id + '][1]';
		$newItem.find('.criteria_name_two').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_resume_award[' + id + '][2]';
		$newItem.find('.criteria_from_time').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_resume_award[' + id + '][3]';
		$newItem.find('.criteria_location').attr('id', nameText).attr('name', nameText);


		//event handler for newly created element
		$newItem.children('.button_del_award').on('click', function () {
			$(this).parent('.option_item').remove();
		});

	});
	
	//DELETE
	$('.button_del_award').on('click', function() {
		$(this).parent('.option_item').remove();
	});




	//ADD WORK EXPERIENCE
	$('#template_work').hide();
	$('#submit_add_work').on('click', function() {		
		$newItem = $('#template_work .option_item').clone().appendTo('#resume_work').show();
		if ($newItem.prev('.option_item').size() == 1) {
			var id = parseInt($newItem.prev('.option_item').attr('id')) + 1;
		} else {
			var id = 0;	
		}
		$newItem.attr('id', id);

		var criterionText = 'Work Experience ' + (id+1);
		$newItem.children('span:eq(0)').text(criterionText);

		var nameText = 'wpjobus_resume_work[' + id + '][0]';
		$newItem.find('.criteria_name').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_resume_work[' + id + '][1]';
		$newItem.find('.criteria_name_two').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_resume_work[' + id + '][2]';
		$newItem.find('.criteria_from_time').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_resume_work[' + id + '][3]';
		$newItem.find('.criteria_to_time').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_resume_work[' + id + '][4]';
		$newItem.find('.resume_work_job_type').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_resume_work[' + id + '][5]';
		$newItem.find('.criteria_notes').attr('id', nameText).attr('name', nameText);


		//event handler for newly created element
		$newItem.children('.button_del_work').on('click', function () {
			$(this).parent('.option_item').remove();
		});

	});
	
	//DELETE
	$('.button_del_work').on('click', function() {
		$(this).parent('.option_item').remove();
	});






	//ADD TESTIMONIALS
	$('#template_testimonials').hide();
	$('#submit_add_testimonial').on('click', function() {		
		$newItem = $('#template_testimonials .option_item').clone().appendTo('#resume_testimonials').show();
		if ($newItem.prev('.option_item').size() == 1) {
			var id = parseInt($newItem.prev('.option_item').attr('id')) + 1;
		} else {
			var id = 0;	
		}
		$newItem.attr('id', id);

		var criterionText = 'Testimonial ' + (id+1);
		$newItem.children('span:eq(0)').text(criterionText);

		var nameText = 'wpjobus_resume_testimonials[' + id + '][0]';
		$newItem.find('.criteria_name').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_resume_testimonials[' + id + '][1]';
		$newItem.find('.criteria_name_two').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_resume_testimonials[' + id + '][2]';
		$newItem.find('.criteria_notes').attr('id', nameText).attr('name', nameText);

		var nameText = 'your_image_url_img' + id + '3';
		var nameTextEmpty = '';
		$newItem.find('img.criteria-image').attr('id', nameText).attr('src', nameTextEmpty);

		var nameText = 'your_image_url' + id + '3';
		var nameTextTwo = 'wpjobus_resume_testimonials[' + id + '][3]';
		$newItem.find('input.criteria-image-url').attr('id', nameText).attr('name', nameTextTwo);

		var nameText = 'your_image_url_button_remove' + id + '3';
		$newItem.find('input.criteria-image-button-remove').attr('id', nameText);

		var nameText = 'your_image_url_button' + id + '3';
		$newItem.find('input.criteria-image-button').attr('id', nameText);


		//event handler for newly created element
		$newItem.children('.button_del_testimonial').on('click', function () {
			$(this).parent('.option_item').remove();
		});

	});
	
	//DELETE
	$('.button_del_testimonial').on('click', function() {
		$(this).parent('.option_item').remove();
	});






	//ADD PROJECTS
	$('#template_portfolio').hide();
	$('#submit_add_portfolio').on('click', function() {		
		$newItem = $('#template_portfolio .option_item').clone().appendTo('#resume_portfolio').show();
		if ($newItem.prev('.option_item').size() == 1) {
			var id = parseInt($newItem.prev('.option_item').attr('id')) + 1;
		} else {
			var id = 0;	
		}
		$newItem.attr('id', id);

		var criterionText = 'Project ' + (id+1);
		$newItem.children('span:eq(0)').text(criterionText);

		var nameText = 'wpjobus_resume_portfolio[' + id + '][0]';
		$newItem.find('.criteria_name').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_resume_portfolio[' + id + '][1]';
		$newItem.find('.criteria_name_two').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_resume_portfolio[' + id + '][2]';
		$newItem.find('.criteria_notes').attr('id', nameText).attr('name', nameText);

		var nameText = 'your_image_url_img' + id + '3';
		var nameTextEmpty = '';
		$newItem.find('img.criteria-image').attr('id', nameText).attr('src', nameTextEmpty);

		var nameText = 'your_image_url' + id + '3';
		var nameTextTwo = 'wpjobus_resume_portfolio[' + id + '][3]';
		$newItem.find('input.criteria-image-url').attr('id', nameText).attr('name', nameTextTwo);

		var nameText = 'your_image_url_button_remove' + id + '3';
		$newItem.find('input.criteria-image-button-remove').attr('id', nameText);

		var nameText = 'your_image_url_button' + id + '3';
		$newItem.find('input.criteria-image-button').attr('id', nameText);


		//event handler for newly created element
		$newItem.children('.button_del_portfolio').on('click', function () {
			$(this).parent('.option_item').remove();
		});

	});
	
	//DELETE
	$('.button_del_portfolio').on('click', function() {
		$(this).parent('.option_item').remove();
	});



	//ADD SERIVE
	$('#template_service').hide();
	$('#submit_add_service').on('click', function() {		
		$newItem = $('#template_service .option_item').clone().appendTo('#company_service').show();
		if ($newItem.prev('.option_item').size() == 1) {
			var id = parseInt($newItem.prev('.option_item').attr('id')) + 1;
		} else {
			var id = 0;	
		}
		$newItem.attr('id', id);

		var criterionText = 'Service ' + (id+1);
		$newItem.children('span:eq(0)').text(criterionText);

		var nameText = 'wpjobus_company_services[' + id + '][0]';
		$newItem.find('.company_services_name').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_company_services[' + id + '][1]';
		$newItem.find('.company_services_name_two').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_company_services[' + id + '][5]';
		$newItem.find('.company_services_notes').attr('id', nameText).attr('name', nameText);


		//event handler for newly created element
		$newItem.children('.button_del_service').on('click', function () {
			$(this).parent('.option_item').remove();
		});

	});
	
	//DELETE
	$('.button_del_service').on('click', function() {
		$(this).parent('.option_item').remove();
	});






	//ADD CLIENTS
	$('#template_clients').hide();
	$('#submit_add_client').on('click', function() {		
		$newItem = $('#template_clients .option_item').clone().appendTo('#company_clients').show();
		if ($newItem.prev('.option_item').size() == 1) {
			var id = parseInt($newItem.prev('.option_item').attr('id')) + 1;
		} else {
			var id = 0;	
		}
		$newItem.attr('id', id);

		var criterionText = 'Client ' + (id+1);
		$newItem.children('span:eq(0)').text(criterionText);

		var nameText = 'wpjobus_company_clients[' + id + '][0]';
		$newItem.find('.criteria_name').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_company_clients[' + id + '][1]';
		$newItem.find('.criteria_name_two').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_company_clients[' + id + '][2]';
		$newItem.find('.criteria_from_time').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_company_clients[' + id + '][3]';
		$newItem.find('.criteria_to_time').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_company_clients[' + id + '][4]';
		$newItem.find('.criteria_website').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_company_clients[' + id + '][5]';
		$newItem.find('.criteria_notes').attr('id', nameText).attr('name', nameText);


		//event handler for newly created element
		$newItem.children('.button_del_client').on('click', function () {
			$(this).parent('.option_item').remove();
		});

	});
	
	//DELETE
	$('.button_del_client').on('click', function() {
		$(this).parent('.option_item').remove();
	});






	//ADD PROJECTS
	$('#template_comp_portfolio').hide();
	$('#submit_add_comp_portfolio').on('click', function() {		
		$newItem = $('#template_comp_portfolio .option_item').clone().appendTo('#company_portfolio').show();
		if ($newItem.prev('.option_item').size() == 1) {
			var id = parseInt($newItem.prev('.option_item').attr('id')) + 1;
		} else {
			var id = 0;	
		}
		$newItem.attr('id', id);

		var criterionText = 'Project ' + (id+1);
		$newItem.children('span:eq(0)').text(criterionText);

		var nameText = 'wpjobus_company_portfolio[' + id + '][0]';
		$newItem.find('.criteria_name').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_company_portfolio[' + id + '][1]';
		$newItem.find('.criteria_name_two').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_company_portfolio[' + id + '][2]';
		$newItem.find('.criteria_notes').attr('id', nameText).attr('name', nameText);

		var nameText = 'your_image_url_img' + id + '3';
		var nameTextEmpty = '';
		$newItem.find('img.criteria-image').attr('id', nameText).attr('src', nameTextEmpty);

		var nameText = 'your_image_url' + id + '3';
		var nameTextTwo = 'wpjobus_company_portfolio[' + id + '][3]';
		$newItem.find('input.criteria-image-url').attr('id', nameText).attr('name', nameTextTwo);

		var nameText = 'your_image_url_button_remove' + id + '3';
		$newItem.find('input.criteria-image-button-remove').attr('id', nameText);

		var nameText = 'your_image_url_button' + id + '3';
		$newItem.find('input.criteria-image-button').attr('id', nameText);


		//event handler for newly created element
		$newItem.children('.button_del_comp_portfolio').on('click', function () {
			$(this).parent('.option_item').remove();
		});

	});
	
	//DELETE
	$('.button_del_comp_portfolio').on('click', function() {
		$(this).parent('.option_item').remove();
	});





	//ADD TESTIMONIALS
	$('#template_comp_testimonials').hide();
	$('#submit_add_comp_testimonial').on('click', function() {		
		$newItem = $('#template_comp_testimonials .option_item').clone().appendTo('#company_testimonials').show();
		if ($newItem.prev('.option_item').size() == 1) {
			var id = parseInt($newItem.prev('.option_item').attr('id')) + 1;
		} else {
			var id = 0;	
		}
		$newItem.attr('id', id);

		var criterionText = 'Testimonial ' + (id+1);
		$newItem.children('span:eq(0)').text(criterionText);

		var nameText = 'wpjobus_company_testimonials[' + id + '][0]';
		$newItem.find('.criteria_name').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_company_testimonials[' + id + '][1]';
		$newItem.find('.criteria_name_two').attr('id', nameText).attr('name', nameText);

		var nameText = 'wpjobus_company_testimonials[' + id + '][2]';
		$newItem.find('.criteria_notes').attr('id', nameText).attr('name', nameText);

		var nameText = 'your_image_url_img' + id + '3';
		var nameTextEmpty = '';
		$newItem.find('img.criteria-image').attr('id', nameText).attr('src', nameTextEmpty);

		var nameText = 'your_image_url' + id + '3';
		var nameTextTwo = 'wpjobus_company_testimonials[' + id + '][3]';
		$newItem.find('input.criteria-image-url').attr('id', nameText).attr('name', nameTextTwo);

		var nameText = 'your_image_url_button_remove' + id + '3';
		$newItem.find('input.criteria-image-button-remove').attr('id', nameText);

		var nameText = 'your_image_url_button' + id + '3';
		$newItem.find('input.criteria-image-button').attr('id', nameText);


		//event handler for newly created element
		$newItem.children('.button_del_comp_testimonial').on('click', function () {
			$(this).parent('.option_item').remove();
		});

	});
	
	//DELETE
	$('.button_del_comp_testimonial').on('click', function() {
		$(this).parent('.option_item').remove();
	});
	

});