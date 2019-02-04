
var search = {
    init: function()
    {
        /** 
         * j'utilise la fonction autocomplete de jquery ui sur l'input du nom de la ville -companyLocation
         *  une requête ajax sera lancé sur le chemin donné 
         * dans le paramètre source.
         * 
         * Un tableau des valeur sera récupéré et affiché sous l'input
         * par la fonction autocomplete
         * 
         * minLength permet de préciser au bout de combien de caractère saisi doit commencer
         * l'autocomplétion
         * */ 
       

        $('#recruiter_info_companyLocation').autocomplete({
            source: '/autocomplete/search/townName',
            minLength : 3
        });

        
    }
};
$(search.init)