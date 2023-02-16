!(function (a, b, c, d) {
    a.fn.jConveyorTicker = function (b) {
        if (void 0 === this || 0 === this.length) return console.log("jquery.jConveyorTicker() INITIALIZATION ERROR: You need to select one or more elements. See documentation form more information."), !1;
        var c = { anim_duration: 150, reverse_elm: !1, force_loop: !1, start_paused: !1 }, 
            d = c.anim_duration,
            e = c.reverse_elm,
            f = c.force_loop,
            g = c.start_paused;
        b && (void 0 !== b.anim_duration && (d = b.anim_duration), void 0 !== b.reverse_elm && (e = b.reverse_elm), void 0 !== b.force_loop && (f = b.force_loop), void 0 !== b.start_paused && (g = b.start_paused), a.extend(c, b));
        var h = a(this),
            i = h.children("ul"),
            j = {
                init: function () {
                    h.each(function () {
                        j.destroy(), i.css({ margin: "0", padding: "0", "list-style": "none" }).children("li").css({ display: "inline-block" });
                        var b = i.width(),
                            c = i.parent().width(),
                            d = c / 1 - 20;
                        i.removeAttr("style").children("li").removeAttr("style"), h.addClass("jctkr-wrapper");
                        var g = function () {
                            var b = i.clone().children("li");
                            b.each(function () {
                                a(this).addClass("clone");
                            }),
                                i.append(b);
                            var c = 0;
                            i.children().each(function () {
                                c += a(this).outerWidth();
                            }),
                                i.width(c),
                                h.hover(
                                    function () {
                                        j.pauseAnim();
                                    },
                                    function () {
                                        j.pauseAnim(), j.conveyorAnimate("normal");
                                    }
                                ),
                                e &&
                                    h
                                        .prev(".jctkr-label")
                                        .hover(
                                            function () {
                                                j.pauseAnim(), j.conveyorAnimate("reverse");
                                            },
                                            function () {
                                                j.pauseAnim(), j.conveyorAnimate("normal");
                                            }
                                        )
                                        .click(function () {
                                            return !1;
                                        }),
                                j.conveyorAnimate("normal");
                        };
                        if (b >= d) g();
                        else if (f) {
                            var k,
                                l = 0,
                                m = function () {
                                    var b = i.clone().children("li");
                                    if (
                                        (b.each(function () {
                                            a(this).addClass("clone");
                                        }),
                                        i.append(b),
                                        (k = i.width()),
                                        (l = i.parent().width()),
                                        !(k < l))
                                    )
                                        return g(), !1;
                                    m();
                                };
                            for (m(); k < l; ) {
                                if (k >= d) {
                                    g();
                                    break;
                                }
                                m();
                            }
                        }
                        h.addClass("jctkr-initialized");
                    }),
                        g && j.pauseAnim();
                },
                destroy: function () {
                    h.each(function () {
                        j.pauseAnim(), a(this).unbind().removeData().removeClass("jctkr-wrapper jctkr-initialized"), i.unbind().removeData().removeAttr("style").find(".clone").remove();
                    });
                },
                conveyorAnimate: function (a) {
                    var b,
                        c = i.width(),
                        e = i.position().left,
                        f = "-",
                        g = "normal";
                    if (void 0 !== a && "reverse" === a) {
                        if (((b = c / 2), e > 0)) return i.css("left", "-" + b + "px"), void j.conveyorAnimate("reverse");
                        (f = "+"), (g = "reverse");
                    } else if (((b = (c / 2) * -1), e < b)) {
                        var h = -1 * (b - e);
                        return i.css("left", h + "px"), void j.conveyorAnimate(g);
                    }
                    i.stop().animate({ left: f + "=10px" }, d, "linear", function () {
                        j.conveyorAnimate(g);
                    });
                },
                pauseAnim: function () {
                    i.stop();
                },
                playAnim: function () {
                    j.conveyorAnimate("normal");
                },
            };
        return j.init(), j;
    };
})(jQuery, window, document);
