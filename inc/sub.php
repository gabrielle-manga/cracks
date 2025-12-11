<?php
    if (!empty($_REQUEST['valid'])) {
        $login = $_REQUEST['login'] ?? '';
        $pwd   = $_REQUEST['pwd'] ?? '';
        $errors = [];
        
        if (strlen($pwd) < 8) {
            $errors[] = 'Le mdp doit contenir au moins 8 caractères.';
        }
        
        if (!preg_match('/[a-z]/', $pwd)) {
            $errors[] = 'Le mdp doit contenir au moins une lettre minuscule.';
        }
        
        if (!preg_match('/[A-Z]/', $pwd)) {
            $errors[] = 'Le mdp doit contenir au moins une lettre majuscule.';
        }
        
        if (!preg_match('/[0-9]/', $pwd)) {
            $errors[] = 'Le mdp doit contenir au moins un chiffre.';
        }
        
        if (!preg_match('/[^A-Za-z0-9]/', $pwd)) {
            $errors[] = 'Le mdp doit contenir au moins un caractère spécial.';
        }
        
        if (!empty($errors)) {
            foreach ($errors as $err) {
                echo '<p style="color:red;">'.$err.'</p>';
            }
            echo '<p style="color:red;">Inscription refusée: mdp trop faible.</p>';
        } else {
            Auth::getInstance()->subscribe($login, $pwd);
            echo '<p>Inscription réalisée avec succès !</p>'; 
        }
    }
?>
<form method="post">
    <div>
        <h2>Inscription</h2>
        <p>
            <label>
                Login
                <input type="text"
                       required="required"
                       name="login" />
            </label>
        </p>
        <p>
            <label>
                Login
                <input type="password"
                       required="required"
                       name="pwd" />
            </label>
        </p>
        <input type="submit" name="valid" value="Valider l'inscription" />
    </div>
</form>
