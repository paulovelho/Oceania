jQuery(function($) {

  /* --->> Options radio button styling setup --------------*/
  $(".options input").uniform();

    /* --->> Sidebar widgets and menu setup --------------*/ 
    $('.nav-collapse').on('shown', function () {
      $(this).height("auto");
    })

    /* ------- Sidebar ------- */
    $(".side_nav").mCustomScrollbar();

    $(".sub > a").toggle(
      function () {

        var parent = $(this).parent("li");
        $(parent).addClass("active").find("ul:first").slideDown("easeOutQuart",function(){
          sidebarHeightCheck();          
        });

      }, 
      function () {
        var parent = $(this).parent("li");      
        $(parent).removeClass("active").find("ul:first").slideUp("easeInQuart",function(){
          sidebarHeightCheck();          
        });
        
      }
    );

    window.onscroll = scroll;
    function scroll() {
      sidebarHeightCheck(); 

      var navbarHeight = $('.btn-navbar').parents(".navbar").delay(500).height();
      var side_nav = $(".side_nav");
      var sidebar_width = side_nav.css("width");
      var yOffset = window.pageYOffset;
      if(sidebar_width == "145px"){ 
        if(yOffset < navbarHeight+50){
          side_nav.css("z-index","-1");
        }else{
          side_nav.removeAttr("style");
        }          
      }else{      
        side_nav.removeAttr("style");
      }
    }

    /* --->> Sidebar widgets and menu setup --------------*/ 
    $('#nav_list_btn').click(function() {
      $('.nav-list').slideToggle(1000,"easeOutBounce");
    });

    $('#toggle_widget_statistic').click(function() {
      $('.widget_statistic').slideToggle(1000,"easeOutBounce");
    });

    $('#toggle_widget_info').click(function() {
      $('.widget_info').slideToggle(1000,"easeOutBounce");
    });

  /* ------- Widget Toggle ------- */
    $("header .arrow" ).click(function(e){
      e.preventDefault();
      $(this).parents(".widget").find("section").slideToggle("fast",function(){ });   
    });

    var config = {    
     over: showHandler,   
     timeout: 100,
     sensitivity: 3,    
     out: hideHandler 
    };
      
    $(".widget header").hoverIntent( config );  
          
    function showHandler(){ $(this).find(".toggle_content").fadeIn("fast"); }      
    function hideHandler(){ $(this).find(".toggle_content").fadeOut("fast"); }
    
});

/* ------- Sidebar height check ------- */ 
function sidebarHeightCheck(){

  //input.removeAttr("title")
  
  var main_content = $(".main_content > .span9");
  var main_content_height = main_content.height();

  var side_nav = $(".side_nav");
  var side_nav_height = side_nav.height();

  if(main_content_height < side_nav_height){
    $(".side_nav").addClass("affix");
  }

  var window_height = $(window).height();
  var minus_pocent = (window_height*20)/100; 
  var window_height_minus_pocent = window_height - minus_pocent;
  
  if(side_nav_height > window_height_minus_pocent){
    side_nav.addClass("side_nav_fix");
  }else{
    side_nav.removeClass("side_nav_fix");
  }

  $(".side_nav").mCustomScrollbar("update");
}

$(window).load(function() {  
  $("#loader_cont").fadeOut();
});