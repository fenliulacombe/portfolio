<?php $this->titre = "Liste des auteurs"; ?>

<form method="POST" action="admin?item=auteur">

    <a href="admin?item=auteur&action=ajouter">ajouter un auteur</a><br><br>

    <label>Trier par :</label> 
    <select name="type">
        <option value="id_auteur"
                <?= (isset($_POST['type']) && $_POST['type'] == 'id_auteur')?'selected':''; ?>>id_auteur</option>
        <option value="auteur"
                <?= (isset($_POST['type']) && $_POST['type'] == 'auteur')?'selected':''; ?>>auteur</option>
        <option value="nb_livres"
                <?= (isset($_POST['type']) && $_POST['type'] == 'nb_livres')?'selected':''; ?>>nb_livres</option>        
     
    </select>

    <label>Ordre :</label> 
    <select name="ordre">
        <option value="asc"
                <?= (isset($_POST['ordre']) && $_POST['ordre'] == 'asc')?'selected':''; ?>>Ascendant</option>
        <option value="desc"
                <?= (isset($_POST['ordre']) && $_POST['ordre'] == 'desc')?'selected':''; ?>>Descendant</option>
    </select>
    <input type="submit" name="Envoyer" value="Exécuter le tri">
</form>

<table>
    <tr>
        <th>id_auteur</th>
        <th>auteur</th>
        <th>nb_livre</th>
        <th>actions</th>
    </tr>
<?php foreach ($auteurs as $auteur): ?>
    <tr>
        <td><?= $auteur['id_auteur'] ?></td>
        <td><?= $auteur['auteur'] ?></td>
        <td><?= $auteur['nb_livres'] ?></td>
        <td><a href="admin?item=auteur&id=<?= $auteur['id_auteur']; ?>&action=modifier">Modifier</a></td>
        <td><a href="admin?item=auteur&id=<?= $auteur['id_auteur']; ?>&action=supprimer">Supprimer</a></td>
    </tr>
<?php endforeach; ?>
</table>