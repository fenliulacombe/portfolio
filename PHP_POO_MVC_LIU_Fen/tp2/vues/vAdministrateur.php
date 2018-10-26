<?php $this->titre = "Liste des administrateurs"; ?>

<form method="POST" action="admin?item=administrateur">

     <a href="admin?item=administrateur&action=ajouter">ajouter un administrateur</a><br><br>

    <label>Trier par :</label> 
    <select name="type">
        <option value="id_administrateur"
                <?= (isset($_POST['type']) && $_POST['type'] == 'id_administrateur')?'selected':''; ?>>id_administrateur</option>
        <option value="identifiant"
                <?= (isset($_POST['type']) && $_POST['type'] == 'identifiant')?'selected':''; ?>>identifiant</option>
        <option value="mdp"
                <?= (isset($_POST['type']) && $_POST['type'] == 'mdp')?'selected':''; ?>>mdp</option>
     
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
        <th>id_administrateur</th>
        <th>identifiant</th>
        <th>mdp</th>
        <th>actions</th>
    </tr>

<?php foreach ($administrateurs as $administrateur): ?>
    <tr>
        <td><?= $administrateur['id_administrateur'] ?></td>
        <td><?= $administrateur['identifiant'] ?></td>
        <td><?= $administrateur['mdp'] ?></td>
        <td><a href="admin?item=administrateur&id=<?= $administrateur['id_administrateur'] ?>&action=modifier">Modifier</a></td>
        <td><a href="admin?item=administrateur&id=<?= $administrateur['id_administrateur'] ?>&action=supprimer">Supprimer</a></td>
    </tr>
<?php endforeach; ?>
</table>