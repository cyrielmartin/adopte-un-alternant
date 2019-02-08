var toggle =
{
    status: null,
    url: '',

    init: function()
    {
        toggle.url = $('.container').data('url');
        console.log(toggle.url);
        // à chaque clic sur le toggle on appel la fonction catchStatus
        $('.toggle-group').click(toggle.catchStatus);
    },

    catchStatus: function(evt)
    {
        // si le bouton cliqué à la class on
        if ($(evt.target).hasClass('toggle-on'))
        {
            // le status est à 1 (adopté)
            toggle.status = 1;
        }
        // si le bouton à la classe off
        else if ($(evt.target).hasClass('toggle-off'))
        {
            // le status est à 0 (en recherche)
            toggle.status = 0;
        }

        // j'appelle ma fonction changeStatus
        toggle.changeStatus();
    },

    changeStatus: function()
    {
        // NB : penser à changer l'url pour le serveur
        var jqxhr = $.ajax({
            method: 'GET',
            url: 'http://' + toggle.url + '/toggle/status/apprenticeship',
            data: { 
                status: toggle.status, 
            }
        })
        .done(function(response) {
            if(response === 'success')
            {
                // si le status est à 1 
                if(toggle.status === 1)
                {
                    // on cache les mobilités
                    $('.mobility').addClass('d-none');
                }
                else
                {
                    // sinon on les affiches
                    $('.mobility').removeClass('d-none');
                }
            }
        })
        .fail(function(response) {

        });
    }

};
$(toggle.init);