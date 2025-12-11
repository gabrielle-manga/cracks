<?php
    if (!empty($_REQUEST['go'])) {

        $login = $_REQUEST['login'] ?? '';
        $pwd   = $_REQUEST['pwd'] ?? '';

       
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = [];
        }

        if (!isset($_SESSION['login_attempts'][$login])) {
            $_SESSION['login_attempts'][$login] = [
                'count'        => 0,
                'locked_until' => 0,
            ];
        }

        $now    = time();
        $record = &$_SESSION['login_attempts'][$login];

       
        if ($record['locked_until'] > $now) {
            echo '<p style="color:red;">Trop de tentatives échouées. Réessayez plus tard.</p>';
        } else {
            if (Auth::getInstance()->tryLog($login, $pwd)) {
                
                $record['count']        = 0;
                $record['locked_until'] = 0;

                header('Location:index.php?sid='.Auth::getInstance()->getSid());
                exit;
            } else {
                $record['count']++;

                if ($record['count'] > 3) {
                    $record['locked_until'] = $now + 3 * 60;
                    echo '<p style="color:red;">Compte temporairement verrouillé après plusieurs tentatives échouées.</p>';
                } else {
                    echo '<p>Erreur d\'identifiants !</p>';
                }
            }
        }
    }
?>
<form method="post">
    <div>
        <h2>Connexion</h2>
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
                Mot de passe
                <input type="password"
                       required="required"
                       name="pwd" />
            </label>
        </p>
        <input type="submit" name="go" value="Se connecter" />
    </div>
</form>
<p>
    Mot de passe oublié ?
    Envoyez un mail à
    <a href="mailto:<?php echo ADMIN_EMAIL; ?>"><?php echo ADMIN_EMAIL; ?></a>
    avec votre login
    pour recevoir un lien
    de reset de mot de passe !
</p>
