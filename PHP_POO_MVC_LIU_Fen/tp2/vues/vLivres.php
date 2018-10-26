<?php $this->titre = "Liste des livres"; ?>

<form method="POST" action="admin?item=livre">

<a href="admin?item=livre&action=ajouter">ajouter un livre</a><br><br>

    <label>Trier par :</label> 
    <select name="type">
        <option value="titre"
                <?= (isset($_POST['type']) && $_POST['type'] == 'titre')?'selected':''; ?>>Titre</option>
        <option value="auteur"
                <?= (isset($_POST['type']) && $_POST['type'] == 'auteur')?'selected':''; ?>>Auteur</option>
        <option value="annee"
                <?= (isset($_POST['type']) && $_POST['type'] == 'annee')?'selected':''; ?>>Année</option>
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
        <th>Titre</th>
        <th>Auteur</th>
        <th>Année</th>
        <th>Actions</th>
    </tr>
<?php foreach ($livres as $livre): ?>
    <tr>
        <td><?= $livre['titre'] ?></td>
        <td><?= $livre['auteur'] ?></td>
        <td><?= $livre['annee'] ?></td>
        <td><a href="admin?item=livre&id=<?= $livre['id_livre'] ?>&action=modifier">Modifier</a></td>
        <td><a href="admin?item=livre&id=<?= $livre['id_livre'] ?>&action=supprimer">Supprimer</a></td>
    </tr>
<?php endforeach; ?>
</table>