<?php
function handleSignupRequest(array $request)
{
    $username = $request['data']['username']?? null;
    $password = $request['data']['password']?? null;

    if((!$username) || (!$password)){
        die('no username or password');
    }

    try{
        $dsn = sprintf('mysql:dbname=%s;host=%s', DB_NAME, DB_HOST);
        $dbUser = DB_USER;
        $dbPassword = DB_PASS;
        $dbh = new PDO($dsn, $dbUser, $dbPassword);
        $dbh->exec("SET NAMES 'utf8';");
        $sql = 'SELECT * FROM `users` WHERE `username` = :usenrame;';
        $sth  = $dbh->prepare($sql);
        $sth->bindParam(':usenrame', $username, PDO::PARAM_STR);
        $sth->execute();
        $errorCode = $sth->errorCode();
        if($errorCode !== '00000'){
            die($errorCode);
        }
        $user = $sth->fetch(PDO::FETCH_ASSOC);
        if($user === false){
            die('user does not exist');
        }

        $hashedPassword = md5($password);
        if($hashedPassword !== $user['password']){
            die('wrong password');
        }

        unset($user['password']);
        $_SESSION['user'] = $user;
        echo session_id();
    }catch(PDOException $pde){
        die(__FILE__ . '(line: ' .__LINE__ . ') ' .$pde->getMessage());
    }
}

function login(array $request)
{
    switch($request['method']){
        case 'get':
            require VIEW_DIR . DS . 'admin' . DS . 'auth' . DS . 'login.phtml';
            break;
        case 'post':
            $result = handleSignupRequest($request);
            break;
        default:
            throw new Exception('Unknown method');
    }

}




function register(array $request){
    require VIEW_DIR . DS . 'admin' . DS . 'auth' . DS . 'register.phtml';
}


function forgotPassword(array $request){
    die('<pre>' . print_r([__FILE__, __LINE__], true));
}