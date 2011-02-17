<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
$dbname = "";
$dbuser = "";
$dbpwd = "";

function getConnection() {
    global $dbname,$dbuser,$dbpwd;
    $pdo =   new PDO("mysql:host=localhost;dbname={$dbname}", $dbuser, $dbpwd);
    $pdo->exec("SET CHARACTER SET utf8");
    $pdo->exec("SET SESSION collation_connection ='utf8_general_ci'");
    return $pdo;
}

function registerUser($name, $token, $secret, $screen_name, $screen_id) {
    try {
        $pdo = getConnection();

        $sql = "SELECT id FROM users WHERE screen_id=:screen_id";
        $ps = $pdo->prepare($sql);
        $ps->bindParam(':screen_id', $screen_id, PDO::PARAM_INT);
        $ps->execute();
        $data = $ps->fetch(PDO::FETCH_ASSOC);
        if($data['id']) return $data['id'];

        //no user with this screen id, so insert it
        $sql = "INSERT INTO users ( name, token, secret, screen_name, screen_id)
            VALUES(:name,:token,:secret,:screen_name,:screen_id);";
        $ps = $pdo->prepare($sql);

        $ps->execute(array(
                ":name"=>$name,
                ":token"=>$token,
                ":secret"=>$secret,
                ":screen_name"=>$screen_name,
                ":screen_id"=>$screen_id
        ));
        return $pdo->lastInsertId();
    }catch(Exception $e) {
        //echo "<pre>";
        //print_r($e);
    }
}

function savePost($user_id, $message) {
    try {
        $time = time();
        $pdo = getConnection();
        $sql = "INSERT INTO posts(user_id, status, short_url,created)
        VALUES(:uid, :status,:short_url,:created)";
        $ps = $pdo->prepare($sql);
        $ps->execute(array(
                ":uid"=>$user_id,
                ":status"=>$message,
                ":short_url"=>"",
                ":created"=>$time
        ));
        //print_r(func_get_args());
        //die();
        return $pdo->lastInsertId();
    }
    catch(Exception $e) {
        //echo "<pre>";
        //print_r($e);
    }
}

function getShortUrl($longUrl) {
    $bitly_username = "banglatwitterstatus";
    $bitly_api_key = "R_5b3666299e17fb85766aa9eab1aac4e8";
    $requestUri = "http://api.bit.ly/v3/shorten?login={$bitly_username}&apiKey={$bitly_api_key}&format=json&longUrl=" . urlencode($longUrl);
    $response = json_decode(file_get_contents($requestUri));
    if ($response->status_code == 200) {
        return $response->data->url;
    } else {
        return FALSE;
    }
}

function getPostUrl($pid) {
    $secret = SECRET;
    $hash = md5("{$secret}{$pid}");
    $longUrl = "http://bangla.twitterstat.us/post.php?id={$pid}&hash={$hash}";
    $shortUrl = getShortUrl($longUrl);
    return $shortUrl;

}

function getPost($pid) {
    $pdo = getConnection();

    $sql = "SELECT * FROM posts WHERE id=:pid";
    $ps = $pdo->prepare($sql);
    $ps->bindParam(':pid', $pid, PDO::PARAM_INT);
    $ps->execute();
    $data = $ps->fetch(PDO::FETCH_ASSOC);
    return $data;
}
?>
