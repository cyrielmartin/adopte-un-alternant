var footer = {

    footerSelector: $('footer'),

    init: function () {

      footer.footerAlwayInBottom();
      $(window).on('resize', footer.footerAlwayInBottom());
    },
  
    footerAlwayInBottom: function(){
        var docHeight = $(window).height();
        var footerTop = footer.footerSelector.position().top + footer.footerSelector.height();
        if (footerTop < docHeight) 
        {
            footer.footerSelector.css("margin-top", (docHeight - footerTop + 30) + "px");
        }
    }
};
$(footer.init);