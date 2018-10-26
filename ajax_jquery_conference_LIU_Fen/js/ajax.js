
/*
*@brief fonction qui affiche les thèmes et les présentations avec les effets de JQuery (accordion, sortable)
*/ 
var afficherPresentation = function () {
  $.ajax({ 
    type: "POST", /* type d'envoie les données */
    url: "php/recupererPresentations.php", /* la page a laquelle on envoie la demande */
    success: function (data) { /* obtenir les données */
      $("#res").html(miseEnForme(data)); /* afficher les données dans le div "res"*/
      $(".accordion_presentation").accordion();//ajouter l'effet de l'accordion sur les présentations
      $("#accordion").accordion(); // ajouter l'effet de l'accordion sur les thèmes
      //$(".accordion_presentation").sortable(); //en lançant la fonction "sortable()", certains onglets sont corrompus, je préfère laisser en commentaire et trouver la cause après les examens
      $('#formulaire').hide();//en lançant cette fonction, les formulaires seront cachés
      $('#formulaire').children().hide();//ainsi que le contenu
    }
  });
}

$(document).ready(function () { /* PREPARE THE SCRIPT */

  afficherPresentation();//lorsqu'on lance la page, on lance la fonction d'afficher les présentatiaons

  $("#ajouter_formulaire").click(function () { /* en cliquant sur le bouton on envoye les valeurs de formulaire pour soit créer une présentation, soit modifier une présentation, en fonction de la présence de ID  */

    var url = "";
    /*les valeurs récupérer dans la formulaire*/
    var id = $("#id").val();
    var titre = $("#titre_form").val();
    var description = $("#description").val();
    var thematique = $("#thematique").val();
    var date_presentation = $("#date").val();
    var heure_debut = $("#heure_debut").val();
    var heure_fin = $("#heure_fin").val();
    var salle_presentation = $("#salle_presentation").val();
    var presentateur = $("#presentateur").val();
    var institution_presentateur = $("#institution_presentateur").val();

    /*datastring*/
    var datastring = 'envoyer="envoyer"&id=' + id + '&titre=' + titre + '&description=' + description + '&thematique=' + thematique + '&date_presentation=' + date_presentation + '&heure_debut=' + heure_debut + '&heure_fin=' + heure_fin + '&salle=' + salle_presentation + '&presentateur=' + presentateur + '&institution=' + institution_presentateur;

    if (id == "") {
      url = "php/ajouterPresentation.php"; // si l'id est vide, on cherche dans la page d'ajout
    }
    else {
      url = "php/modifierPresentation.php";// si l'on récupère l'id, on cherche dans la page de modification
    }

    /*on envoie à la page correspondante pour créer ou modifier une présentation*/
    $.ajax({ 
      type: "POST", 
      url: url, 
      data: datastring,
      success: function (data) { 
        $("#res").html(data); 

        // on raffraichit la page une fois la page dans url a traité notre demande
        alert("vous avez bien insérer les données.");
        afficherPresentation();
      }
    });
  });


 /*le bouton "annuler" permet d'annuler l'action d'ajout et retourner à la page d'affichage des présentations*/ 
  $("#annuler_formulaire").click(function () {
    // var formulaire = $(this).parent().get(0);
    // var theme = $(formulaire).parent().get(0);
    $(this).parent().parent().children().show(); //on affiche les présentations
    // $(theme).children().show();
    $('#formulaire').hide(); //on cache le formuaire et son contenu
    $('#formulaire').children().hide();
  });

});

// /*fonction qui permet d'ajouter */ 
// function ajoutFonction(theme) {
//   $("#" + theme).children().hide();
//   $("#" + theme).children("h3").show();
//   // $(".presentation").hide();
//   //déplacement du formulaire dans le theme
//   $("#" + theme).append($('#formulaire'));
//   $('#formulaire').show();
//   $('#formulaire').children().show();
//   $('#thematique').val(theme);
// };

/*
@brief la fonction qui permet de cacher les présentations et n'afficher que le formulaire
*/
function ajoutPresentation() {
  $("res").children().hide();
  $("#accordion").hide();
  $('#formulaire').show();
  $('#formulaire').children().show();
};

/*
@brief la fonction qui permet de cacher le formulaire et n'afficher que les présentations
*/
function annuler() {
  $("res").children().show();
  $("#accordion").show();
  $('#formulaire').hide();
  $('#formulaire').children().hide();
};

/*
@brief la fonction qui permet de modifier la présentation
@param id - l'id de la présenation de la BD
*/
function modifierPresentation(id) {
  ajoutPresentation();
  $("#id").val(id);
  var datastring = "id=" + id;
  $.ajax({ 
    type: "POST", 
    url: "php/recupererPresentation.php", 
    data: datastring,
    success: function (data) {
      data = JSON.parse(data);
      /*on stocke les données récupérés dans chaque champs de la formulaire*/
      $("#id").val(data.id);
      $("#titre_form").val(data.title);
      $("#description").val(data.description);
      $("#thematique").val(data.thematique);
      $("#date").val(data.date);
      $("#heure_debut").val(data.heure_debut);
      $("#heure_fin").val(data.heure_fin);
      $("#salle_presentation").val(data.salle);
      $("#presentateur").val(data.presentateur);
      $("#institution_presentateur").val(data.institution);
    }
  });
}

/*
@brief la fonction qui permet de supprimer la présentation
@param id - l'id de la présenation de la BD
*/

function supprimerPresentation(id) {
  var datastring = "id=" + id;

  //Demande de confirmation à faire !!!!
  if (confirm("Vous êtes sur de supprimer cette présenation ?")) {
    $.ajax({ /* THEN THE AJAX CALL */
      type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
      url: "php/supprimerPresentation.php", /* PAGE WHERE WE WILL PASS THE DATA */
      data: datastring,
      success: function () { /* GET THE TO BE RETURNED DATA */
        alert("vous avez bien supprimé la présentation!");
        //$("#res").html(data); /* THE RETURNED DATA WILL BE SHOWN IN THIS DIV */
        afficherPresentation();
      }
    });
  }
}

/*
@brief la fonction qui permet de mettre en forme de la données récupérés de BD
@param databruite - données récupérées en format JSON seront convertis en OBJET
*/
function miseEnForme(databrute) {
  //console.log(databrute);
  var objet = JSON.parse(databrute);
  var res = "";
  var currtheme = "";

  res += '<div id="accordion">';
  // ici on parcoure tous les enregistrements réupérés

  objet.forEach(element => {
    // element = 1 enregistrement de la BDD
    if (element.thematique != currtheme) {
      if (currtheme != "") {
        res += "</div>"; // fermeture div presentations
      }
      res += '<h3><a href="#">&nbsp;&nbsp' + element.thematique + "</a></h3>";
      res += '<div class="presentations accordion_presentation" id="' + element.thematique + '">';
      currtheme = element.thematique;
    }

    // res += '<div id="accordion_presentation">';
    res += '<h4><a href="#">&nbsp;&nbsp;&nbsp' + element.title + '</a></h4>';
    res += '<div>';
    res += '<ul class="presentation list-group" id="' + element.id + '">';//on stocke l'id de chaque présentation comme id de ul
    
    /*on parcourt les données en 2 dimensions*/ 
    for (var key in element) {
      if (!jQuery.isNumeric(key)) {
        if (key != "id" && key != "title") {
          res += '<li class="title list-group-item">';
          res += key + ' : ';
          res += element[key];
          res += "</li>";
        }
      }
    }
    /*on ajoute le bouton de modification*/
    res += '<button  class="btn btn-default" onclick="modifierPresentation(' + element.id + ')">Modifier</button>';
    /*on ajoute le bouton de supprimer*/
    res += '<button class="btn btn-default" onclick="supprimerPresentation(' + element.id + ')">Supprimer</button>';
    res += "</ul>"; // fermeture presentation
    res += '</div>';//fermeture div 
    // res+= '</div>'; // fermeture div accordion_presentation
  }); // fin boucle foreach

  res += '</div>'; // fermeture div presentations

  res += "</div>"; // fermeture div accordion_theme
  return res;
}




