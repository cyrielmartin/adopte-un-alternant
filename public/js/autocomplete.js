
var search = {
    init: function()
    {
        /** 
         * j'utilise la fonction autocomplete de jquery ui sur l'input du nom de l'école
         * Pour chaque entré utilisateur, une requête ajax sera lancé sur le chemin donné 
         * dans le paramètre source.
         * 
         * Un tableau des valeur sera récupéré et affiché sous l'input
         * par la fonction autocomplete
         * 
         * minLength permet de préciser au bout de combien de caractère saisi doit commencer
         * l'autocomplétion
         * */ 
        $('#apprenticeship_formation_school').autocomplete({
            source: '/autocomplete/search/school',
            //minLength : 3
        });

        $('#formation_formation_school').autocomplete({
            source: '/autocomplete/search/school',
            //minLength : 3
        });

        $('#mobility_townName').autocomplete({
            source: '/autocomplete/search/town',
            minLength : 3
        });
        
        $('#recruiter_info_companyLocation').autocomplete({
            source: '/autocomplete/search/town',
            minLength : 3
        });
        
    }
};
$(search.init)