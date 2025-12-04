<?php

/**
 * Description of Auth
 *
 * @author 
 */
class Auth {
    use tSingleton;
    const COOKIENAME = 'authbypass';
    
    protected function __construct(){
        session_start();
        if(isset($_COOKIE[self::COOKIENAME])) {
            $this->log($_COOKIE[self::COOKIENAME]);
        }
    }
    
    public function subscribe($login, $pwd) {
        global $db;
        $hash = password_hash($pwd, PASSWORD_DEFAULT);
        $q = 'insert into users values(null, "'.addslashes($login).'", "'.$hash.'", 0)';
        $db->query($q);
    }
    
    public function tryLog($login, $pwd): bool {
        global $db;
        $q = 'select * from users where login="'.$login.'"';
        $stmt = $db->query($q, PDO::FETCH_ASSOC);
        $user = $stmt ? $stmt->fetch() : null;

        if($user && password_verify($pwd, $user['pwd'])) {
            $this->log($user['id']);
            return true;
        }

        return false;
    }

    public function log($id) {
        $_SESSION['userid'] = $id;
    }
    
    public function logoff() {
        $_SESSION['userid'] = null;
    }
    
    public function isLogged() {
        return !empty($_SESSION['userid']);
    }
    
    public function getSid() {
        return session_id();
    }
    
    public function getCodeFromLogin($login) {
        global $db;
        $q = 'select id, pwd from users where login="'.$login.'"';
        return $db->query($q)->fetch(PDO::FETCH_ASSOC);
    }
    
    public function resetPwd($id, $code, $newPwd) {
        global $db;
        $hash = password_hash($newPwd, PASSWORD_DEFAULT);
        $q = 'update users set pwd="'.$hash.'" where id="'.$id.'" and pwd="'.$code.'"';
        $db->query($q);
    }
}
