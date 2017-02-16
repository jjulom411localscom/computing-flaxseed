 /**
  -webkit-background-clip: text Polyfill

  # What? #
  A polyfill which replaces the specified element with a SVG
  in browser where "-webkit-background-clip: text"
  is not available.

  Fork it on GitHub
  https://github.com/TimPietrusky/background-clip-text-polyfill

  # 2013 by Tim Pietrusky
  # timpietrusky.com
**/

Element.prototype.backgroundClipPolyfill=function(){function t(t,e){for(var i in e)t.setAttribute(i,e[i])}function e(t){return s.createElementNS("http://www.w3.org/2000/svg",t)}function i(){var i=arguments[0],n=e("svg"),s=e("pattern"),h=e("image"),d=e("text");return t(n,{width:window.svgHeadline[i.number].parentWidth,height:window.svgHeadline[i.number].parentHeight}),t(s,{id:i.id,patternUnits:"userSpaceOnUse",width:window.svgHeadline[i.number].parentWidth,height:window.svgHeadline[i.number].parentHeight}),t(h,{width:"100%",height:"100%",preserveAspectRatio:"xMinYMin slice"}),h.setAttributeNS("http://www.w3.org/1999/xlink","xlink:href",i.url),t(d,{width:window.svgHeadline[i.number].width,height:window.svgHeadline[i.number].height,x:window.svgHeadline[i.number].left+3,y:window.svgHeadline[i.number].top,"class":i["class"],style:window.svgHeadline[i.number].style+"fill:url(#"+i.id+");"}),d.textContent=i.text,n.appendChild(d),s.appendChild(h),n.appendChild(s),n}var n=arguments[0],s=document,h=(s.body,this),d=new Image;d.onload=function(){var t=i({number:n.number,id:n.patternID,url:n.patternURL,"class":n["class"],width:this.width,height:this.height,text:h.textContent});h.parentNode.replaceChild(t,h)},d.src=n.patternURL},rebuildWithSvg=function(){window.svgHeadline={},$.each($(".canvas-headline"),function(t){$(this).parent().width();thisWidth=$(this).width(),styles="",styles+="font: "+$(this).css("font-style")+" "+$(this).css("font-weight")+" "+$(this).css("font-size")+" "+$(this).css("font-family")+"; ",$(this).closest(".canvas-title-block").length?window.svgHeadline[t]={parentWidth:$(this).outerWidth(),parentHeight:$(this).outerHeight(),width:$(this).find(".text").width(),height:$(this).find(".text").height(),top:parseInt($(this).css("padding-top").replace("px",""))+.8*$(this).find(".text").height(),left:$(this).find(".text").offset().left-$(this).offset().left,style:styles}:window.svgHeadline[t]={parentWidth:$(this).width(),parentHeight:$(this).height(),width:$(this).find(".text").width(),height:$(this).find(".text").height(),top:.87*$(this).height(),left:$(this).find(".text").offset().left-$(this).offset().left,style:styles},this.backgroundClipPolyfill({number:t,patternID:"mypattern_"+t,patternURL:$(this).attr("data-img"),"class":"canvas-headline"})})},$(document).on("ready",function(){$(".canvas-title-block").length&&$.each($(".canvas-title-block"),function(){var t=$(this).closest(".wpb_column");t.outerWidth()==$(window).width()&&t.css({"padding-left":0,"padding-right":0})}),void 0==document.body.style.webkitBackgroundClip&&setTimeout(function(){rebuildWithSvg()},400)});