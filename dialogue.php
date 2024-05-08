<?php
// Partie connexion à la BDD et initialisation
$mysqli = new Mysqli('localhost', 'root', '', 'dialogue');
$contenu = '';
//---------------------------------------------------------------------------------------------
// Partie enregistrement
if($_POST)
{
    $_POST['pseudo'] = addslashes($_POST['pseudo']);
    $_POST['message'] = addslashes($_POST['message']);
    if(!empty($_POST['pseudo']) && !empty($_POST['message']))
    {
        $mysqli->query("INSERT INTO commentaire (pseudo, message, date_enregistrement) VALUES ('$_POST[pseudo]', '$_POST[message]', NOW())") OR DIE ($mysqli->error);
        $contenu .= '<div class="validation">Votre message a bien été enregistré.</div>';
    }
    else
    {
        $contenu .= '<div class="erreur">Afin de déposer un commentaire, veuillez svp remplir tous les champs du formulaire.</div>';
    }
}
//---------------------------------------------------------------------------------------------
// Partie affichage des commentaires
$résultat = $mysqli->query("SELECT pseudo, message, DATE_FORMAT(date_enregistrement, '%d/%m/%Y') AS datefr, DATE_FORMAT(date_enregistrement, '%H:%i:%s') AS heurefr FROM commentaire ORDER BY date_enregistrement DESC");    
$contenu .= '<h2 class="h2">'  . $résultat->num_rows . ' commentaire(s)</h2>';
while($commentaire = $résultat->fetch_assoc())
{
    $contenu .= '<div class="message">';
        $contenu .= '<div class="titre">Par: ' . $commentaire['pseudo'] . ', le ' . $commentaire['datefr'] . ' à ' . $commentaire['heurefr'] . '</div>';
        $contenu .= '<div class="contenu">' . $commentaire['message'] . '</div>';
    $contenu .= '</div>';
}
//---------------------------------------------------------------------------------------------
// Partie formulaire d'envoi de commentaire
?>
 
<!Doctype html>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="commentaire"><?php echo $contenu; ?></div>
        <form method="post" action="" class="form">
            <label for="pseudo">Pseudo</label><br>
            <input type="text" id="pseudo" name="pseudo" maxlength="20" pattern="[a-zA-Z0-9.-_]+" title="caractère autorisés : a-zA-Z0-9.-_"><br>
             
            <label for="message">Message</label><br>
            <textarea id="message" name="message" cols="50" rows="7"></textarea><br>
             
            <input type="submit" value="Envoyer le message">
        </form>
    </body>   
</html>