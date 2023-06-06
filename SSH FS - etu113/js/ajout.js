'use strict';

$(document).ready(function(){
    $("#submit_button").on("submit", function(event){
      event.preventDefault();
      var formData = $(this).serialize();
      $.ajax({
        url: "../php/ajout.php",
        type: "POST",
        cache: false,
        data: formData,
        success: function(response){
          data = JSON.parse(response);
          if(data.error == "0") {
            $("#submit_button").trigger("reset");
            console.log(data.message);
          } else if(data.error == "1") {
            console.log(data.message);
          }
        }
      });
    });
});

var addForm = document.getElementById('addForm');
addForm.addEventListener('submit', function(event) {
    event.preventDefault();

    //Récupération  des valeurs du formulaire
    var date_heure = document.getElementById("date_heure").value;
    var latitude = document.getElementById("latitude").value;
    var longitude = document.getElementById("longitude").value;
    var age = document.getElementById("age").value;
    var descr_athmo = document.getElementById("descr_athmos").value;
    var id_code_insee = document.getElementById('ville').value;
    var descr_lum = document.getElementById('descr_lumi').value;
    var descr_dispo_secu = document.getElementById('descr_dispo_secur').value;
    var descr_etat_surf = document.getElementById('descr_etat_surfa').value;
    var descr_cat_veh = document.getElementById('descr_cat_vehi').value;
    var descr_agglo = document.getElementById('descr_agglos').value;
    var descr_type_col = document.getElementById('descr_type_coli').value;

    // // Construire les données à envoyer au serveur
     var data = "date_heure=" + date_heure + "&latitude=" + latitude + "&longitude=" + longitude + "&age=" + 
    age + "&descr_athmo=" + descr_athmo + "&id_code_insee=" + id_code_insee + "&descr_lum=" + descr_lum + 
    "&descr_dispo_secu=" + descr_dispo_secu + "&descr_etat_surf=" + descr_etat_surf + "&descr_cat_veh=" + descr_cat_veh +
    "&descr_agglo=" + descr_agglo + "&descr_type_col=" + descr_type_col;
    // Envoyer la requête AJAX
    ajaxRequest('POST', 'php/ajout.php/form', function(response) {

      console.log(response);
  }, data);
});