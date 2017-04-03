/*
 * jLetter - jQuery text rotator plugin
 * http://do-web.com/jletter/overview
 *
 * Copyright 2011, Miriam Zusin
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://do-web.com/jletter/license
 */

(function(a){a.fn.jLetter=function(b){var b=a.extend({pause:3e3,rotateSpeed:2500,fadeSpeed:1e3},b);return this.each(function(){var c=this,d=c;a(c).addClass("jLetter");c.slides=a(c).find(".slide");c.slides.hide();a(c).prepend("<div class='panel'><p></p></div>");c.panel=a(c).find(".panel");c.par=c.panel.find("p");c.current=0;c.slides_num=c.slides.length;c.random=function(a){return Math.floor(a*(Math.random()%1))};c.randomBetween=function(a,b){return a+d.random(b-a+1)};c.next=function(){if(d.current<d.slides_num-1)d.current++;else d.current=0};c.makeEffect=function(){for(var g=d.par.text(),f=jQuery.makeArray(g.split("")),e="",h=1,c=0;c<f.length;c++)if(f[c]==" ")e+='<span class="letter">&nbsp;</span>';else e+='<span class="letter">'+f[c]+"</span>";d.par.html(e);d.par.find("span.letter").each(function(){a(this).css("position","relative");a(this).animate({left:d.randomBetween(-150,150),top:d.randomBetween(-75,75),opacity:0},b.rotateSpeed,function(){if(d.par.find("span.letter:animated").length<=1){d.next();d.run()}});h++})};c.fadePar=function(){var c=a(d).find("div.slide:eq("+d.current+") p");d.par.hide();d.par.html(c.html());d.par.fadeIn(b.fadeSpeed)};c.run=function(){d.fadePar();setTimeout(function(){d.makeEffect()},b.pause)};c.run()})}})(jQuery);