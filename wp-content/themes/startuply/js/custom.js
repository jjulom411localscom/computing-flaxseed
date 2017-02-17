/**
 *
 * StartuplyWP JS functions
 *
 * @author Vivaco
 * @license Commercial License
 * @link http://startuplywp.com
 * @copyright 2015 Vivaco
 * @package Startuply
 * @version 2.0.0
 *
 */

! function(t) {
    if (!t.fn.style) {
        var e = function(t) {
                return t.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&")
            },
            r = !!CSSStyleDeclaration.prototype.getPropertyValue;
        r || (CSSStyleDeclaration.prototype.getPropertyValue = function(t) {
            return this.getAttribute(t)
        }, CSSStyleDeclaration.prototype.setProperty = function(t, r, n) {
            this.setAttribute(t, r);
            var n = "undefined" != typeof n ? n : "";
            if ("" != n) {
                var i = new RegExp(e(t) + "\\s*:\\s*" + e(r) + "(\\s*;)?", "gmi");
                this.cssText = this.cssText.replace(i, t + ": " + r + " !" + n + ";")
            }
        }, CSSStyleDeclaration.prototype.removeProperty = function(t) {
            return this.removeAttribute(t)
        }, CSSStyleDeclaration.prototype.getPropertyPriority = function(t) {
            var r = new RegExp(e(t) + "\\s*:\\s*[^\\s]*\\s*!important(\\s*;)?", "gmi");
            return r.test(this.cssText) ? "important" : ""
        }), t.fn.style = function(t, e, r) {
            var n = this.get(0);
            if ("undefined" == typeof n) return this;
            var i = this.get(0).style;
            return "undefined" != typeof t ? "undefined" != typeof e ? (r = "undefined" != typeof r ? r : "", i.setProperty(t, e, r), this) : i.getPropertyValue(t) : i
        }
    }
}(jQuery);

// Main theme functions start
var Startuply;
Startuply = {
        options: {
            log: !1,
            animations: !0
        },
        flexsliderOptions: {
            manualControls: ".flex-manual .switch",
            nextText: "",
            prevText: "",
            startAt: 1,
            slideshow: !1,
            direction: "horizontal",
            animation: "slide"
        },
        mobileMenuView: !1,
        homePage: !1,
        log: function(e) {
            this.options.log && console.log("%cStartupLy Log: " + e, "color: #1ac6ff")
        },
        checkMobile: function() {
            /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ? ($(".parallax-section").css({
                "background-attachment": "scroll"
            }), $.each($(".wpb_animate_when_almost_visible"), function() {
                $(this).removeClass("wpb_animate_when_almost_visible").attr("style", "")
            }), $(".animated").css("opacity", 1)) : ($elems = $('.parallax-section[id^="parallax-"]'), $('.parallax-section[id^="parallax-"]').parallax("50%", .4))
        },
        getThemeOptions: function() {
            var e = this;
            e.stickyMenu = "undefined" != typeof themeOptions && themeOptions.stickyMenu ? themeOptions.stickyMenu : "all_pages", e.stickyMenuOffset = "undefined" != typeof themeOptions && themeOptions.menuPosition ? +themeOptions.menuPosition : 600, e.mobileMainMenuMod = "undefined" != typeof themeOptions && themeOptions.mobileMainMenuMod ? +themeOptions.mobileMainMenuMod : !1, e.mobileMenuMod = "undefined" != typeof themeOptions && themeOptions.mobileMenuMod ? +themeOptions.mobileMenuMod : !1, e.mobileMenu = !1, e.smoothScroll = "undefined" != typeof themeOptions && themeOptions.smoothScroll ? +themeOptions.smoothScroll : 0, e.smoothScrollSpeed = "undefined" != typeof themeOptions && themeOptions.smoothScrollSpeed ? +themeOptions.smoothScrollSpeed : 800
        },
        setPageOptions: function() {
            var e = this;
            $("body").is(".home") && (e.homePage = !0), (e.mobileMainMenuMod && e.homePage || e.mobileMenuMod && !e.homePage) && (e.mobileMenu = !0, $("body").addClass("m-a"))
        },
        mobileMenuStatus: function() {
            var e = this;
            window.innerWidth <= 1024 || e.mobileMenu ? e.mobileMenuView = !0 : e.mobileMenuView = !1, e.mobileMenuView ? $(".navigation-header .navbar-collapse").css({
                height: $(window).height(),
                "max-height": $(window).height()
            }) : ($(".navigation-header .navbar-collapse").css({
                height: "",
                "max-height": ""
            }), $(".dropdown").removeClass("opened"), $(".dropdown-menu").css("display", ""))
        },
        fullColumnHeight: function() {
            $.each($(".vc_row-fluid.window_height"), function() {
                $(this).is(".vsc_inner") || $(this).css("min-height", $(window).height())
            }), $.each($(".wpb_column.full_height"), function() {
                "none" == $(this).css("float") ? $(this).height("auto") : ($(this).height("auto"), $(this).outerHeight($(this).closest(".row-element").height()))
            }), $.each($(".vc_row-fluid.window_height.vsc_inner"), function() {
                $(this).css("min-height", $(this).closest(".wpb_column").height())
            }), $.each($(".vc_row-fluid.centered-content"), function() {
                var e = $(this).outerHeight(),
                    t = $(this).find(">.container"),
                    i = 0,
                    n = 0;
                t.length || (t = $(this).find(".column_container").first()), i = t.outerHeight(), n = (e - i) / 2, $(this).css({
                    "padding-top": n,
                    "padding-bottom": n
                })
            })
        },
        smoothScrollInit: function() {
            var e = this;
            ! function() {
                function t() {
                    var e = !1;
                    e && c("keydown", a), $.keyboardSupport && !e && l("keydown", a)
                }

                function i() {
                    if (document.body) {
                        var e = document.body,
                            i = document.documentElement,
                            n = window.innerHeight,
                            o = e.scrollHeight;
                        if (M = document.compatMode.indexOf("CSS") >= 0 ? i : e, v = e, t(), k = !0, top != self) y = !0;
                        else if (o > n && (e.offsetHeight <= n || i.offsetHeight <= n)) {
                            var a = !1,
                                d = function() {
                                    a || i.scrollHeight == document.height || (a = !0, setTimeout(function() {
                                        i.style.height = document.height + "px", a = !1
                                    }, 500))
                                };
                            if (i.style.height = "auto", setTimeout(d, 10), M.offsetHeight <= n) {
                                var s = document.createElement("div");
                                s.style.clear = "both", e.appendChild(s)
                            }
                        }
                        $.fixedBackground || b || (e.style.backgroundAttachment = "scroll", i.style.backgroundAttachment = "scroll")
                    }
                }

                function n(e, t, i, n) {
                    if (n || (n = 1e3), h(t, i), 1 != $.accelerationMax) {
                        var o = +new Date,
                            a = o - H;
                        if (a < $.accelerationDelta) {
                            var d = (1 + 30 / a) / 2;
                            d > 1 && (d = Math.min(d, $.accelerationMax), t *= d, i *= d)
                        }
                        H = +new Date
                    }
                    if (x.push({
                            x: t,
                            y: i,
                            lastX: 0 > t ? .99 : -.99,
                            lastY: 0 > i ? .99 : -.99,
                            start: +new Date
                        }), !T) {
                        var s = e === document.body,
                            r = function() {
                                for (var o = +new Date, a = 0, d = 0, l = 0; l < x.length; l++) {
                                    var c = x[l],
                                        u = o - c.start,
                                        h = u >= $.animationTime,
                                        p = h ? 1 : u / $.animationTime;
                                    $.pulseAlgorithm && (p = g(p));
                                    var f = c.x * p - c.lastX >> 0,
                                        m = c.y * p - c.lastY >> 0;
                                    a += f, d += m, c.lastX += f, c.lastY += m, h && (x.splice(l, 1), l--)
                                }
                                s ? window.scrollBy(a, d) : (a && (e.scrollLeft += a), d && (e.scrollTop += d)), t || i || (x = []), x.length ? I(r, e, n / $.frameRate + 1) : T = !1
                            };
                        I(r, e, 0), T = !0
                    }
                }

                function o(e) {
                    k || i();
                    var t = e.target,
                        o = r(t);
                    if (!o || e.defaultPrevented || u(v, "embed") || u(t, "embed") && /\.pdf/i.test(t.src)) return !0;
                    var a = e.wheelDeltaX || 0,
                        d = e.wheelDeltaY || 0;
                    return a || d || (d = e.wheelDelta || 0), !$.touchpadSupport && p(d) ? !0 : (Math.abs(a) > 1.2 && (a *= $.stepSize / 120), Math.abs(d) > 1.2 && (d *= $.stepSize / 120), n(o, -a, -d), void e.preventDefault())
                }

                function a(e) {
                    var t = e.target,
                        i = e.ctrlKey || e.altKey || e.metaKey || e.shiftKey && e.keyCode !== S.spacebar;
                    if (/input|textarea|select|embed/i.test(t.nodeName) || t.isContentEditable || e.defaultPrevented || i) return !0;
                    if (u(t, "button") && e.keyCode === S.spacebar) return !0;
                    var o, a = 0,
                        d = 0,
                        s = r(v),
                        l = s.clientHeight;
                    switch (s == document.body && (l = window.innerHeight), e.keyCode) {
                        case S.up:
                            d = -$.arrowScroll;
                            break;
                        case S.down:
                            d = $.arrowScroll;
                            break;
                        case S.spacebar:
                            o = e.shiftKey ? 1 : -1, d = -o * l * .9;
                            break;
                        case S.pageup:
                            d = .9 * -l;
                            break;
                        case S.pagedown:
                            d = .9 * l;
                            break;
                        case S.home:
                            d = -s.scrollTop;
                            break;
                        case S.end:
                            var c = s.scrollHeight - s.scrollTop - l;
                            d = c > 0 ? c + 10 : 0;
                            break;
                        case S.left:
                            a = -$.arrowScroll;
                            break;
                        case S.right:
                            a = $.arrowScroll;
                            break;
                        default:
                            return !0
                    }
                    n(s, a, d), e.preventDefault()
                }

                function d(e) {
                    v = e.target
                }

                function s(e, t) {
                    for (var i = e.length; i--;) O[D(e[i])] = t;
                    return t
                }

                function r(e) {
                    var t = [],
                        i = M.scrollHeight;
                    do {
                        var n = O[D(e)];
                        if (n) return s(t, n);
                        if (t.push(e), i === e.scrollHeight) {
                            if (!y || M.clientHeight + 10 < i) return s(t, document.body)
                        } else if (e.clientHeight + 10 < e.scrollHeight && (overflow = getComputedStyle(e, "").getPropertyValue("overflow-y"), "scroll" === overflow || "auto" === overflow)) return s(t, e)
                    } while (e = e.parentNode)
                }

                function l(e, t, i) {
                    window.addEventListener(e, t, i || !1)
                }

                function c(e, t, i) {
                    window.removeEventListener(e, t, i || !1)
                }

                function u(e, t) {
                    return (e.nodeName || "").toLowerCase() === t.toLowerCase()
                }

                function h(e, t) {
                    e = e > 0 ? 1 : -1, t = t > 0 ? 1 : -1, (_.x !== e || _.y !== t) && (_.x = e, _.y = t, x = [], H = 0)
                }

                function p(e) {
                    if (e) {
                        e = Math.abs(e), C.push(e), C.shift(), clearTimeout(P);
                        var t = C[0] == C[1] && C[1] == C[2],
                            i = f(C[0], 120) && f(C[1], 120) && f(C[2], 120);
                        return !(t || i)
                    }
                }

                function f(e, t) {
                    return Math.floor(e / t) == e / t
                }

                function m(e) {
                    var t, i, n;
                    return e *= $.pulseScale, 1 > e ? t = e - (1 - Math.exp(-e)) : (i = Math.exp(-1), e -= 1, n = 1 - Math.exp(-e), t = i + n * (1 - i)), t * $.pulseNormalize
                }

                function g(e) {
                    return e >= 1 ? 1 : 0 >= e ? 0 : (1 == $.pulseNormalize && ($.pulseNormalize /= m(1)), m(e))
                }
                var v, w = {
                        frameRate: 150,
                        animationTime: e.smoothScrollSpeed,
                        stepSize: 120,
                        pulseAlgorithm: !0,
                        pulseScale: 8,
                        pulseNormalize: 1,
                        accelerationDelta: 20,
                        accelerationMax: 1,
                        keyboardSupport: !0,
                        arrowScroll: 50,
                        touchpadSupport: !0,
                        fixedBackground: !0,
                        excluded: ""
                    },
                    $ = w,
                    b = !1,
                    y = !1,
                    _ = {
                        x: 0,
                        y: 0
                    },
                    k = !1,
                    M = document.documentElement,
                    C = [120, 120, 120],
                    S = {
                        left: 37,
                        up: 38,
                        right: 39,
                        down: 40,
                        spacebar: 32,
                        pageup: 33,
                        pagedown: 34,
                        end: 35,
                        home: 36
                    },
                    $ = w,
                    x = [],
                    T = !1,
                    H = +new Date,
                    O = {};
                setInterval(function() {
                    O = {}
                }, 1e4);
                var P, D = function() {
                        var e = 0;
                        return function(t) {
                            return t.uniqueID || (t.uniqueID = e++)
                        }
                    }(),
                    I = function() {
                        return window.requestAnimationFrame || window.webkitRequestAnimationFrame || function(e, t, i) {
                            window.setTimeout(e, i || 1e3 / 60)
                        }
                    }(),
                    A = /chrome/i.test(window.navigator.userAgent),
                    E = "onmousewheel" in document;
                E && A && (l("mousedown", d), l("mousewheel", o), l("load", i))
            }()
        },
        checkMobile: function() {
            /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || $(window).width() < this.options.mobileMenuMaxWidth ? (this.mobileDevice = !0, this.log("Mobile device")) : this.log("Desktop")
        },
        initVideoBackground: function() {
            $('div[class*="ytp-player"]').each(function() {
                var e, t, i, n = $(this),
                    o = parseInt(n.css("padding-top")),
                    a = parseInt(n.css("padding-bottom")),
                    d = n.data("token"),
                    s = n.data("videoUrl").match("[\\?&]v=([^&#]*)"),
                    r = window["vsc_vbg_" + d];
                if (n.css("height", n.outerHeight()), n.children().not(".row-overlay").first().css({
                        "padding-top": o,
                        "padding-bottom": a
                    }), n.style("padding-top", "0", "important"), n.style("padding-bottom", "0", "important"), Startuply.checkMobile()) $(".ytp-player-" + r.id).height(window.innerHeight).addClass("no-video-bg");
                else if (t = $(".ytp-player-" + r.id).mb_YTPlayer(), s && s.length > 1 && (e = s[1], n.css({
                        "background-image": 'url("http://img.youtube.com/vi/' + e + '/maxresdefault.jpg")',
                        "background-size": "cover"
                    })), "none" != n.attr("data-controls")) {
                    i = '<div class="video-conrols"><i class="yt-play-btn-big"' + ("true" == n.attr("data-autoplay") ? ' style="display: none"' : "") + '></i><div class="bottom"><div class="controls-container ' + n.attr("data-controls") + '"><i class="yt-play-toggle' + ("false" == n.attr("data-autoplay") ? " active" : "") + '"></i><i class="yt-mute-toggle ' + ("true" == n.attr("data-mute") ? " active" : "") + '"></i><div class="yt-volume-slider"></div></div></div><div>', $(".ytp-player-" + r.id).append(i);
                    var l = n.find(".yt-play-btn-big"),
                        c = n.find(".yt-play-toggle"),
                        u = n.find(".yt-mute-toggle"),
                        h = n.find(".yt-volume-slider");
                    h.slider({
                        range: "min",
                        min: 0,
                        max: 100,
                        step: 5,
                        value: 50,
                        slide: function(e, i) {
                            t.setYTPVolume(i.value)
                        }
                    }), l.on("click", function() {
                        t.YTPPlay()
                    }), c.on("click", function() {
                        $(this).is(".active") ? t.YTPPlay() : t.YTPPause()
                    }), u.on("click", function() {
                        $(this).is(".active") ? u.removeClass("active") : u.addClass("active"), t.toggleVolume()
                    }), t.on("YTPStart", function(e) {
                        l.fadeOut(300), c.removeClass("active")
                    }), t.on("YTPPause", function(e) {
                        l.fadeIn(200), c.addClass("active")
                    }), t.on("YTPData", function(e) {
                        console.log(e)
                    })
                }
            })
        },
        initEddCheckout: function() {
            var e = $("#edd_checkout_wrap");
            if (e.length) {
                var t, i, n, o, a, d = $("#edd_checkout_cart"),
                    s = $("#edd_purchase_form > *").not("#edd_purchase_form_wrap"),
                    r = $("#edd_purchase_form_wrap"),
                    l = $('<div class="edd-checkout-navigation"><ul class="edd-checkout-navigation-list"> <li class="edd-checkout-navigation-list-item"><span data-step="0" class="edd-checkout-navigation-list-item-link active">Review Order</span></li> <li class="edd-checkout-navigation-list-item"><span data-step="1" class="edd-checkout-navigation-list-item-link">Payment Method</span></li> <li class="edd-checkout-navigation-list-item"><span data-step="2" class="edd-checkout-navigation-list-item-link">Billing details</span></li></ul></div>'),
                    c = $('<div class="edd-checkout-navigation-controls clearfix"><a href="#" class="prev hidden btn btn-outline-color base_clr_bg base_clr_brd base_clr_txt">PREVIOUS</a> <a href="#" class="next btn btn-solid base_clr_bg">NEXT STEP</a></div>');
                if (!d.length) return;
                e.prepend(l), e.append(c), d.wrap('<div class="edd-checkout-step active"></div>'), s.wrapAll('<div class="edd-checkout-step"></div>'), r.wrap('<div class="edd-checkout-step"></div>'), s.find(".edd-gateway").after('<i class="pseudo-radio"></i>'), e.find("#edd-gateway-option-paypal .pseudo-radio").after('<span class="paypal-icon"></span>'), i = e.find(".edd-checkout-step"), n = d.parent(), o = s.parent(), a = r.parent(), n.prepend('<h3 class="edd-checkout-step-title">REVIEW YOUR ORDER</h3>'), o.prepend('<h3 class="edd-checkout-step-title">PAYMENT METHOD</h3>'), a.prepend('<h3 class="edd-checkout-step-title">BILLING DETAILS</h3>'), t = [n, o, a], r.length || (t = [n, o], l.find('.edd-checkout-navigation-list-item-link[data-step="1"]').parent().remove(), l.find('.edd-checkout-navigation-list-item-link[data-step="2"]').attr("data-step", "1"), o.find("h3").text("BILLING DETAILS")), l.on("click", ".edd-checkout-navigation-list-item-link", function() {
                    var e = $(this),
                        n = parseInt(e.attr("data-step"));
                    e.is(".active") || (l.find(".edd-checkout-navigation-list-item-link").removeClass("active"), e.addClass("active"), i.removeClass("active"), t[n].addClass("active"), c.find(".btn").removeClass("hidden"), n === t.length - 1 ? c.find(".next").addClass("hidden") : 0 === n && c.find(".prev").addClass("hidden"))
                }), c.on("click", ".btn", function(e) {
                    e.preventDefault();
                    var t = l.find(".edd-checkout-navigation-list-item-link.active").parent(),
                        i = t.next(),
                        n = t.prev();
                    $(this).is(".next") && i.length ? i.find(".edd-checkout-navigation-list-item-link").trigger("click") : $(this).is(".prev") && n.length && n.find(".edd-checkout-navigation-list-item-link").trigger("click")
                })
            }
        },
        initEddProductPage: function() {
            if ($(".edd-product-main-pics").length && $(".edd-product-thumbs").length && "function" == typeof $.fn.bxSlider) {
                $(".edd-product-main-pics").wrap('<div class="edd-slider-wrapper">'), $(".edd-product-thumbs").wrap('<div class="edd-pager-wrapper">');
                var e, t;
                $(".edd-product-main-pics li").length && $(".edd-product-thumbs").length ? (e = $(".edd-product-main-pics").bxSlider({
                    prevText: "",
                    nextText: "",
                    pager: !1,
                    adaptiveHeight: !0
                }), t = $(".edd-product-thumbs").bxSlider({
                    prevText: "",
                    nextText: "",
                    pager: !1,
                    maxSlides: 5,
                    slideWidth: 125,
                    slideMargin: 9,
                    moveSlides: 4
                }), $(".edd-product-pic-slider .bx-controls-direction a").addClass("base_clr_bg"), $(".edd-product-thumbs").on("click", ".product-pic", function() {
                    var t = $(this),
                        i = t.attr("data-img-id"),
                        n = $(".edd-product-main-pics").find("[data-img-id=" + i + "]");
                    e.goToSlide(n.index() - 1)
                })) : $(".edd-product-pic-slider").remove()
            }
            $("#sidebar .edd-add-to-cart").length && $(".edd-add-to-cart").removeClass("btn-sm").addClass("btn-lg"), $("#sidebar .edd_go_to_checkout").length && $(".edd_go_to_checkout ").removeClass("btn-sm").addClass("btn-lg"), $("#sidebar .edd_download_purchase_form .edd_price_options").length && $(".product-price").addClass("price-options")
        },
        progressBar: function() {
            "undefined" != typeof $.fn.waypoint ? $(".vsc_progress_bar").each(function(e) {
                $(this).waypoint(function() {
                    var t = $(this),
                        i = t.find(".vsc_bar"),
                        n = i.data("percentage-value");
                    setTimeout(function() {
                        i.css({
                            width: n + "%"
                        })
                    }, 10 * e)
                }, {
                    offset: "95%"
                })
            }) : $(".vsc_progress_bar").each(function() {
                var e = $(this).find(".vsc_bar");
                e.css("width", e.data("percentage-value") + "%")
            })
        },
        stickyMenuInit: function() {
            var e = this,
                t = !1;
            menuTriggerOld = !1, $(window).on("scroll", function() {
                var i = $(this).scrollTop();
                t = i >= e.stickyMenuOffset ? !0 : !1, t != menuTriggerOld && (t ? e.stickMenu() : e.unstickMenu(), menuTriggerOld = t)
            })
        },
        stickMenu: function() {
            $(".navigation-header").addClass("no-transition"), $(".navigation-header").css("top", -($(".navigation-header").height() + 10)), $(".navigation-header").addClass("fixmenu-clone"), setTimeout(function() {
                $(".navigation-header").css("top", 0), $(".navigation-header").removeClass("no-transition")
            }, 30), $(".navbar-collapse").not(".collapsed").length && $(".navbar-collapse").not(".collapsed").closest(".navigation-header").find(".navigation-toggle").trigger("click")
        },
        unstickMenu: function() {
            $(".navigation-header").addClass("no-transition"), $(".navigation-header").removeClass("fixmenu-clone"), $(".navigation-header").css("top", ""), setTimeout(function() {
                $(".navigation-header").removeClass("no-transition")
            }, 30), $(".navbar-collapse").not(".collapsed").length && setTimeout(function() {
                $(".navbar-collapse").not(".collapsed").closest(".navigation-header").find(".navigation-toggle").trigger("click")
            }, 100)
        },
        testimonialsSliderInit: function() {
            $(".testimonials-slider").flexslider(this.flexsliderOptions)
        },
        prettyPhotoInit: function() {
            $(".portfolio[data-pretty^='prettyPhoto[port_gal]']").prettyPhoto()
        },
        onePageNavInit: function() {
            if ("undefined" != typeof $.fn.waypoint) {
                var e = $('header .navigation-bar a[href*="#"]').not('[href="#"]');
                e.each(function(e) {
                    var t = $(this).attr("href"),
                        i = t.substring(t.indexOf("#"), t.length),
                        n = $(i);
                    n.length && n.waypoint(function() {
                        var e = $(this).attr("id"),
                            t = $('.navigation-bar a[href="#' + e + '"]');
                        $('.navigation-bar a[href*="#"]').not('[href="#"]').closest(".menu-item").removeClass("current"), t.closest(".menu-item").addClass("current")
                    }, {
                        offset: "25%"
                    })
                }), $("body").waypoint(function() {
                    var e = "home",
                        t = $('.navigation-bar a[href="#' + e + '"]');
                    $('.navigation-bar a[href*="#"]').not('[href="#"]').closest(".menu-item").removeClass("current"), t.length && t.closest(".menu-item").addClass("current")
                })
            }
        },
        windowLoadHeandler: function(e) {
            var t = this;
            $('.navigation-bar a[href*="#"]').not('a[href="#"]').length && (window.location.hash.length && $('.navigation-bar a[href="' + window.location.hash + '"]').length && $('.navigation-bar a[href="' + window.location.hash + '"]').first().trigger("click"), t.onePageNavInit()), $(".testimonials-slider").length && t.testimonialsSliderInit(), $("#portfolio-wrapper").length && t.prettyPhotoInit(), t.smoothScroll && t.smoothScrollInit(), $(".nav-tabs").length && $(".nav-tabs li:first-child a").trigger("click")
        },
        windowResizeHandler: function(e) {
            var t = this;
            t.mobileMenuStatus(), ($(".window_height").length || $(".full_height").length) && t.fullColumnHeight(), $(".navbar-collapse").not(".collapsed").length && $(".navbar-collapse").not(".collapsed").closest(".navigation-header").find(".navigation-toggle").trigger("click")
        },
        windowScrollHandler: function(e) {
            var t = this;
            t.mobileMenuView && $(".navbar-collapse").not(".collapsed").length && $(".navbar-collapse").not(".collapsed").closest(".navigation-header").find(".navigation-toggle").trigger("click"), $(window).scrollTop() > 500 ? $(".back-to-top").fadeIn() : $(".back-to-top").fadeOut()
        },
        navigationToggleHandler: function(e) {
            var t = this;
            if (t.mobileMenuView) {
                var i = e,
                    n = i.closest(".navigation-header").find(".navbar-collapse");
                if (n.hasClass("collapsing")) return !1;
                n.hasClass("collapsed") ? (n.addClass("collapsing"), n.removeClass("collapsed"), i.closest(".navigation-header").addClass(" collapsed"), $("#main-content").addClass("collapsed")) : ($(".dropdown").removeClass("opened"), $(".dropdown-menu").css("display", ""), n.addClass("collapsing"), n.addClass("collapsed"), i.closest(".navigation-header").removeClass("collapsed"), $("#main-content").removeClass("collapsed")), setTimeout(function() {
                    n.removeClass("collapsing")
                }, 400)
            }
        },
        bodyMouseMoveHandler: function(e) {
            var t = this;
            if (!t.mobileMenuView) {
                var i = $(e.target).parents(".dropdown.opened").find("> .dropdown-menu").get();
                $(e.target).hasClass("dropdown opened") && i.push($(e.target).find("> .dropdown-menu").get(0)), $("body").find(".dropdown.opened > .dropdown-menu").not(i).stop(!0, !0).slideUp(250), $("body").find(".dropdown-menu .dropdown.opened > .dropdown-menu").not(i).stop(!0, !0).delay(100).fadeOut(200), $("body").find(".dropdown.opened > .dropdown-menu").not(i).closest(".dropdown").removeClass("opened")
            }
        },
        dropdownMouseOverHandler: function(e) {
            var t = this;
            t.mobileMenuView || (e.addClass("opened"), e.closest(".dropdown-menu").length ? e.find(".dropdown-menu").first().stop(!0, !0).delay(100).fadeIn(250) : e.find(".dropdown-menu").first().stop(!0, !0).delay(100).slideDown(250))
        },
        dropdownClickHandler: function(e) {
            var t = this;
            if (t.mobileMenuView) {
                var i = e.closest(".dropdown");
                i.is(".opened") ? (i.removeClass("opened"), i.find(".dropdown-menu").first().stop(!0, !0).slideUp(300)) : (i.addClass("opened").siblings(".dropdown").removeClass("opened"), i.find(".dropdown-menu").first().stop(!0, !0).slideDown(300), i.siblings(".dropdown").find(".dropdown-menu").stop(!0, !0).slideUp(300))
            }
        },
        backToTopHandler: function() {
            $("html, body").animate({
                scrollTop: 0,
                easing: "swing"
            }, 750)
        },
        anchorClickHandler: function(e) {
            var t = $(e).offset().top - $(".navigation-header").height(),
                i = $(".navigation-bar"),
                n = i.find('a[href="' + e + '"]');
            $("body, html").animate({
                scrollTop: t
            }, 750, function() {
                history.pushState ? history.pushState(null, null, e) : window.location.hash = e, $('.navigation-bar a[href*="#"]').not('[href="#"]').closest(".menu-item").removeClass("current"), n.closest(".menu-item").addClass("current")
            })
        },
        waveShowAnimation: function(e, t) {
            var i = Math.sqrt(t.outerWidth() * t.outerWidth() + t.outerHeight() * t.outerHeight()),
                n = Math.floor(i / Math.sqrt(20)),
                o = t.attr("data-color");
            t.prepend('<div class="inside-wave base_clr_bg" style="top:' + e.offsetY + "px; left:" + e.offsetX + 'px;"></div>'), setTimeout(function() {
                "" !== o && t.find(".inside-wave").css("background", o), t.find(".inside-wave").css({
                    opacity: "1",
                    "-webkit-transform": "scale(" + n + ")",
                    "-moz-transform": "scale(" + n + ")",
                    "-ms-transform": "scale(" + n + ")",
                    "-o-transform": "scale(" + n + ")",
                    transform: "scale(" + n + ")"
                })
            }, 10)
        },
        waveHideAnimation: function(e, t) {
            var i = t.find(".inside-wave");
            i.css("opacity", 0), setTimeout(function() {
                i.remove()
            }, 400)
        },
        setEventHandlers: function() {
            var e = this;
            $(window).on("load", function(t) {
                e.windowLoadHeandler(t)
            }), $(window).on("resize", function(t) {
                e.windowResizeHandler(t)
            }), $(window).on("scroll", function(t) {
                e.windowScrollHandler(t)
            }), $(".navigation-toggle").on("click", function() {
                e.navigationToggleHandler($(this))
            }), $(".navbar-collapse").bind("mousewheel DOMMouseScroll", function(t) {
                if (e.mobileMenuView) {
                    var i = t.originalEvent,
                        n = i.wheelDelta || -i.detail;
                    this.scrollTop += 30 * (0 > n ? 1 : -1), t.preventDefault()
                }
            }), $("body").on("mousemove", function(t) {
                e.bodyMouseMoveHandler(t)
            }), $(".dropdown").on("mouseover", function() {
                e.dropdownMouseOverHandler($(this))
            }), $(".dropdown > a").on("click", function(t) {
                t.preventDefault(), e.dropdownClickHandler($(this))
            }), $(".back-to-top").on("click", function(t) {
                t.preventDefault(), t.stopPropagation(), e.backToTopHandler()
            }), $("body").on("click", 'a[href*="#"]', function(t) {
                var i = $(this).attr("href"),
                    n = i.substring(i.indexOf("#"), i.length);
                if ("tab" != $(this).attr("data-toggle") && "undefined" == typeof $(this).attr("data-vc-accordion") && "undefined" == typeof $(this).attr("data-vc-tabs")) return $(n).length ? (e.anchorClickHandler(n), !1) : void 0
            }), $("body").on("mouseover", ".wave-mouseover", function(t) {
                e.waveShowAnimation(t, $(this))
            }), $("body").on("mouseout", ".wave-mouseover", function(t) {
                e.waveHideAnimation(t, $(this))
            }), $("body").on("mousedown", ".wave-click", function(t) {
                e.waveShowAnimation(t, $(this))
            }), $("body").on("mouseup mouseover", ".wave-click", function(t) {
                e.waveHideAnimation(t, $(this))
            }), e.eddFix()
        },
        login_ShowHide: function() {
            $(window).on("load", function() {
                $(".forgot-link a").click(function() {
                    return $("#login-form").toggleClass("show hide"), $("#forgot-form").toggleClass("show hide"), !1
                })
            })
        },
        showScreen: function() {
            var e = this;
            $(window).on("load", function() {
                $(".vsc_progress_bar").length && e.progressBar()
            })
        },
        hidePreloader: function() {
            var e = this;
            $("#mask").delay(500).fadeOut(600), e.showScreen()
        },
        eddFix: function() {
            $(".edd-downloads-container").length && ($("body").off(".eddAddToCart", ".edd-add-to-cart"), $("body").on("click.eddAddToCart", ".edd-add-to-cart", function(e) {
                e.preventDefault();
                var t = $(this),
                    i = t.closest("form"),
                    n = t.find(".edd-loading"),
                    o = t.find(".edd-add-to-cart-label"),
                    a = t.closest("div");
                n.width(), n.height(), t.attr("data-edd-loading", ""), n.show(), o.hide();
                var i = t.parents("form").last(),
                    d = t.data("download-id"),
                    s = t.data("variable-price"),
                    r = t.data("price-mode"),
                    l = [],
                    c = !0;
                if ("yes" == s)
                    if (i.find(".edd_price_option_" + d).is("input:hidden")) l[0] = $(".edd_price_option_" + d, i).val();
                    else {
                        if (!i.find(".edd_price_option_" + d + ":checked", i).length) return t.removeAttr("data-edd-loading"), void alert(edd_scripts.select_option);
                        i.find(".edd_price_option_" + d + ":checked", i).each(function(e) {
                            if (l[e] = $(this).val(), !0 === c) {
                                var t = $(this).data("price");
                                t && t > 0 && (c = !1)
                            }
                        })
                    }
                else l[0] = d, t.data("price") && t.data("price") > 0 && (c = !1);
                if (c && i.find(".edd_action_input").val("add_to_cart"), "straight_to_gateway" == i.find(".edd_action_input").val()) return i.submit(), !0;
                var u = t.data("action"),
                    h = {
                        action: u,
                        download_id: d,
                        price_ids: l,
                        post_data: $(i).serialize()
                    };
                return $.ajax({
                    type: "POST",
                    data: h,
                    dataType: "json",
                    url: edd_scripts.ajaxurl,
                    xhrFields: {
                        withCredentials: !0
                    },
                    success: function(e) {
                        if ("1" == edd_scripts.redirect_to_checkout) window.location = edd_scripts.checkout_page;
                        else {
                            if ($(".cart_item.empty").length ? ($(e.cart_item).insertBefore(".cart_item.edd_subtotal"), $(".cart_item.edd_checkout,.cart_item.edd_subtotal").show(), $(".cart_item.empty").remove()) : $(e.cart_item).insertBefore(".cart_item.edd_subtotal"), $(".cart_item.edd_subtotal span").html(e.subtotal), $(".edd-cart-item-title", e.cart_item).length, $("span.edd-cart-quantity").each(function() {
                                    $(this).text(e.cart_quantity), $("body").trigger("edd_quantity_updated", [e.cart_quantity])
                                }), "none" == $(".edd-cart-number-of-items").css("display") && $(".edd-cart-number-of-items").show("slow"), ("no" == s || "multi" != r) && ($("a.edd-add-to-cart", a).toggle(), $(".edd_go_to_checkout", a).css("display", "inline-block")), "multi" == r && t.removeAttr("data-edd-loading"), $(".edd_download_purchase_form").length && ("no" == s || !i.find(".edd_price_option_" + d).is("input:hidden"))) {
                                var n = $('.edd_download_purchase_form *[data-download-id="' + d + '"]').parents("form");
                                $("a.edd-add-to-cart", n).hide(), "multi" != r && n.find(".edd_download_quantity_wrapper").slideUp(), $(".edd_go_to_checkout", n).show().removeAttr("data-edd-loading")
                            }
                            "incart" != e && ($(".edd-cart-added-alert", a).fadeIn(), setTimeout(function() {
                                $(".edd-cart-added-alert", a).fadeOut()
                            }, 3e3)), $("body").trigger("edd_cart_item_added", [e])
                        }
                    }
                }).fail(function(e) {
                    window.console && window.console.log && console.log(e)
                }).done(function() {}), !1
            }))
        },
        pageHeight: function() {
            var e = 0,
                t = 0;
            $("header").length && (e = $("header").first().outerHeight()), $("footer").length && (t = $("footer").first().outerHeight()), $("#main-content").css("min-height", window.innerHeight - e - t)
        },
        initAnimations: function() {
            var e = this;
            this.mobileDevice || !this.options.animations ? $(".animated").css("opacity", 1) : "function" == typeof $.fn.appear ? $(".animated").appear(function() {
                var t = $(this),
                    i = t.data("animation"),
                    n = t.data("delay") || 0,
                    o = t.data("duration") || 1e3;
                e.options.animations ? (t.css({
                    "-webkit-animation-delay": n + "ms",
                    "animation-delay": n + "ms",
                    "-webkit-animation-duration": o / 1e3 + "s",
                    "animation-duration": o / 1e3 + "s"
                }), t.addClass(i)) : t.removeClass("animated")
            }, {
                accY: -150
            }) : $(".animated").css("opacity", 1)
        },
        init: function() {
            var e = this;
            e.pageHeight(), e.checkMobile(), e.getThemeOptions(), e.setPageOptions(), e.mobileMenuStatus(), $('div[class*="ytp-player"]').length && !e.mobileMenuView && $('div[class*="ytp-player"]').css("background-image", ""), ("home" == e.stickyMenu && e.homePage || "all_pages" == e.stickyMenu) && e.stickyMenuInit(), ($(".window_height").length || $(".full_height").length) && e.fullColumnHeight(), e.initVideoBackground(), e.initEddCheckout(), e.initEddProductPage(), e.setEventHandlers(), e.hidePreloader(), e.login_ShowHide()
        }
    },
    function(e) {
        e(document).on("ready", function() {
            Startuply.init()
        })
    }(jQuery);

/*Jascript functions from plugins and files moved into one for faster Load speed*/
//source : https://behealthy.today/wp-content/plugins/woocommerce/assets/js/frontend/woocommerce.min.js?ver=2.6.7
jQuery(function(a){a(".woocommerce-ordering").on("change","select.orderby",function(){a(this).closest("form").submit()}),a("input.qty:not(.product-quantity input.qty)").each(function(){var b=parseFloat(a(this).attr("min"));b>=0&&parseFloat(a(this).val())<b&&a(this).val(b)})});
//source : https://behealthy.today/wp-content/themes/startuply/engine/lib/vivaco-animations/js/vivaco-animations.js?ver=4.5.4
jQuery(document).ready(function($) {
    "use strict";

    var unfoldClassString = ".unfold-3d-to-left, .unfold-3d-to-right, .unfold-3d-to-top, .unfold-3d-to-bottom, .unfold-3d-horizontal, .unfold-3d-vertical";
    var unfoldClasses = unfoldClassString.replace( /[.,]/g, '' );

    $(unfoldClassString).each(function() {
        $(this).find('.unfolder-content').width($(this).width());
    });

    $(window).resize(function() {
        var unfoldClassString = ".unfold-3d-to-left, .unfold-3d-to-right, .unfold-3d-to-top, .unfold-3d-to-bottom, .unfold-3d-horizontal, .unfold-3d-vertical";
        var unfoldClasses = unfoldClassString.replace( /[.,]/g, '' );

        $(unfoldClassString).each(function() {
            $(this).find('.unfolder-content').width($(this).width());
        });
    });
});

//source : https://behealthy.today/wp-content/themes/startuply/js/custom-parallax.js?ver=1.1.3
jQuery(window).load(function(){jQuery('div[class*="parallax-bag"]').each(function(){var a=jQuery(this),i=a.data("token"),r=window["vsc_parallax_"+i];/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)||(jQuery(".parallax-bag-"+r.id).parallax("50%",.4,!1),jQuery(".parallax-bag-"+r.id).css({"background-attachment":"fixed"})),/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)&&jQuery(".parallax-bag-"+r.id).css({"background-attachment":"scroll"})})});


$(document).ready(function(){
    $('.row-inside-dg .vsc-text-icon.icon-left').append('<div class="diagon-bg"></div>');
    $('.dg-one-scoop .btn-add-cart').after('<span class="mbg">*MONEY BACK GUARANTEED</span>');
    var append_quote = $('#feedback > div > div > div > div.vsc_content_slider.wpb_content_element.client-slider.vc_custom_1478867999329');
    append_quote.append('<div class="quote_hold"></div>');
    $('.sub-footer').append('<div class="copyright-block"><div class="container"><div class="cright">Copyright 2017 © Be Healthy Today Inc. - All right reserved</div></div></div>');

    $('.cart-block form .shop_table').after('<div class="v-desc"><a href="/product/daily-green/">View Product Description</div></a>');
    $('.cart-block .cart_totals > h2').replaceWith('<h2>Order Totals</h2>');

    var wtcts = 'wpb_text_column-text-style';
        sswc = 'support-sum support-sec wpb_column column_container';
        clss = 'wpb_text_column wpb_content_element alignleft';
        wwr = 'wpb_wrapper';

    $('.type-product > div.summary.entry-summary').after('<div class="' + sswc + '  "><div class="' + wwr + '"><div class="' + clss + ' text-c-sup"><div class="' + wwr + '"><div class="' + wtcts + '" style=" color: #b4cc1a;"><p>Customer Support</p></div> </div></div><div class="' + clss + ' text-need-ast"><div class="' + wwr + '"><div class="' + wtcts + '" style=" color: #b4cc1a;"><p>Need Assistance?</p></div>    </div></div><div class="wpb_text_column wpb_content_element  contact-block"><div class="' + wwr + '"><div class="' + wtcts + '" style=" color: #676767;"><p>Call us at 888-845-1487</p><p>Email us at hi@behealthy.com</p></div>   </div></div><div class="' + clss + ' sched-block"><div class="' + wwr + '"><div class="' + wtcts + '" style=" color: #676767;"><p>Monday to Saturday</p><p>8:00am – 5:00pm PST</p><p>Sunday</p><p>9:00am – 5:00pm PST</p></div>   </div></div><div class="wpb_text_column wpb_content_element  policy-block"><div class="' + wwr + '"><div class="' + wtcts + '" style=" color: #b4cc1a;"><p><a href="https://behealthy.today/return-policy/">Return Policy</a></p><p><a href="https://behealthy.today/privacy-policy/">Privacy Notice</a></p></div>   </div></div></div></div>');
    $('ajax-load-more').ready(function(){
        $('#ajax-load-more .alm-reveal > div').addClass('col-md-6');
    });
    $('#customer_details > div.col-1 > div > h3').replaceWith('<div class="text-stp"><strong>Step 1:</strong> Customer Information</div>');
    //Change Placeholders
    var plh = 'Placeholder';
    $('#billing_first_name').attr(plh, 'First Name');
    $('#billing_last_name').attr(plh, 'Last Name');
    $('#billing_email').attr(plh, 'Email Address');
    $('#billing_phone').attr(plh, 'Phone');
    $('billing_address_1').attr(plh, 'Address');
    $('#billing_city').attr(plh, 'Town / City');
    $('#billing_postcode').attr(plh, 'Postcode / ZIP');


    $('.woocommerce-checkout-payment').before('<div class="text-stp"><strong>Step 2:</strong> Payment Information</div>');
    $('#customer_details > div.col-1').after('<div class="' + sswc + ' "> <div class="' + wwr + '"> <div class="' + clss + ' text-c-sup"> <div class="' + wwr + '"> <div class="' + wtcts + '" style=" color: #b4cc1a;"> <p>Customer Testimonial</p></div></div></div><div class="' + clss + ' text-c-test"> <div class="' + wwr + '"> <div class="' + wtcts + '" style=" color: #b4cc1a;"><div class="client-img"></div> <div class="tes-message">I have more energy to keep up with my busy life. If I miss a day or two, I notice I have less energy & don’t feel as happy, I also feel like I’m doing something good for my body since it’s so hard to get all the veggies I need. I’m sold on my greens!</div></div></div></div><div class="' + clss + ' text-100"> <div class="' + wwr + '"> <div class="' + wtcts + '" style=" color: #b4cc1a;"> <div class="c-ben 100"><div class="toni"></div><div>100% Money Back Guarantee</div></div><p>You have a ful 30 days to use the Advanced Marketing Program. During that time if you decide it’s not right for you, just let us know and we’ll issue you a full refund. No questions asked!</p></div></div></div><div class="' + clss + ' text-s-check"> <div class="' + wwr + '"> <div class="' + wtcts + '" style=" color: #b4cc1a;"> <div class="c-ben s-c"><div class="toni"></div><div>Secure Checkout</div></div><p>All of your information is secure and encrypted/ We don’t take security lightly and so we always use the latest security protocols.</p></div></div></div><div class="' + clss + ' text-s-check"> <div class="' + wwr + '"> <div class="' + wtcts + '" style=" color: #b4cc1a;"> <div class="c-ben su"><div class="toni"></div><div>Support</div></div><p>Email Us Anytime: <a href="mailto:hi@behealthy.today">hi@behealthy.today</a></p></div></div></div></div></div>');

    $('#main-content > div > .woocommerce').addClass('container');
    /*********setup for subscription option*********/
    var gr_tr = '.product-type-grouped .entry-summary .group_table tr:nth-child';
        subscription = '<div class="prod-subs choice-block"><label><input type="radio" value="0" name="recurring_radio_btn" class="one_time_radio_btn" checked="checked"><span> Subscribe & save 60%</span></label></div>';
        one_time = '<div class="one_time choice-block"><label><input type="radio" value="0" name="recurring_radio_btn" class="one_time_radio_btn" checked="checked"><span> One-time purchase</span></label></div>';
        tr_prod_1 = $(gr_tr + '(1)');
        tr_prod_2 = $(gr_tr + '(2)');
        btn_submit_ac = $('button.single_add_to_cart_button');

        $('.product-type-grouped .group_table tbody > tr:nth-child(1) > td:nth-child(1)').before(subscription);
        $('.product-type-grouped .group_table tbody > tr:nth-child(2) > td:nth-child(1)').before(one_time);

    tr_prod_2.addClass('cart-select');
    var ptg_bn = $('.product-type-grouped .single_add_to_cart_button');
        tun = 'tick-unavailable';
        secnd_inpt = $('.product-type-grouped .group_table tbody > tr:nth-child(2) .quantity > input[type=number]');
    $('.one_time label').click(function(){
        tr_prod_2.addClass('cart-select');
        tr_prod_1.removeClass('cart-select');
        secnd_inpt.val('1');
        $('.product-type-grouped .group_table tbody > tr:nth-child(1) .quantity > input[type=number]').val('0');
        secnd_inpt.removeClass(tun);
    });
    $('.prod-subs label').click(function(){
        tr_prod_1.addClass('cart-select');
        tr_prod_2.removeClass('cart-select');
        $('.product-type-grouped .group_table tbody > tr:nth-child(1) .quantity > input[type=number]').val('1');
        secnd_inpt.val('0');
        secnd_inpt.addClass(tun);
    });
    //dynamic signup url get
    $('.product_type_subscription').attr('id', 'sign_up_now');
    var elementE = document.getElementById("sign_up_now");
    if (typeof(elementE) != 'undefined' && elementE != null)
    {
        var subscribe_link = document.getElementById("sign_up_now").getAttribute("href");
    }
    //append the button with

    $('.prod-subs').click(function(){
        (tr_prod_1).show();
    });
    $('.one_time').click(function(){
        (tr_prod_2).show();
        (btn_submit_ac).show();
    });
    $('.product-type-grouped tr:nth-child(2) .quantity > input[type=number]').val('1');
    /*********end setup for subscription option*********/

    $('.row-inside-dg .ing-col').removeClass('vc_col-sm-5');
    $('.row-inside-dg .ing-col').addClass('vc_col-md-5');
    $('.parent-ac').hover(function(){$('.ac-drop').slideToggle();});
    $('.acount-p-menu').click(function(){
        $('.child-dp').slideToggle();
    });
    $('.aff-reg-sec').attr('id', 'reg-section');
    $('#affwp-register-form > fieldset > p input.button').wrap( "<p class='aff reg-btn'></p>" );
    $('nf-field').attr('class','nf-field');
    
});