CheckAccessLink
==========

Conditionne la visibilité du lien cible à son accessibilité

Fonctionnement:
Dans   wakka.config.php rajouter une ligne 'alter_management_string' => '_ma_string_a_moi_'
Dans le lien que vous voulez soumettre à accessibilité, ecrire de la façon suivante :  [[PageDeTest accéder sur la page de test_ma_string_a_moi_]]
Le lien "page de test" ne s'affichera que si la page cible est accessible à l'utilisateur en cours.