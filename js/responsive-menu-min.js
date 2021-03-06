/**
 * This script adds the accessibility-ready responsive menu to the AgentPress Pro theme.
 *
 * @package AgentPress\JS
 * @author StudioPress
 * @license GPL-2.0+
 */

jQuery(function( $ ){

	$("header .genesis-nav-menu, .nav-primary .genesis-nav-menu").addClass("responsive-menu").before('<div class="responsive-menu-icon"></div>');
	
	$(".responsive-menu-icon").click(function(){
		$(this).next("header .genesis-nav-menu, .nav-primary .genesis-nav-menu").slideToggle();
		 window.setTimeout(function() {
		$("header .widget_nav_menu").toggleClass("tfs-open");
		 	},5);
	});

	$(window).resize(function(){
		if(window.innerWidth > 768) {
			$("header .genesis-nav-menu, .nav-primary .genesis-nav-menu, nav .sub-menu").removeAttr("style");
			$(".responsive-menu > .menu-item").removeClass("menu-open");
		}
	});

	$(".responsive-menu > .menu-item").click(function(event){
		if (event.target !== this)
		return;
			$(this).find(".sub-menu:first").slideToggle(function() {
			$(this).parent().toggleClass("menu-open");
		});
	});

});