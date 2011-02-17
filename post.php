<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
include_once 'common.php';
include_once 'config.php';
$secret = SECRET;
$hash = $_GET['hash'];
$pid = $_GET['id'];
$secrethash = md5("{$secret}{$pid}");
if($secrethash==$hash) {
    //alright - correct url
    $post = getPost($pid);
    $message = $post['status'];
}
else{
    $message = "দুঃখিত, এই ইউআরএল টি সঠিক নয়";
}
?>
<html>
    <head>
        <title>Bangla Twitter Status</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="style/grid.css" type="text/css" rel="stylesheet" media="screen"/>
        <script src="js/jquery-1.5.min.js" type="text/javascript"></script>
        <script src="js/driver.phonetic.js" type="text/javascript"></script>
        <script src="js/engine.js" type="text/javascript"></script>
        <style type="text/css" media="screen">

            body { margin: 0px 0 0 0; background-color: #2B3E42; }
            .title{
                color: F7F3E8;
                font-family: SolaimanLipi, Arial;
                font-weight: normal;
                font-size: 32px;
                padding-left:20px;
            }
            .nav{
                background-color: #111;
                height:40px;
            }
            .navshadow{
                background-color: #333;
                margin-bottom: 10px;
                height:3px;
            }
            .bangla{
                margin-left: 20px;
                margin-right: 20px;
                width:900px;;
                height:200px;
                border: 2px solid #222;
                margin-bottom: 10px;
                font-size:18px;
                padding:5px;
                padding-top:10px;
            }
            .right{
                text-align: right;
            }

            .bbutton{
                height:30px;
                font-size: 18px;
                font-weight: normal;
                width: 200px;
                margin-right: 20px;
            }

            .info{
                font-size: 18px;
                color:#EFEFEF;
                padding: 20px;
            }

            .info a{
                text-decoration: underline;
                color:#EFEFEF;

            }

            .info2{
                margin-left:20px;
                font-size:14px;
                color:#EFEFEF;
            }

            .message{
                margin:20px;
                padding:10px;
                background-color: #EFEFEF;
                border:2px solid #222;
                font-size: 14px;
                font-family: SolaimanLipi, Arial;
                color: #444;
}
        </style>
    </head>
    <body>
        <div class="nav">&nbsp</div>
        <div class="navshadow">&nbsp</div>
        <div class="row">
            <div class="column grid_12">
                <h2 class="title">টুইটার স্ট্যাটাস বাংলায়</h2>
            </div>
        </div>
        <div class="row">
            <div class="column grid_12">
                <p class="message">
                    <?php echo nl2br($message);?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="column grid_12">
                <p class="info">এই প্রজেক্টটি <a href='http://www.opensource.org/licenses/bsd-license'>নিউ বিএসডি লাইসেন্সের</a> অধীনে একটি <a href='https://github.com/hasinhayder/BanglaTwitterStatus'>ওপেন সোর্স প্রজেক্ট</a> হিসেবে প্রকাশিত। সোর্সকোডের জন্য পাশের লিংকে ক্লিক করুন <a href='https://github.com/hasinhayder/BanglaTwitterStatus'>https://github.com/hasinhayder/BanglaTwitterStatus</a></p>
            </div>
        </div>

    </body>
</html>