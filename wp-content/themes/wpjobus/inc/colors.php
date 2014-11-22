<?php 

function wpcrown_wpcss_loaded() {

	// Return the lowest priority number from all the functions that hook into wp_head
	global $wp_filter;
	$lowest_priority = max(array_keys($wp_filter['wp_head']));
 
	add_action('wp_head', 'wpcrown_wpcss_head', $lowest_priority + 1);
 
	$arr = $wp_filter['wp_head'];

}
add_action('wp_head', "wpcrown_wpcss_loaded");
 
// wp_head callback functions
function wpcrown_wpcss_head() {

	global $redux_demo; 
	$wpcrown_main_color = $redux_demo['color-main'];
	$wpcrown_main_color_hover = $redux_demo['color-main-hover'];
	$wpcrown_color_second = $redux_demo['color-second'];
	$wpcrown_color_second_hover = $redux_demo['color-second-hover'];

	$wpcrown_opt_colors = $redux_demo['opt-colors'];

	if ( ! is_admin() ) {

		echo "<style type=\"text/css\">#wpadminbar { display: none; }</style>";

	}

	if($wpcrown_opt_colors) {

		echo "<style type=\"text/css\">";

		// Main Color
		if(!empty($wpcrown_main_color)) {
				
			echo "a, #navbar .main_menu .menu li.current_page_item .sub-menu a:hover, #navbar .main_menu .menu li.current_page_item .children a:hover, #navbar .main_menu .menu li.current-menu-item  .children a:hover, .main_menu ul li ul.children li a:hover, .main_menu ul li ul.sub-menu li a:hover, .main_menu ul li ul.children li.current_page_item a, .main_menu ul li ul.children li.current-menu-item a, .main_menu .menu li.current_page_item .sub-menu a:hover, .main_menu .menu li.current-menu-item  .sub-menu a:hover, .main_menu .menu li.current_page_item .children a:hover, .main_menu .menu li.current-menu-item  .children a:hover, .geo-location-button .on .fa, .geo-location-button .fa:hover, ul.custom-tabs li a.current, h4.trigger:hover, h4.trigger.active:hover, h4.trigger.active,#navbar .main_menu .menu li .sub-menu li.current_page_item a, #navbar .main_menu .menu li .children li.current_page_item a, #navbar .main_menu .menu li .children li.current_page_item a:hover, #navbar .main_menu .menu li .children li .current-menu-item a:hover, new-recipe a.btn, #print-button:hover .fa, .main_menu ul li a, .main_menu ul li ul li a, .main_menu ul li a .fa, .top_menu.account-menu ul li.first a, .top_menu.account-menu ul li.last a, a.pending-posts:hover, a.pending-posts:hover .fa, .featured-item-content-title, .featured-item-content-tagline, .widget a, .widget a:visited, .widget ul li a, .my-account-header-title .resume-section-subtitle span, .my-account-header-settings-link, .my-account-companies-link, .my-account-header-settings-link a, .my-account-job-single-feature .make-featured .fa, .my-account-company-single-feature .make-featured .fa, .my-account-company-single-publish .fa, a.button-ag-full, .my-account-job-single-edit a .fa, .my-account-company-single-edit a .fa, .my-account-header-settings-link .fa, .my-account-companies-link .fa, .my-account-company-single-title a, .my-account-job-single-title a, .resume-contact-info span a, #resume-menu .container ul li a, #company-menu .container ul li a, #job-menu .container ul li a, .job-company-desc h1, #resume-menu .container a .fa, #company-menu .container a .fa, #job-menu .container a .fa { color: ";
			echo $wpcrown_main_color;
			echo "; } ";

			echo "#contact-form #contactName:focus, #contact-form #author:focus, #contact-form #email:focus, #contact-form #url:focus, #contact-form #subject:focus, #contact-form #commentsText:focus, #contact-form #humanTest:focus { border: 1px solid ";
			echo $wpcrown_main_color;
			echo "; } ";

			echo ".main_menu ul li:hover > a, .main_menu .menu li.current_page_item a, .main_menu .menu li.current-menu-item a { color: ";
			echo $wpcrown_main_color;
			echo "; } ";

			echo "h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { color: ";
			echo $wpcrown_main_color;
			echo " !important; } ";

			echo "#comp-team-submit-clear, #comp-reset, a.button-ag-full, .resume-download-file a { background-color: ";
			echo $wpcrown_main_color;
			echo "; } ";

			echo "#promo-ad a.btn, input[type='submit'], .woocommerce span.onsale, .woocommerce-page span.onsale, .products li a.button, .woocommerce div.product form.cart .button, .woocommerce-page div.product form.cart .button, .woocommerce #content div.product form.cart .button, .woocommerce-page #content div.product form.cart .button, .woocommerce button.button, .woocommerce-page button.button, .woocommerce input.button, .woocommerce-page input.button, .woocommerce #respond input#submit, .woocommerce-page #respond input#submit, .woocommerce #content input.button, .woocommerce-page #content input.button, #top-cart .button, form.cart .button-alt, .woocommerce #content input.button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce-page #content input.button, .woocommerce-page #respond input#submit, .woocommerce-page a.button, .woocommerce-page button.button, .woocommerce-page input.button, .bbp-submit-wrapper button.button, .woocommerce .quantity .minus, .woocommerce-page .quantity .minus, .woocommerce #content .quantity .minus, .woocommerce-page #content .quantity .minus, .woocommerce .quantity .plus, .woocommerce-page .quantity .plus, .woocommerce #content .quantity .plus, .woocommerce-page #content .quantity .plus, form.cart .plus, form.cart .minus, .product-quantity .plus, .product-quantity .minus, .woocommerce .quantity input.qty, .woocommerce-page .quantity input.qty, .woocommerce #content .quantity input.qty, .woocommerce-page #content .quantity input.qty, form.cart input.qty, form.cart input.qty, .product-quantity input.qty, .pricing-plans a.btn, #edit-submit, .ads-tags a, #navbar .btn-navbar, .block-recipe-info-hover-link span, button.recipe-search-go-btn { color: #fff; background: ";
			echo $wpcrown_main_color;
			echo ";} ";

			echo ".woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price { color: ";
			echo $wpcrown_main_color;
			echo "; } ";

			echo ".ads-tags a:hover { background: #ecf0f1!important; color: ";
			echo $wpcrown_main_color;
			echo "!important; } ";

			echo ".author-list-link-profile a { border: solid 1px ";
			echo $wpcrown_main_color;
			echo "; } ";

			echo "#thumbs-wrapper-feat-recipes a:hover > .image-thin-border > .image-big-border, #thumbs-wrapper-feat-recipes a.selected > .image-thin-border > .image-big-border, #thumbs a:hover > .image-thin-border > .image-big-border, #thumbs a.selected > .image-thin-border > .image-big-border { border-color: ";
			echo $wpcrown_main_color;
			echo "; } ";

		}

		// Main Color Hover
		if(!empty($wpcrown_main_color_hover)) {
				
			echo "a:hover, a:active, a:focus, a:hover, footer.comment-meta a:hover, footer.comment-meta a:focus, a:hover, .top_menu.account-menu ul li a:hover, .widget a:hover, .socket a:hover, .widget ul li a:hover, .top_menu.new-posts-menu ul li ul li a:hover, .new-posts-menu ul li ul.sub-menu li:hover .fa, .top_menu.new-posts-menu ul li ul li a:hover, #companies-block-list-ul li a:hover .company-list-name, .my-account-header-settings-link:hover, .my-account-header-settings-link:hover .fa, .my-account-companies-link:hover, .my-account-companies-link:hover .fa, .my-account-job-single-feature .make-featured:hover, .my-account-company-single-feature .make-featured:hover, .my-account-company-single-publish:hover, .my-account-job-single-feature .make-featured:hover .fa, .my-account-company-single-feature .make-featured:hover .fa, .my-account-company-single-publish:hover .fa, .my-account-job-single-edit a:hover, .my-account-company-single-edit a:hover, .my-account-job-single-edit a:hover .fa, .my-account-company-single-edit a:hover .fa, .resume-contact-info span a:hover { color: ";
			echo $wpcrown_main_color_hover;
			echo "; } ";

			echo "h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover, a:focus, h1 a:focus, h2 a:focus, h3 a:focus, h4 a:focus, h5 a:focus, h6 a:focus { color: ";
			echo $wpcrown_main_color_hover;
			echo " !important; } ";

			echo "#comp-team-submit-clear:hover, #comp-reset:hover, a.button-ag-full:hover, .resume-download-file a:hover { color: #fff; background-color: ";
			echo $wpcrown_main_color_hover;
			echo "; } ";

			echo "#promo-ad a.btn:hover, input[type='submit']:hover, .products li a.button:hover, .woocommerce div.product form.cart .button:hover, .woocommerce-page div.product form.cart .button:hover, .woocommerce #content div.product form.cart .button:hover, .woocommerce-page #content div.product form.cart .button:hover, .woocommerce button.button:hover, .woocommerce-page button.button:hover, .woocommerce input.button:hover, .woocommerce-page input.button:hover, .woocommerce #respond input#submit:hover, .woocommerce-page #respond input#submit:hover, .woocommerce #content input.button:hover, .woocommerce-page #content input.button:hover, #top-cart .button:hover, form.cart .button-alt:hover, .woocommerce #content input.button:hover, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce-page #content input.button:hover, .woocommerce-page #respond input#submit:hover, .woocommerce-page a.button:hover, .woocommerce-page button.button:hover, .woocommerce-page input.button:hover, .bbp-submit-wrapper button.button:hover, .woocommerce .quantity .minus:hover, .woocommerce-page .quantity .minus:hover, .woocommerce #content .quantity .minus:hover, .woocommerce-page #content .quantity .minus:hover,.woocommerce .quantity .plus:hover, .woocommerce-page .quantity .plus:hover, .woocommerce #content .quantity .plus:hover, .woocommerce-page #content .quantity .plus:hover, form.cart .plus:hover, form.cart .minus:hover, .product-quantity .plus:hover, .product-quantity .minus:hover, .pricing-plans a.btn:hover, #edit-submit:hover, #navbar .btn-navbar:hover, button.recipe-search-go-btn:hover { color: #fff; background: ";
			echo $wpcrown_main_color_hover;
			echo ";} ";

			echo ".author-list-link-profile a:hover { color: #fff; background: ";
			echo $wpcrown_main_color_hover;
			echo "!important; border: solid 1px ";
			echo $wpcrown_main_color_hover;
			echo "} ";

		}

		// Main Color
		if(!empty($wpcrown_color_second)) {

			echo ".save-resume-block .draft-resume-button input, .save-resume-block .draft-resume-button .submit-loading, .wpjobus-stat-circle, .socket, #blog .ui-slider-horizontal .ui-slider-handle, #blog .ui-slider .ui-slider-range, .education-period-circle, .company-services-icon { color: #fff; background-color: ";
			echo $wpcrown_color_second;
			echo ";} ";

			echo "footer .widget .block-title, .resume-section-title, .resume-section-title .fa, .button-ag span.button-inner, .new-posts-menu .button-ag span.button-inner .fa, .button-ag, .banner-hello, .resume-author-name, .main-skills-item-title, .main-skills-item-title-language, .main-skills-item-title-language .fa, .work-experience-org-name, .work-experience-job-type, .resume-contact-info .fa, .company-services-title, #single-company .work-experience-job-type a { color: ";
			echo $wpcrown_color_second;
			echo ";} ";

			echo ".button-ag { border: solid 2px ";
			echo $wpcrown_color_second;
			echo ";} ";

			echo "ul#homepage-posts-block.tabs li.active, ul#homepage-posts-block.tabs li:hover, #companies-block-list-ul li a:hover, .work-experience-third-block::after { border-bottom: solid 1px ";
			echo $wpcrown_color_second;
			echo ";} ";

			echo ".education-period-circle::after, .education-period-circle::before { border-left: solid 1px ";
			echo $wpcrown_color_second;
			echo ";} ";

			echo ".job-experience-holder .one_fourth { border-top: solid 1px ";
			echo $wpcrown_color_second;
			echo ";} ";

		}

		// Main Color Hover
		if(!empty($wpcrown_color_second_hover)) {

			echo ".save-resume-block .draft-resume-button input:hover, .new-posts-menu ul li:hover .button-ag span.button-inner { color: #fff; background-color: ";
			echo $wpcrown_color_second_hover;
			echo ";} ";

			echo ".new-posts-menu ul li:hover .button-ag { color: #fff; background-color: ";
			echo $wpcrown_color_second_hover;
			echo ";} ";

			echo "#single-company .work-experience-job-type a:hover { color: ";
			echo $wpcrown_color_second_hover;
			echo ";} ";

		}

		echo "</style>";

	}

}