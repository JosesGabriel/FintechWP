__customIndicators = [{
    name: 'Net Value',
    metainfo: {
        "_metainfoVersion": 15,
        "isTVScript": false,
        "isTVScriptStub": false,
        "is_hidden_study": false,
        "defaults": {
            "styles": {
                "compare": {
                    "linestyle": 0,
                    "linewidth": 2,
                    "plottype": 5,
                    "trackPrice": false,
                    "transparency": 35,
                    "visible": true,
                    "color": "#800080",
                    "disableSave": true,
                    "showPrice": true,
                }
            },
            "precision": 0,
            "inputs": { }
        },
        "plots": [{
            "id": "compare",
            "type": "line",
        }],
        "styles": {
            "compare": {
                "title": "Net Value",
                "histogramBase": 0,
            }
        },
        "description": "Net Value",
        "shortDescription": "Net Value",
        "is_price_study": false,
        "inputs": [ ],
        "id": "Net Value@tv-basicstudies-1",
    },

    constructor: function () {

        this.init = function(context, input) {
            this._context = context;
            this._context.new_sym(PineJS.Std.ticker(this._context) + "#VALUE", PineJS.Std.period(this._context), PineJS.Std.period(this._context));
        };

        this.main = function (ctx, input) {
            this._context = ctx;
            var time0 = this._context.new_var(this._context.symbol.time);
            var il_var_0 = PineJS.Std.period(this._context);
            this._context.select_sym(1);
            var time1 = this._context.new_var(this._context.symbol.time);
            var il_var_2 = PineJS.Std.volume(this._context);
            var il_var_3 = this._context.new_var(il_var_2);
            this._context.select_sym(0);
            var il_var_5 = il_var_3.adopt(time1, time0, 0);
            return [il_var_5];
        };

    }

},{
    name: 'Net Foreign',
    metainfo: {
        "_metainfoVersion": 15,
        "isTVScript": false,
        "isTVScriptStub": false,
        "is_hidden_study": false,
        "defaults": {
            "styles": {
                "compare": {
                    "linestyle": 0,
                    "linewidth": 2,
                    "plottype": 5,
                    "trackPrice": false,
                    "transparency": 35,
                    "visible": true,
                    "color": "#800080",
                    "disableSave": true,
                    "showPrice": true,
                }
            },
            "precision": 0,
            "inputs": { }
        },
        "plots": [{
            "id": "compare",
            "type": "line",
        }],
        "styles": {
            "compare": {
                "title": "Net Foreign",
                "histogramBase": 0,
            }
        },
        "description": "Net Foreign",
        "shortDescription": "Net Foreign",
        "is_price_study": false,
        "inputs": [ ],
        "id": "Net Foreign@tv-basicstudies-1",
    },

    constructor: function () {

        this.init = function(context, input) {
            this._context = context;
            this._context.new_sym(PineJS.Std.ticker(this._context) + "#FOREIGN", PineJS.Std.period(this._context), PineJS.Std.period(this._context));
        };

        this.main = function (ctx, input) {
            this._context = ctx;
            var time0 = this._context.new_var(this._context.symbol.time);
            var il_var_0 = PineJS.Std.period(this._context);
            this._context.select_sym(1);
            var time1 = this._context.new_var(this._context.symbol.time);
            var il_var_2 = PineJS.Std.volume(this._context);
            var il_var_3 = this._context.new_var(il_var_2);
            this._context.select_sym(0);
            var il_var_5 = il_var_3.adopt(time1, time0, 0);
            return [il_var_5];
        };

    }

},{
        name: "Price Exhaustion",
        metainfo: {
            _metainfoVersion: 42,
            isTVScript: !1,
            isTVScriptStub: !1,
            defaults: {
                styles: {
                    plot_0: {
                        linestyle: 0,
                        linewidth: 4,
                        plottype: 1,
                        trackPrice: !1,
                        transparency: 35,
                        visible: !0,
                        color: "#000080"
                    },
                    plot_2: {
                        linestyle: 0,
                        linewidth: 2,
                        plottype: 3,
                        trackPrice: !1,
                        transparency: 35,
                        visible: !0,
                        color: "#000080"
                    }
                },
                precision: 4,
                palettes: {
                    palette_0: {
                        colors: {
                            0: {
                                color: "#00FF00",
                                width: 4,
                                style: 0
                            },
                            1: {
                                color: "#008000",
                                width: 4,
                                style: 0
                            },
                            2: {
                                color: "#FF0000",
                                width: 4,
                                style: 0
                            },
                            3: {
                                color: "#800000",
                                width: 4,
                                style: 0
                            }
                        }
                    },
                    palette_1: {
                        colors: {
                            0: {
                                color: "#0000FF",
                                width: 2,
                                style: 0
                            },
                            1: {
                                color: "#000000",
                                width: 2,
                                style: 0
                            },
                            2: {
                                color: "#808080",
                                width: 2,
                                style: 0
                            }
                        }
                    }
                },
                inputs: {
                    in_0: 8,
                    in_1: 2,
                    in_2: 8,
                    in_3: 1,
                    in_4: !0
                }
            },
            plots: [{
                id: "plot_0",
                type: "line"
            }, {
                id: "plot_1",
                palette: "palette_0",
                target: "plot_0",
                type: "colorer"
            }, {
                id: "plot_2",
                type: "line"
            }, {
                id: "plot_3",
                palette: "palette_1",
                target: "plot_2",
                type: "colorer"
            }],
            styles: {
                plot_0: {
                    title: "Plot",
                    histogramBase: 0,
                    joinPoints: !1,
                    isHidden: !1
                },
                plot_2: {
                    title: "Plot",
                    histogramBase: 0,
                    joinPoints: !1,
                    isHidden: !1
                }
            },
            description: "Price Exhaustion",
            shortDescription: "Price Exhaustion",
            is_price_study: !1,
            is_hidden_study: !1,
            id: "Price Exhaustion@tv-basicstudies-1",
            palettes: {
                palette_0: {
                    colors: {
                        0: {
                            name: "Color 0"
                        },
                        1: {
                            name: "Color 1"
                        },
                        2: {
                            name: "Color 2"
                        },
                        3: {
                            name: "Color 3"
                        }
                    },
                    valToIndex: {
                        0: 0,
                        1: 1,
                        2: 2,
                        3: 3
                    }
                },
                palette_1: {
                    colors: {
                        0: {
                            name: "Color 0"
                        },
                        1: {
                            name: "Color 1"
                        },
                        2: {
                            name: "Color 2"
                        }
                    },
                    valToIndex: {
                        4: 0,
                        5: 1,
                        6: 2
                    }
                }
            },
            inputs: [{
                id: "in_0",
                name: "BB Length",
                defval: 8,
                type: "integer",
                min: -1E12,
                max: 1E12
            }, {
                id: "in_1",
                name: "BB MultFactor",
                defval: 2,
                type: "float",
                min: -1E12,
                max: 1E12
            }, {
                id: "in_2",
                name: "KC Length",
                defval: 8,
                type: "integer",
                min: -1E12,
                max: 1E12
            }, {
                id: "in_3",
                name: "KC MultFactor",
                defval: 1,
                type: "float",
                min: -1E12,
                max: 1E12
            }, {
                id: "in_4",
                name: "Use TrueRange (KC)",
                defval: !0,
                type: "bool"
            }],
            scriptIdPart: "",
            name: "Price Exhaustion",
            isCustomIndicator: !0
        },
        constructor: function() {
            this.f_0 = function() {
                var a = this._input(0),
                    c = this._input(2),
                    b = this._input(3),
                    f = this._input(4),
                    g = PineJS.Std.close(this._context),
                    e = this._context.new_var(g),
                    e = PineJS.Std.sma(e, a, this._context),
                    d = this._context.new_var(g),
                    d = b * PineJS.Std.stdev(d, a, this._context),
                    a = e + d,
                    e = e - d,
                    d = this._context.new_var(g),
                    d = PineJS.Std.sma(d, c, this._context),
                    k = PineJS.Std.tr(void 0, this._context),
                    l = PineJS.Std.high(this._context) - PineJS.Std.low(this._context),
                    f = this._context.new_var(f ? k : l),
                    k = PineJS.Std.sma(f, c, this._context),
                    f = d + k * b,
                    d = d - k * b,
                    b = PineJS.Std.and(PineJS.Std.gt(e, d), PineJS.Std.lt(a, f)),
                    a = PineJS.Std.and(PineJS.Std.lt(e, d), PineJS.Std.gt(a, f)),
                    a = PineJS.Std.and(PineJS.Std.eq(b, 0), PineJS.Std.eq(a, 0)),
                    f = this._context.new_var(PineJS.Std.high(this._context)),
                    e = this._context.new_var(PineJS.Std.low(this._context)),
                    d = this._context.new_var(PineJS.Std.close(this._context)),
                    g = this._context.new_var(g - PineJS.Std.avg(PineJS.Std.avg(PineJS.Std.highest(f, c, this._context), PineJS.Std.lowest(e, c, this._context)), PineJS.Std.sma(d, c, this._context))),
                    c = this._context.new_var(PineJS.Std.linreg(g, c, 0)),
                    g = PineJS.Std.iff(PineJS.Std.gt(c.get(0), 0), PineJS.Std.iff(PineJS.Std.gt(c.get(0), PineJS.Std.nz(c.get(1))), 0, 1), PineJS.Std.iff(PineJS.Std.lt(c.get(0), PineJS.Std.nz(c.get(1))), 2, 3)),
                    b = a ? 4 : b ? 5 : 6;
                return [c.get(0), 0, g, b]
            };
            this.main = function(a, c) {
                this._context = a;
                this._input = c;
                var b = this.f_0();
                return [b[0], b[2], b[1], b[3]]
            }
        }
    },{   
        name: "Composite Momentum Index",
        metainfo: {
            _metainfoVersion: 42,
            isTVScript: !1,
            isTVScriptStub: !1,
            defaults: {
                styles: {
                    plot_0: {
                        linestyle: 0,
                        linewidth: 0,
                        plottype: 6,
                        trackPrice: !1,
                        transparency: 35,
                        visible: !0,
                        color: "#808080"
                    },
                    plot_1: {
                        linestyle: 0,
                        linewidth: 1,
                        plottype: 0,
                        trackPrice: !1,
                        transparency: 35,
                        visible: !0,
                        color: "#0000FF"
                    },
                    plot_2: {
                        linestyle: 0,
                        linewidth: 1,
                        plottype: 0,
                        trackPrice: !1,
                        transparency: 35,
                        visible: !0,
                        color: "#FF0000"
                    }
                },
                precision: 4,
                filledAreasStyle: {
                    fill_0: {
                        color: "#000000",
                        transparency: 90,
                        visible: !0
                    },
                    fill_1: {
                        color: "#00FF00",
                        transparency: 50,
                        visible: !0
                    },
                    fill_2: {
                        color: "#FF0000",
                        transparency: 50,
                        visible: !0
                    }
                },
                bands: [{
                    color: "#FF0000",
                    linestyle: 2,
                    linewidth: 1,
                    visible: !0,
                    value: 70
                }, {
                    color: "#008000",
                    linestyle: 2,
                    linewidth: 1,
                    visible: !0,
                    value: 30
                }, {
                    color: "#000000",
                    linestyle: 2,
                    linewidth: 1,
                    visible: !0,
                    value: 0
                }, {
                    color: "#008000",
                    linestyle: 2,
                    linewidth: 1,
                    visible: !0,
                    value: -30
                }, {
                    color: "#FF0000",
                    linestyle: 2,
                    linewidth: 1,
                    visible: !0,
                    value: -70
                }],
                inputs: {
                    in_0: "close",
                    in_1: 3,
                    in_2: 5
                }
            },
            plots: [{
                id: "plot_0",
                type: "line"
            }, {
                id: "plot_1",
                type: "line"
            }, {
                id: "plot_2",
                type: "line"
            }],
            styles: {
                plot_0: {
                    title: "Dummy",
                    histogramBase: 0,
                    joinPoints: !1,
                    isHidden: !1
                },
                plot_1: {
                    title: "DynamicIndex",
                    histogramBase: 0,
                    joinPoints: !1,
                    isHidden: !1
                },
                plot_2: {
                    title: "trigger",
                    histogramBase: 0,
                    joinPoints: !1,
                    isHidden: !1
                }
            },
            description: "Composite Momentum Index",
            shortDescription: "CCMI",
            is_price_study: !1,
            is_hidden_study: !1,
            id: "Composite Momentum Index@tv-basicstudies-1",
            filledAreas: [{
                id: "fill_0",
                objAId: "hline_1",
                objBId: "hline_3",
                type: "hline_hline",
                title: "MidRegionFill",
                isHidden: !1
            }, {
                id: "fill_1",
                objAId: "plot_1",
                objBId: "plot_0",
                type: "plot_plot",
                title: "PositiveFill",
                isHidden: !1
            }, {
                id: "fill_2",
                objAId: "plot_2",
                objBId: "plot_0",
                type: "plot_plot",
                title: "NegativeFill",
                isHidden: !1
            }],
            bands: [{
                id: "hline_0",
                name: "High2",
                isHidden: !1
            }, {
                id: "hline_1",
                name: "High1",
                isHidden: !1
            }, {
                id: "hline_2",
                name: "Mid",
                isHidden: !1
            }, {
                id: "hline_3",
                name: "Low1",
                isHidden: !1
            }, {
                id: "hline_4",
                name: "Low2",
                isHidden: !1
            }],
            inputs: [{
                id: "in_0",
                name: "Source",
                defval: "close",
                type: "source",
                options: "open high low close hl2 hlc3 ohlc4".split(" ")
            }, {
                id: "in_1",
                name: "Composite Smoothing Length",
                defval: 3,
                type: "integer",
                min: -1E12,
                max: 1E12
            }, {
                id: "in_2",
                name: "Signal Length",
                defval: 5,
                type: "integer",
                min: -1E12,
                max: 1E12
            }],
            scriptIdPart: "",
            name: "Composite Momentum Index",
            isCustomIndicator: !0
        },
        constructor: function() {       
            //calc_dema(src, length) =>     
            //f_0 refers to calc_dema passing parameter function
            this.f_0 = function(a, c) {
                var b = this._context.new_var(a),
                    //e1 = ema(src, length)
                    b = PineJS.Std.ema(b, c, this._context),
                    f = this._context.new_var(b),
                    //e2 = ema(e1, length)
                    f = PineJS.Std.ema(f, c, this._context);
                    //2 * e1 - e2
                return [2 * b - f]
            };
            
            
            this.f_1 = function() {
            
                    //src = close
                var a = this._context.new_var(PineJS.Std[this._input(0)](this._context)),
                    //lenSmooth=3
                    c = this._input(1),
                    //trigg=5
                    b = this._input(2),
                    
                    //cmo51=sum( iff( src >  src[1] , ( src -  src[1] ) ,0 ) ,5 ) 
                    f = this._context.new_var(PineJS.Std.iff(PineJS.Std.gt(a.get(0), a.get(1)), a.get(0) - a.get(1), 0)),
                    f = PineJS.Std.sum(f, 5, this._context),
                    
                    //cmo52=sum( iff( src <  src[1] , ( src[1] - src )  ,0 ) ,5 )
                    g = this._context.new_var(PineJS.Std.iff(PineJS.Std.lt(a.get(0), a.get(1)), a.get(1) - a.get(0), 0)),
                    g = PineJS.Std.sum(g, 5, this._context),
                    
                    //cmo5=calc_dema(100 * nz(( cmo51 - cmo52)  /( cmo51+cmo52)),3)
                    f = this.f_0(100 * PineJS.Std.nz((f - g) / (f + g)), 3),
                    
                    //cmo101=sum( iff( src >  src[1] , ( src -  src[1] ) ,0 ) ,10 ) 
                    g = this._context.new_var(PineJS.Std.iff(PineJS.Std.gt(a.get(0), a.get(1)), a.get(0) - a.get(1), 0)),
                    g = PineJS.Std.sum(g, 10, this._context),
                    
                    //cmo102=sum( iff( src <  src[1] , ( src[1] - src )  ,0 ) ,10 )
                    e = this._context.new_var(PineJS.Std.iff(PineJS.Std.lt(a.get(0),a.get(1)), a.get(1) - a.get(0), 0)),
                    e = PineJS.Std.sum(e, 10, this._context),
                    
                    //cmo10=calc_dema(100 * nz(( cmo101 - cmo102)  /( cmo101+cmo102)),3)
                    g = this.f_0(100 * PineJS.Std.nz((g - e) / (g + e)), 3),
                    
                    //cmo201=sum( iff( src >  src[1] , ( src -  src[1] ) ,0 ) ,20 ) 
                    e = this._context.new_var(PineJS.Std.iff(PineJS.Std.gt(a.get(0), a.get(1)), a.get(0) - a.get(1), 0)),
                    e = PineJS.Std.sum(e, 20, this._context),
                    
                    //cmo202=sum( iff( src <  src[1] , ( src[1] - src )  ,0 ) ,20 )
                    d = this._context.new_var(PineJS.Std.iff(PineJS.Std.lt(a.get(0), a.get(1)), a.get(1) - a.get(0), 0)),
                    d = PineJS.Std.sum(d, 20, this._context),
                    
                    //cmo20=calc_dema(100 * nz(( cmo201 - cmo202)  /( cmo201+cmo202)),3)
                    e = this.f_0(100 * PineJS.Std.nz((e - d) / (e + d)), 3),
                    
                    //dmi=((stdev(src,5)* cmo5)+(stdev(src,10)* cmo10)+(stdev(src,20)*cmo20))/(stdev(src,5)+stdev(src,10)+stdev(src,20))
                    a = (PineJS.Std.stdev(a, 5, this._context) * f[0] + PineJS.Std.stdev(a, 10, this._context) *
                        g[0] + PineJS.Std.stdev(a, 20, this._context) * e[0]) / (PineJS.Std.stdev(a, 5, this._context) + PineJS.Std.stdev(a, 10, this._context) + PineJS.Std.stdev(a, 20, this._context)),
                        
                    //e=ema(dmi,lenSmooth)
                    f = this._context.new_var(a),
                    c = PineJS.Std.ema(f, c, this._context),
                    
                    //s=sma(dmi,trigg)
                    a = this._context.new_var(a),
                    b = PineJS.Std.sma(a, b, this._context);
                    
                    //duml=plot(e>s?s:e, style=circles, linewidth=0, color=gray, title="Dummy")
                    //This return on the e>s?s:e
                return [PineJS.Std.gt(c, b) ? b : c, c, b]
            };
            this.main = function(a, c) {
                this._context = a;
                this._input = c;
                var b = this.f_1();
                return [b[0], b[1], b[2]]
            }
        }
    },{

        metainfo: {
            _metainfoVersion: 42,
            name: "support_and_resistance",
            id: "support_and_resistance@tv-basicstudies-1",
            scriptIdPart: "",
            description: "Support and Resistance",
            shortDescription: "S/R",

            is_price_study: true,
            is_hidden_study: false,
            isCustomIndicator: true,
            isTVScript: false,
            isTVScriptStub: false,

            plots: [
                {id: "plot_0", name: "plot_0", type: "line"},
                {id: "plot_1", name: "plot_1", type: "line"},
                {id: "plot_2", name: "plot_2", type: "line"},
                {id: "plot_3", name: "plot_3", type: "line"}
            ],

            precision: 4,
    
            defaults: {
                styles: {
                    plot_0: {
                        linestyle: 0,
                        linewidth: 1,
                        plottype: 2,
                        trackPrice: true,
                        color: "#c80000",
                    },
                    plot_1: {
                        linestyle: 0,
                        linewidth: 1,
                        plottype: 2,
                        trackPrice: true,
                        color: "#c80000",
                    },
                    plot_2: {
                        linestyle: 0,
                        linewidth: 1,
                        plottype: 2,
                        trackPrice: true,
                        color: "#00c800",
                    },
                    plot_3: {
                        linestyle: 0,
                        linewidth: 1,
                        plottype: 2,
                        trackPrice: true,
                        color: "#00c800",
                    },
                },
                inputs: {
                    in_0: 5,
                    in_1: 20
                }
            },

            styles: {
                plot_0: {
                    title: " R1",
                    histogramBase: 0,
                },
                plot_1: {
                    title: " R2",
                    histogramBase: 0,
                },
                plot_2: {
                    title: " S1",
                    histogramBase: 0,
                },
                plot_3: {
                    title: " S2",
                    histogramBase: 0,
                },
            },
            inputs: [{
                id: "in_0",
                name: "No. of bars for Support and Resistance 1",
                type: "integer",
                min: 0,
                max: 200
            }, {
                id: "in_1",
                name: "No. of bars for Support and Resistance 2",
                type: "integer",
                min: 0,
                max: 200
            }]
        },
        constructor: function() {
            
            this.main = function(a, c) {

                this._context = a;
                this._input   = c;

                var h = this._context.new_var(PineJS.Std.high(this._context));
                var l = this._context.new_var(PineJS.Std.low(this._context));
                var r1 = PineJS.Std.highest(h, this._input(0), this._context);
                var r2 = PineJS.Std.highest(h, this._input(1), this._context);
                var s1 = PineJS.Std.lowest(l, this._input(0), this._context);
                var s2 = PineJS.Std.lowest(l, this._input(1), this._context);

                return [{
                    value: r1,
                    offset: -9999
                },{
                    value: r2,
                    offset: -9999
                },{
                    value: s1,
                    offset: -9999
                },{
                    value: s2,
                    offset: -9999
                }
                ];
            };

        }
    }];
