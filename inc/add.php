<?php
    if(!empty($_REQUEST['val'])) {

        $content = $_REQUEST['content'] ?? '';
        $owner = !empty($_SESSION['userid']) ? $_SESSION['userid'] : 0;

        $q = 'insert into cracks (content, owner, datesend) '
                . ' values("'.nl2br($content).'", "'.$owner.'", '.time().')';
        $db->query($q);
        // rediriger vers le nouveau crack
        header('Location:index.php?inc=search&cid='.$db->lastInsertId());
        exit;
    }
?><form method="post">
    <div>
        <h2>Ajouter un crack</h2>
        <p>
            <label for="content">
                Contenu
            </label>
            <textarea name="content"
                      id="content"
                      required="required"></textarea>
            <input type="submit" name="val" value="Ajouter ce crack" />
        </p>
    </div>
</form>
