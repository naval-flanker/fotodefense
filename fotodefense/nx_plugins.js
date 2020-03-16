/*********************TOP MENU PLUGIN*********************/
(function(){
$(function(){
var s_width = 1170;
function AddNXAdaptiveNavication() {
    var nxNavlen = $('#NXadaptiveNavigation').length, 
        nxScreen = window.innerWidth;

    if(nxNavlen == 0 && nxScreen <= s_width) {
        var navTitle = $('.logo').text(),
            nxTel = $('#NXTel').data('tel'),
            nxSearchForm = $('#NXsearchForm'),
            nxSocialLink = $('.to-social-nav'),
            
            nxAdaptiveMenu = '<div id="NXadaptiveMenu"></div>';
            nxNavigation = '<div class="nx-nav-grad nx-flex-row-btw-c" id="NXadaptiveNavigation">' +
                                '<a href="/" class="h-logo nx-flex-row-l-c" title="На главную"></a>' + 
                                '<span class="h-nav nx-flex-row-btw-c"><button class="h-nav-icon h-nav-gamburger h-close" id="nxGamburger" title="Меню" ></button></strong>' +
                           '</div>';

        $('body').prepend(nxAdaptiveMenu + nxNavigation);
    
        if (nxTel) {
             $('#NXadaptiveMenu').append('<a class="tel nx-flex-row-btw-c" id="NXadaptiveTel" href="tel:'+nxTel+'">'+nxTel+'</a>');
        }

        $('.to-nx-nav').each(function() { 
            $(this).clone().appendTo('#NXadaptiveMenu').end();
            $(this).hide();
        });
        
		$('<span class="tab close" data-nxopen="0"></span>' ).insertBefore('#NXadaptiveMenu li ul');

        if(nxSocialLink.length) {
            $('#NXadaptiveMenu').append('<div id="NXadaptiveSocial" class="nx-flex-row-btw-st"></div>');
            $('.to-social-nav').each(function() {
                $('#NXadaptiveSocial').append($(this).html()).addClass($(this).attr('class'));
                $(this).hide();
            });
            $('#NXadaptiveSocial').removeClass('to-social-nav');
        }

        if(nxSearchForm.length) {
            var searchFormHref = nxSearchForm.attr('action');
            nxSearchForm.hide();
            $('#NXadaptiveMenu').prepend('<div id="NXadaptiveSearchForm"><form action="' + searchFormHref+ '"><input type="text" name="q" placeholder="Поиск" value=""><input type="submit" name="s" value="с" title="Найти"></form></div>');
        }
    }
    else if(nxNavlen > 0 &&  nxScreen >= s_width) {
        $('#NXadaptiveNavigation').remove(); 
        $('#NXadaptiveMenu').remove();  
        
        $('html').removeClass('nxOpenedMenu');
        
        $('.to-nx-nav, .to-social-nav, #NXsearchForm').show();
        $('.to-social-nav').show();
        $('#NXsearchForm').show();
    }
}

if(Modernizr.mq('only all')){
    AddNXAdaptiveNavication(); 
    $(window).resize(function() {
        AddNXAdaptiveNavication();
    }); 
}

$('body').on('click', '#nxGamburger', function() {
    target = $('#NXadaptiveMenu');
    if(target.hasClass('a-menu-open')) {
        $('html').removeClass('nxOpenedMenu');
        target.removeClass('a-menu-open');
    }
    else {
        $('html').addClass('nxOpenedMenu');
        target.addClass('a-menu-open');
    }
});

});})(jQuery);

/*********************ADAPTIVE TABLE *********************/
(function(){$(function(){
$('.tbl').each(function(index, elt) {
    $(this).wrap('<div class="tbl-resp"></div>');});
});})(jQuery);

/*********************TOP SCROLLING*********************/
(function(){$(function(){
    $('body').append('<div id="NXScroller" class="b-top"><span class="b-top-but">наверх</span></div>');
    $(window).scroll(function () { 
        var scroller = $('#NXScroller'); 
        if ($(this).scrollTop() > 300) {scroller.fadeIn();} 
        else {scroller.fadeOut();}
    });
    $('body').on('click', '#NXScroller', function() {
        $('body, html').animate({scrollTop: 0}, 400); return false;
    });
});})(jQuery);

/*********************СOPYRIGHT DATA*********************/
(function(){$(function(){
    var dataObj = $('.copy-data');
        stData = dataObj.html(), 
        dt = new Date(); 
        if ((stData) != dt.getFullYear()) {
            dataObj.append('&nbsp;'+dt.getFullYear());
        }
});})(jQuery);

/*************************TAB PLUGIN************************/
function nxTabsInit(targetContainer) {
    if(targetContainer) targetContainer += ' ';
	else targetContainer = '';
	
    $(targetContainer + '.tab_opened').addClass('open').attr({'data-nxopen':1, 'title':'Скрыть'}); 
    $(targetContainer + '.tab').addClass('close').attr({'data-nxopen':0, 'title':'Показать'}).next().css('display', 'none');
}

function nxTabsAction(targetTab) {
    if (targetTab.attr('data-nxopen') == 0 ) {
        targetTab.next().animate({height: 'show'}, 300); 
        targetTab.attr({'data-nxopen':1, 'title':'Скрыть'}).removeClass('close').addClass('open');
    } 
    else {
        targetTab.next().animate({height: 'hide'}, 300); 
        targetTab.attr({'data-nxopen':0, 'title':'Показать'}).removeClass('open').addClass('close');
    }
    return false;
}

(function(){$(function(){
    nxTabsInit(false);
    $('body').on('click', '.tab', function(){nxTabsAction($(this))});
    $('body').on('click', '.tab_opened', function(){nxTabsAction($(this))});
});})(jQuery);

/********************** MODAL ******************************/
function nx_modalizm() {
    var nx_modal = $('#NXModal');  
        if (nx_modal.length ) {
            nx_modal.remove();
        } 
        $('body').append('<div class="nx-modal" id="NXModal"></div>'); 
        $('#NXModal').fadeIn().height($(document).height());
}
function nx_no_modalizm() {$('#NXModal').fadeOut();}

/**********************LIGHTBOX PLUGIN**********************/
var original_size = new Object();
(function(){$(function(){
function Scaling(my_width, my_height) { var my_res=new Object();
if((my_width/my_height)>=1 && my_width>($(window).width())) {my_res.width=$(window).width()-100; my_res.height=($(window).width()-100)*my_height/my_width; my_res.scale=1;}
else {if ((my_width/my_height)<1 && my_height>($(window).height())){my_res.width=my_width/my_height*($(window).height()-100); my_res.height=$(window).height()-100; my_res.scale=1;}
else {my_res.width=my_width; my_res.height=my_height; my_res.scale=0;}}
return my_res;}

$('body').on("click", '.with_big', function(){var screen_width=$(window).width(); var screen_height=$(window).height();
if ($('div.drag').length ) {$('div.drag').remove();}
$("body").append("<div class='drag'></div>"); $(".drag").draggable();
var src=$(this).attr("data-big")+"?"+Math.random()*1000000000;
var alt_text=$(this).attr("alt"); var title_text=$(this).attr("data-title"); var desc_text=$(this).attr("data-desc"); var link_text=$(this).attr("data-link");
var decription = ""; if(title_text) decription  += "<b>"+title_text+"</b>"; if(desc_text) decription += "<p>"+desc_text+"</p>"; if(link_text) decription += "<a href='"+link_text+"'>узнать больше...</a>";
if(decription != '') decription = '<div class="IDESCRIPTION">'+decription+'</div>';
$(".drag").animate({ opacity: "hide" }, 100 , "linear", function(){$(this).html("<img src='"+src+"' alt='"+alt_text+"' class='IBIG' title='Закрыть' /><span class='IRESIZER'>Увеличить</span>"+decription );});
$(".current").attr("data-nxOpen", "0");
$(".drag img").load(function() {$(".drag").css({"width":"auto", "height":"auto"});
$(this).removeAttr("width").removeAttr("height").css({ width: "", height: "" });
var img_width=$(".drag").width(); var img_height=$(".drag").height();
original_size.width=img_width; original_size.heigh=img_height;
var size = Scaling(img_width, img_height);
$(".IBIG").width(size.width); 
if(original_size.width>size.width) {$(".IRESIZER").show();}
var nx_top  = $(window).scrollTop()+screen_height/2-size.height/2+"px";  var nx_left = $(window).scrollLeft()+screen_width/2-size.width/2+"px";
$(".drag").css({"margin-left":"0px", "top":nx_top, "left":nx_left}).fadeIn(); 
$('.IDESCRIPTION').css('max-width', size.width+'px').show();
});
var isrc = $(".IBIG").attr('src'); $(".IBIG").attr('src', ''); $(".IBIG").attr('src', isrc);
});	
$('body').on("click", '.drag img', function(){if ($(this).attr("data-nxDrag")!=1) {$(this).parent(".drag").fadeOut(); $(".current").attr("data-nxOpen", "0");} else {$(this).attr("data-nxDrag", "0");} });
$('body').on('click', '.IRESIZER', function(){$(".IBIG").width(original_size.width);
var screen_width=$(window).width(); var screen_height=$(window).height();
var nx_top  = $(window).scrollTop()+screen_height/2-original_size.height/2+"px";
var nx_left = $(window).scrollLeft()+screen_width/2-original_size.width/2+"px";
$(".drag").css({"margin-left":"0px", "left":nx_left, "top":nx_top});
$(this).hide(); event.stopPropagation();
});
});})(jQuery);

/****************SEO LINK*******************/
(function(){$(function(){
    $('.h-link').replaceWith(function(){
        var src = $(this), 
            cl = src.attr('class');  
            cl = cl.replace('h-link', '');  
        var text = '<a href="' + src.attr('data-link') + '" ', 
            target = src.attr('data-target'); 
            if(target) text += 'target="' + target + '" '; 
            text +=' class="' + cl + '">' + src.text() + '</a>'; 
        return text;
    });
});})(jQuery);

/****************CONSOLE LOG PLUGIN*****************/
(function(){
var method, 
    noop = function () {},
    methods = ['assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
'timeStamp', 'trace', 'warn'],
    length = methods.length; var console = (window.console = window.console || {});
    while (length--) { method = methods[length]; if (!console[method]) {console[method] = noop;}}
}());

/****************USER CODE*******************/
$(document).ready(function(){
jQuery.preventDefaultEvent = function(e, options) {
    options = options || {shift:1, ctrl:1, alt:1, meta:1};
    var href = e.currentTarget.getAttribute('href');
    if(((options.shift && e.shiftKey)
        || (options.alt && e.altKey)
        || (options.ctrl && e.ctrlKey)
        || (options.meta && e.metaKey))
        && href && href.indexOf('#') != 0
        && href.indexOf('javascript:') != 0
    ) return true;
    e.preventDefault();
    return false;}

});