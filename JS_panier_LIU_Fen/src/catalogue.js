var MonApp = (function(){
    
    var maxProduit = produit.length;//41

    var nbProduitParPage = 12;
    var currentpage = 1;
    var modeAffichage = "vignette";//défaut
    var nbPoduitPanier = 0;
    var nbDePage = Math.ceil(maxProduit / nbProduitParPage);
    
    var listePanier = {};
    
    var App = {

        /*affiche les produits*/ 
        afficher:function(){
            
            nbDePage = Math.ceil(maxProduit / nbProduitParPage);
            var index = (currentpage - 1) * nbProduitParPage;
            var pagination = document.getElementById("pagination")
            
            /*vérification du panier*/
            var shoppingCart = sessionStorage.getItem("shoppingCart");
            if(shoppingCart == null || shoppingCart == ""){
               nbPoduitPanier = 0;
            }else{
                var jsonstr = JSON.parse(shoppingCart);  
                var productlist = jsonstr.productlist;
                nbPoduitPanier = productlist.length;
            }
            
            /*afficher le nombre de produits dans le panier*/ 
            document.getElementById('panier').innerHTML = nbPoduitPanier;

           /*recuperer la nombre de pages à afficher*/ 
            document.getElementById("choix").onchange = function ()
            {
                var myselect = document.getElementById("choix");
                var valeur = myselect.options[myselect.selectedIndex].value;
                App.setNombreParPage(valeur);
            }
            
            /*affichage en mode vignette*/
            document.getElementById("vignette").onclick = function ()
            {
                if(this.checked){
                    App.setModeAffichage("vignette");
                }
            }

            /*affichage en mode liste*/
            document.getElementById("liste").onclick = function ()
            {
                if(this.checked){
                    App.setModeAffichage("liste");
                }
            }
                
            // afficher les produits
            var conteneur = document.getElementById("listeProduit");
            //console.log(conteneur);
            conteneur.innerHTML = "";
            pagination.innerHTML = "";

            for(var i = index; i < (index + nbProduitParPage) && i < maxProduit; i++)
            {
                var element = 
                    '<article class="produit">'+
                        '<header class="nom">'+produit[i].nom+'</header> '+
                        '<section class="image">'+
                            '<img src="'+produit[i].image+'">'+
                        '</section> '+
                        '<section class="description">'+produit[i].description+'</section> '+
                        '<section class="prix"> '+
                            '<span class="prix-valeur">'+produit[i].prix['valeur']+'</span> '+
                            '<span class="prix-unite">'+produit[i].prix['unite']+'</span> '+
                        '</section> '+
                        '<section class="categorie">'+produit[i].categorie+'</section> '+
                    '</article>';

                   
                conteneur.innerHTML += element;  

                /* modifier la class pour faire afficher en différente mode (liste/vignette) */ 
                if (modeAffichage=="vignette"){
                    document.getElementsByTagName("article")[i-index].classList.remove("liste");
                    document.getElementsByTagName("article")[i-index].classList.add("vignette");

                }else if(modeAffichage=="liste"){
                    document.getElementsByTagName("article")[i-index].classList.remove("vignette");
                    document.getElementsByTagName("article")[i-index].classList.add("liste");
                }
            }

            /*ajouter le bouton "ajouter au panier" dans chaque article*/         
            var articles = document.getElementsByTagName("article");
            for(var i = 0; i < articles.length; i++)
            {
                var btn_achat = document.createElement("input");
                btn_achat.setAttribute("type", "button");
                btn_achat.value="ajouter au panier";
                btn_achat.className = "btn_achat";
                btn_achat.id=i+index;
                document.getElementsByTagName("article")[i].appendChild(btn_achat);

                btn_achat.onclick = function(){
                    App.ajouterProduit(produit[this.id]);
                }
            } 
                       
          
            // ajout le bouton "précendante" en type "bouton" 
            if (currentpage > 1)
            {
                var btn = document.createElement("input");
                btn.setAttribute("type", "button");
                btn.value="prev";
                btn.className = "btn_page";

                pagination.appendChild(btn);

                btn.onclick= function(){
                    if (currentpage > 1)
                    {
                        currentpage--;
                        App.ChangerPage(currentpage);
                    }
                };
            }

            // ajout les numéros de pages en type "bouton" 
            for(j=1;j<=nbDePage;j++){
                var page = document.createElement("input");
                page.setAttribute("type", "button");
                page.value= j;
                page.className = "btn_page";
                pagination.appendChild(page);

                page.onclick = function(){
                    if(this.value < 1 || this.value > nbDePage){
                        alert("Erreur: la page que vous voulez consulter n'existe pas!!");
                    }
                    App.ChangerPage(this.value);
                };
            }


            // ajout le bouton "prochaine" en type "bouton" 
            if (currentpage < nbDePage)
            {
                var btn2 = document.createElement("input");
                btn2.setAttribute("type", "button");
                btn2.value="next";
                btn2.className = "btn_page";

                pagination.appendChild(btn2);

                btn2.onclick= function(){
                
                    if (currentpage < nbDePage)
                    {
                        currentpage++;
                        App.ChangerPage(currentpage);
                    }
                };
            }
        },

        /*fonction pour changer les pages*/
        ChangerPage : function(numPage){

            //valider la page
            if(numPage < 1) numPage = 1;
            if(numPage > nbDePage) numPage = nbDePage;

            // if(numPage < 1 || numPage > nbDePage)
            // {
            //    
            // }
            currentpage = numPage;
            this.afficher();
        
        },
        
        /*getter qui fait afficher le nombre de produits*/
        getNombreProduit : function(){
            return nbProduitParPage;
        },
  
       /**L'utilisateur change le nombre de produit par page */
        setNombreParPage : function(nb){

            if (nb <= 0 || nb > maxProduit)
            {
                nb = maxProduit;
            }
            nbProduitParPage = nb;
            currentpage = 1;
            
            this.afficher();
        },

        /*setter de mode d'affichage */
        setModeAffichage : function(mode){
            modeAffichage = mode;
            this.afficher();

        },

        /*methode qui permet d'ajouter les produits*/

        ajouterProduit : function(produit){
            var shoppingCart = sessionStorage.getItem("shoppingCart");
            if(shoppingCart == null || shoppingCart == ""){
                //var item =  JSON.stringify(produit);
                var jsonstr = { "productlist": [ produit ] };
                sessionStorage.setItem("shoppingCart", JSON.stringify(jsonstr));
            
            }
            else{
                var jsonstr = JSON.parse(shoppingCart);  
                var productlist = jsonstr.productlist;
                var result = true;
                for (var i in productlist) {  
                    
                    if (productlist[i].id == produit.id) { 
  
                          result = false;
                    }  
                }  
                
                if(result == true){
                    productlist.push(produit);
                    sessionStorage.setItem("shoppingCart", JSON.stringify(jsonstr));
                } 
            }
            this.afficher();
        }
    };
    return App;

})();
