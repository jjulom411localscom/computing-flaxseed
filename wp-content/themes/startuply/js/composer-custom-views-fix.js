/* =========================================================
 * composer-custom-views fix
 * ====================================================== */

!function(o){window.VcRowView.prototype.buildDesignHelpers=function(){var e=this.model,n=this.$el,r=n.find("> .controls .column_toggle"),a=e.getParam("vsc_bg_image"),c=e.getParam("vsc_bg_color"),i=e.getParam("vsc_youtube_url"),t=e.getParam("el_id");n.find("> .controls .vc_row_color").remove(),n.find("> .controls .vc_row_image").remove(),n.find("> .controls .vc_row_video").remove(),n.find("> .controls .vc_row-hash-id").remove(),n.find("> .controls .vc_row_section_break").remove(),n.is(".wpb_vc_row_inner")||o('<span class="vc_control vc_row_section_break" title="Page break">PAGE SECTION</span>').insertBefore(r),a&&o.ajax({type:"POST",url:window.ajaxurl,dataType:"html",data:{action:"wpb_single_image_src",content:a,size:"thumbnail",_vcnonce:window.vcAdminNonce}}).done(function(e){e&&o('<span class="vc_row_image" style="background-image: url('+e+');" title="'+window.i18nLocale.row_background_image+'"></span>').insertAfter(r)}),_.isEmpty(t)||o('<span class="vc_row-hash-id"></span>').text("#"+t).insertAfter(r),i&&o('<span class="vc_row_video" title="Row background video"></span>').insertAfter(r),c&&o('<span class="vc_row_color" style="background-color: '+c+'" title="'+window.i18nLocale.row_background_color+'"></span>').insertAfter(r)}}(window.jQuery);
