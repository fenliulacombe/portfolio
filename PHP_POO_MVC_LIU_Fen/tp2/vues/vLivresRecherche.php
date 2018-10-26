<?php $this->titre = "Recherche de livres"; ?>

<form method="POST" action="livres?action=recherche">
    <label>Année :</label> 
    <input name="annee" maxlength=4 value="<?= isset($_POST['annee']) ? $_POST['annee'] :""?>">
    <label>Le titre contient :</label> 
    <input name="titreContient" value="<?= isset($_POST['titreContient']) ? $_POST['titreContient'] :""?>">
    <input type="submit" name="Envoyer" value="Lancer la recherche">
</form>

<?php if ($msgErreur != "") : ?>
<p class="erreur"><?= $msgErreur; ?></p>    
<?php endif ?>

<?php if (count($livres) > 0) : ?>
<table>
    <tr>
        <th>Titre</th>
        <th>Auteur</th>
        <th>Année</th>
    </tr>
<?php foreach ($livres as $livre): ?>
    <tr>
        <td><?= $livre['titre'] ?></td>
        <td><?= $livre['auteur'] ?></td>
        <td><?= $livre['annee'] ?></td>
    </tr>
<?php endforeach; ?>
</table>
<?php endif ?>