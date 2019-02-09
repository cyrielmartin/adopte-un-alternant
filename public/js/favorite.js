var fav = {
  url: '',
  button: '',
  candidate: '',

  init: function () {
    fav.url = $('.url').data('url');

    $('.favorite').on('click', fav.recoverData);
  },

  recoverData: function(evt)
  {
    // je récupère la cible
    fav.button = evt.target;

    // je récupère la data value
    var data = $(fav.button).data('isfavorite');
    // et l'id du candidat
    fav.candidate = $(fav.button).data('candidate');

    // si la data est à 0 le candidat n'est pas en favoris
    if(data === 0 )
    {
      // on veux donc l'ajouter au favoris
      fav.addFavorite();
    }
    // si la data est à 1 le candidat est en favoris
    else if (data === 1)
    {
      // on veux donc le retirer
      fav.deleteFavorite();
    }
  },

  addFavorite: function()
  {
    // NB : penser à changer l'url pour le serveur
    var jqxhr = $.ajax({
      method: 'GET',
      url: 'http://' + fav.url + '/recruteur/favoris/'+ fav.candidate +'/add'
    })
    .done(function(response) {
      $('.flash-js').addClass('d-none').html('');
      
      if(response[0] === 'success')
      {
        $(fav.button).data('isfavorite', 1);
        $(fav.button).removeClass('btn-warning').addClass('btn-danger text-light');
        $(fav.button).html('Ce candidat ne m\'intéresse plus <i class="fas fa-heart-broken"></i>');
      }
      else
      {
        $('.flash-js').removeClass('d-none').html(response[1]);
      }
    })
    .fail(function(response) {
      $('.flash-js').removeClass('d-none').html('Une erreur est survenue');
    });
  },

  deleteFavorite: function()
  {
    // NB : penser à changer l'url pour le serveur
    var jqxhr = $.ajax({
      method: 'GET',
      url: 'http://' + fav.url + '/recruteur/favoris/'+ fav.candidate +'/delete',
      data: {
        ajax: true,
      }
    })
    .done(function(response) {
      $('.flash-js').addClass('d-none').html('');
      
      if(response[0] === 'success')
      {
        $(fav.button).data('isfavorite', 0);
        $(fav.button).removeClass('btn-danger text-light').addClass('btn-warning');
        $(fav.button).html('Ce candidat m\'intéresse <i class="far fa-heart"></i>');
      }
      else
      {
        $('.flash-js').removeClass('d-none').html(response[1]);
      }
    })
    .fail(function(response) {
      $('.flash-js').removeClass('d-none').html('Une erreur est survenue');
    });
  },

};
  $(fav.init);