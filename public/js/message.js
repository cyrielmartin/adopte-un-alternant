
var msg = {
  url: '',
  role: '',
  contactList: '',
  data: '',
  p: '',
  response: '',
  reload: null,
  countMessage: 0,

  init: function()
  {
    // je récupère l'url dynamiquement
    msg.url = $('.container').data('url');
    // je récupère le role du user connecté
    msg.role = $('.container').data('role');
    console.log(msg.role);
    // récupération de tout les contact
    msg.contactList = $('.contact-list');
    // listener sur tout les contacts
    for(var i = 0; i < msg.contactList.length; i++ )
    {
      $(msg.contactList[i]).click(msg.recoverData);
    }

    // listener sur le formulaire de réponse
    $('form').on('submit', msg.recoverForm);

    // je récupère le paragraphe type pour mes futurs message
    var container = $('.message');
    msg.p = $(container).find('p:first-child');
  },

  recoverData: function(evt)
  {
    // je stopp l'ancien interval actif
    clearInterval(msg.reload);
    // je reset le nombre de message
    msg.countMessage = 0;
    // je récupère la cible du clic ( le nom du contact )
    var select = evt.target;
    // pour chaque contact dans la liste
    for(var i = 0; i < msg.contactList.length; i++ )
    {
      // je retire les effet couleur 
      var span = $(msg.contactList[i]).find('span');
      $(span).removeClass('bg-primary text-light');
    }
    // j'ajoute un effet couleur au contact séléctionné
    $(select).addClass('bg-primary text-light');

    // je récupère la data 'id' du contact selectionné
    msg.data = $(select).data('id');
    // je lance un nouvel interval pour récupérer les messages toutes les 3 secondes
    msg.reload = setInterval(msg.getMessage, 5000);
    
    msg.getMessage();
  },

  // Méthode qui récupère tout les messages correspondant à l'id d'un contact
  getMessage: function()
  {
    // NB : penser à changer l'url pour le serveur
    var jqxhr = $.ajax({
      method: 'GET',
      url: 'http://' + msg.url + '/message/recover',
      data: { 
        select: msg.data, 
      }
    })
    .done(function(response) {;
      if(response[0] === 'success')
      {
        $('.flash-message').addClass('d-none').html(' ');
        // si le nombre de message reçu est supérieur au nombre 
        // de message déjà affiché ou si il n'y a aucun message
        if (response[1].length > msg.countMessage || response[1].length == 0 )
        {
          // on met à jour l'affichage
          msg.countMessage = response[1].length;
          msg.displayMessage(response[1]);
        }
      }
      else
      {
        $('.flash-message').removeClass('d-none').html(response[1]);
      }
    })
    .fail(function(response) {
      $('.flash-message').removeClass('d-none').html('Une erreur est survenue, veuillez rafraîchir');
      // je stopp l'intervalle pour ne pas relancer de requête
      clearInterval(msg.reload);
    });
  },

  // Méthode qui affiche les messages récupéré par getMessage
  displayMessage(messages)
  {
    // je cible la div qui contiendra les messages
    var container = document.querySelector('.message');
    // je la vide
    $(container).html(' ');
    // pour chaque message reçu
    for(var i = 0; i < messages.length; i++ )
    {
      // je clone la balise p récupéré dans le init
      var pClone = $(msg.p).clone();
      // je rempli le p avec le contenu du message
      $(pClone).prepend(messages[i].content);
    
      // je sépare la cjaine date en 2 (date/heure)
      var date = (messages[i]['sendAt']).split(' ');
      // je cible le span contenu dans le p
      var span = $(pClone).find('span');
      // j'y ajoute la date et l'heure
      $(span).html('le '+ date[0] +' à '+ date[1]);

      // si le message a été envoyé par le candidat (true)
      // ET que le user connecté est candidat
      if(messages[i].candidate)
      {
        // si le user connecté est un candidat
        if(msg.role === 'Candidat' )
        {
          $(pClone).addClass('text-light bg-info ml-auto')
          $(span).addClass('text-dark');
        }
        else
        {
          $(pClone).addClass('bg-light');
          $(span).addClass('text-muted');
        }
      }
      // sinon c'est le recruteur qui a envoyé le message
      else 
      {
        // si le user connecté est un candidat
        if(msg.role === 'Candidat' )
        {
          $(pClone).addClass('bg-light');
          $(span).addClass('text-muted');
        }
        else
        {
          $(pClone).addClass('text-light bg-info ml-auto')
          $(span).addClass('text-dark');
        }
      }
      
      $(container).append(pClone);
    }
    // j'affiche le form
    $('form').removeClass('d-none').addClass('d-md-flex');
    // je dit que la position de ma scrollbar doit être en bas
    container.scrollTop = container.scrollHeight;
  },

  recoverForm: function(evt)
  {
    evt.preventDefault();

    // je récupère le contenu du form
    var form = $(evt.target).find('input');
    msg.response = $(form).val();
    $(form).val(' ');

    msg.sendMessage();
  },

  sendMessage: function()
  {
    // NB : penser à changer l'url pour le serveur
    var jqxhr = $.ajax({
      method: 'POST',
      url: 'http://' + msg.url + '/message/send',
      data: { 
        select: msg.data,
        response: msg.response
      }
    })
    .done(function(response) {
      if(response[0] === 'success')
      {
        $('.flash-message').addClass('d-none').html(' ');
        msg.getMessage();
      }
      else
      {
        $('.flash-message').removeClass('d-none').html(response[1]);
      }
    })
    .fail(function(response) {
      $('.flash-message').removeClass('d-none').html('Une erreur est survenue');
    });
  }
};
$(msg.init)