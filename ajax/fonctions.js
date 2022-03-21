
// recupere le prix de la commande
let listeCommandes = document.getElementById("listeCommandes");


  listeCommandes.addEventListener("click", GetPrix);

    function GetPrix(){
        
        let idCommande = listeCommandes.value;
        fetch("ajax/getPrix.php?idCommande="+ idCommande)
        .then(response => response.json())
        .then(data => {
                let idPrix = document.getElementById("divPrix");
                idPrix.innerHTML = data["prix_commande"] + " €";               
        })
          .catch(function (error) {
                        console.log('La requête à échouée', error);
           });
  }



// recupere le contenu de la commande
  listeCommandes.addEventListener("click", GetContent);

    function GetContent(){
        
        let idCommande = listeCommandes.value;
        fetch("ajax/getCommande.php?idCommande="+ idCommande)
        .then(response => response.json())
        .then(data => {
                let contenuCommande = document.getElementById("divContenu");
                contenuCommande.innerHTML = data["commande"];               
        })
          .catch(function (error) {
                        console.log('La requête à échouée', error);
           });
  }


  listeCommandes.addEventListener("click", GetDate);

    function GetDate(){
        
        let idCommande = listeCommandes.value;
        fetch("ajax/getDate.php?idCommande="+ idCommande)
        .then(response => response.json())
        .then(data => {
                let dateCommande = document.getElementById("divDate");
                dateCommande.innerHTML = data["date_commande"];               
        })
          .catch(function (error) {
                        console.log('La requête à échouée', error);
           });
  }


  listeCommandes.addEventListener("click", GetStatut);

    function GetStatut(){
        
        let idCommande = listeCommandes.value;
        fetch("ajax/getStatut.php?idCommande="+ idCommande)
        .then(response => response.json())
        .then(data => {
                let statutCommande = document.getElementById("divStatut");
                statutCommande.innerHTML = data["statut_commande"];               
        })
          .catch(function (error) {
                        console.log('La requête à échouée', error);
           });
  }