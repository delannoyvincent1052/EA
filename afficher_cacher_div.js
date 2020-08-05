function afficher_cacher(id)
{
    if(id=="Customers"){
        document.getElementById("Profil").style.visibility=="hidden"
        document.getElementById('bouton_'+"Profil").innerHTML='Cacher le texte';
        document.getElementById("Customers").style.visibility="visible";
        document.getElementById('bouton_'+"Customers").innerHTML='Afficher le texte';

    }
    
    return true;
}