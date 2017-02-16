/* =========================================================
 * jquery.vc_chart.js v1.0
 * =========================================================
 * Copyright 2013 Wpbakery
 *
 * Jquery chart plugin for the Visual Composer(modified).
 * ========================================================= */
!function(t){t.each(t(".vsc_content_slider"),function(){var a={pager:"true"==t(this).attr("data-pagination"),controls:"true"==t(this).attr("data-arrows"),auto:"true"==t(this).attr("data-autoplay"),infiniteLoop:"true"==t(this).attr("data-loop"),speed:t(this).attr("data-speed"),pause:t(this).attr("data-interval"),autoDelay:t(this).attr("data-interval"),nextText:"",prevText:""};t(this).find(".bx-slider").bxSlider(a)})}(window.jQuery);