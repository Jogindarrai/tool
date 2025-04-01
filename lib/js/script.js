$( document ).ready(function(){
    
      
    /*nav btn animation */
    var button = $('.home-nav > .nav-btn  .menu-icon');
    var button2 = $('.home-nav  > .nav-btn');
button.on('click', function (){
  button.toggleClass('open');
  button2.toggleClass('open2');
    
    
});
    
    /*end nav btn animation*/
    
    /*nav bar animation*/
    
    $('.home-nav > .nav-btn  .menu-icon').click(function(){
             
        var menu =  $('.home-nav')
        var main =  $('.main')
         var open = ($(window).width() - (menu.offset().left + menu.outerWidth()));
       // var status = closed
        
     
        
        
        if( open){
           
           
            main.animate({ 'left': '-310px'}, 'linear')
              menu.animate({ 'right':'0px' }, 'linear');
            
        } else if( open = '-310px'){
             
           
            main.animate({ 'left': '0'}, 'linear')
            
            menu.animate({ 'right':'-310px' }, 'linear');
        }
        
        
        
    });
    
 
// $('.brand-menu > li ul').width('0px');
$('.brand-menu > li').on('click', function(){
        
    var clicked=$(this).children('ul').attr('class'),
        noUl=$(this).children('ul').length,
        leftS = $(this).children('ul').offset.left,
        thisCloseBtn = $(this).children('.lavel2close'),
        siblingCloseBtn = $(this).siblings().children('.lavel2close');
    
     
    if(clicked=='clicked' || noUl == 0){
        
       // alert('allready clicked');
        
    }else{
   
    $(this).addClass('active');   
$(this).siblings().removeClass('active');
$(this).children('.lavel2close').offset(leftS);
$(this).children('ul').addClass('clicked').css({width:'0px'}).fadeIn('slow').animate({marginLeft: '-330px',  width:'270px', padding:'20px 20px'});
thisCloseBtn.fadeIn().delay(200).animate({marginLeft: '-330px'});
siblingCloseBtn.animate({marginLeft: '-20px'}).fadeOut();
        
$(this).siblings().children('ul').removeClass('clicked').animate({marginLeft: '-20px',  width:'0px', padding:'20px 0px'}).fadeOut();

    }
});
       $('.lavel2close').on('click',function(){
              
        $(this).parents().removeClass('active');
        $(this).next().animate({marginLeft: '-20px',  width:'0px', padding:'20px 0px'}).fadeOut();
        $(this).animate({marginLeft: '-20px'}).fadeOut();
        $(this).next().toggleClass('clicked');
           
           return false;
        });
 
    
     /*hero slider*/
    
    var imgW = $('.slide img').width(),
        imgh = $('.slide img').height(),
    
        winW = $(window).width() / 2,
        winh = $(window).height()/ 2 ,
        thisImg = $(this).parent().children('.s-img').height();
    
   $('.slide img').prev('.slide-caption').height(imgh);
    
     
    
    
    
    $('.slide img').css({
        
        marginLeft : -imgW / 2,
        marginTop : -imgh / 2 
    })
    
    
//    home slider
    /*$('.caro-slides').carouFredSel({
					responsive: true,
					auto: true,
					 prev: '#prev2',
					 next: '#next2',
				 	pagination: "#pager2", 
					 scroll : {
				            items           : 1,            
                         
                         
				            duration        : 900,                         
				            pauseOnHover    : true,
                            fx : "crossfade"
        					 } ,
					swipe: {
							onMouse: true,
							onTouch: true,
							}
				}); */
    
    /* home search */
    $('.search-frm input.txt').one( 'focusin', function (){

    $('.srch-main').slideDown(500);
    return false;
});
$('.search-frm input.txt').focusout(function(){
    
//    if(  $('.search-pn').is(':hover') === true ){
//     
//         $('.srch-main').slideUp(300);
//    }
     
});
 
(function ($) {

    $.prototype.enterPressed = function (fn) {
        $(this).keyup(function(e) {
            if ((e.keyCode || e.which) == 13) {
                fn();
            }
        });
    };

}(jQuery || {}));

function submitted() {
    
  var frmH =  $('.search-pn').height();
  var pHight = $(window).height();
  var srchH = pHight - frmH;
       
    
    $('.srch-main').fadeOut(300);
    $('.search-frm').animate({
        'backgroundColor' : '#fee9e5'
    });
     $('.srch-bar').animate({
         'marginBottom': '-70px',
        'bottom': '100%',
         
    }, function(){
         
          $('.myphone-page').animate({
        'height': pHight,
    },500);
     });    
}

$(".txt").enterPressed(submitted);


$('.srch-main li').click( function(){
    var txt = $(this).text();
    $(".txt").val(txt).blur();
    submitted();
    makeHdr();    
  
 $('.search-frm input.txt').val(txt).focus();
    return false;
});

function makeHdr() {
    
    $('.txt').animate({'width': '300px'}, 1000).addClass('hdr-txt').bind();
    $('.search-pn').css({'width': '1240px'}, 1000);
    $('.srch-bar').animate({'marginBottom': '-130px'}, 1000);
    $('.search-frm').addClass('ov-bg').animate({'width': '350px', left:'61.5%'}, 570, function(){
    $('header, .main-content, .breadcrumbs').fadeIn('slow');
    $('.srch-main').addClass('srch-main2');
    $('.hero-slider').hide();
        
   
    }); 
    //$('.search-frm img').src('images/phn2.png')
    
    
}
    $('.hdr-txt').bind(function(){
      
         $('.srch-main2').show();
         $('.before').show();
        
    });
    
    
    /*popup*/
    
    $('body').on('click','.quick-view', function(event){
		event.preventDefault();
		$('.qv-popup').addClass('is-visible');
        console.log('running');
	});
	
	//close popup
	$('.qv-popup').on('click', function(event){
		if( $(event.target).is('.qv-popup-close') || $(event.target).is('.qv-popup') ) {
			event.preventDefault();
			$(this).removeClass('is-visible');
		}
	});
	//close popup when clicking the esc keyboard button
	$(document).keyup(function(event){
    	if(event.which=='27'){
    		$('.qv-popup').removeClass('is-visible');
	    }
    });
         
});