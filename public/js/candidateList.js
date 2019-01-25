var aside = {

    init: function () {
      // cet evenement écoute tout ce qui se passe sur la page
      addEventListener("scroll", aside.scrolled, false);
    },
  
    scrolled: function(){
      var heightHeader = 143;
      var currentScroll = $('html, body').scrollTop();
  
      if(currentScroll >= heightHeader)
      {
        $('aside').removeClass('aside-absolute');
        $('aside').addClass('aside-fixed');
      }
      else
      {
        $('aside').removeClass('aside-fixed');
        $('aside').addClass('aside-absolute');
      }       
    },

  };
  $(aside.init);