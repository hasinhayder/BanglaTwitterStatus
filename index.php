<?php
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');
require_once('common.php');

session_start();
error_reporting(0);
$user_id = $_SESSION['user_id'];
$access_token = $_SESSION['access_token'];
$pid=0;
if('1'==$_POST['status']) {
    $message = $_POST['message'];
    $shrinked = $_POST['shrinked'];
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

    $pid = savePost($user_id, $message);
    if($shrinked) {
        $shortUrl = getPostUrl($pid);
        $message = "{$shrinked}... {$shortUrl}";
        //echo $message;
    }

    $connection->post("statuses/update", array(
            "status"=>$message
    ));
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
                color: #F7F3E8;
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
        <form id="poster" method="POST" action="">
            <div class="row">
                <div class="column grid_12">
                    <textarea id="message" name="message" class="bangla"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="column grid_6">
                    <p class="info2" <?php if ($access_token) echo "style='display:block;'"; else echo "style='display:none;'"; ?>>
                        ডিফল্ট ফোনেটিক লেআউট এনাবল করা আছে। ইংরেজী মোডে সুইচ করতে চাইলে ctrl+y (ফায়ারফক্স/ইন্টারনেট এক্সপ্লোরার) অথবা ctrl+k (সাফারি/অপেরা) প্রেস করুন
                    </p>
                    &nbsp;<a <?php if ($access_token) echo "style='display:none;'";?> href="redirect.php"><img src="images/light.png" border="0" style="margin-left: 20px"/></a>
                </div>
                <div class="column grid_6 right">
                    <input class="bbutton" type="button" value="পোস্ট করো" onclick="postStatus()"/>
                    <input type="hidden" name="status" value="1"/>
                    <input type="hidden" id="shrinked" name="shrinked" value=""/>
                </div>
            </div>

        </form>
        <div class="row">
            <div class="column grid_12">
                <p class="info">এই প্রজেক্টটি <a href='http://www.opensource.org/licenses/bsd-license'>নিউ বিএসডি লাইসেন্সের</a> অধীনে একটি <a href='https://github.com/hasinhayder/BanglaTwitterStatus'>ওপেন সোর্স প্রজেক্ট</a> হিসেবে প্রকাশিত। সোর্সকোডের জন্য পাশের লিংকে ক্লিক করুন <a href='https://github.com/hasinhayder/BanglaTwitterStatus'>https://github.com/hasinhayder/BanglaTwitterStatus</a></p>
            </div>
        </div>
        <script type="text/javascript">
            var cango,pid;
<?php
if ($access_token) echo "cango=1;";
if ($access_token) echo "pid={$pid};";
?>
    function postStatus(){
        if(cango){
            var message = $("#message").val();
            if (message.length>125){
                var splitted = message.substr(0, 95);
                var lastSpace = splitted.lastIndexOf(" ");
                var shrinked = splitted.substr(0, lastSpace);
                $("#shrinked").val(shrinked);
            }
            $("#poster").submit();
        }
        else
            alert("আপনাকে প্রথমে টুইটারে সাইনইন করতে হবে। এজন্য বামপাশে 'Sign in with Twitter' বাটনে ক্লিক করুন");
    }

    $(document).ready(function(){

        $(".bangla").bnKb({
            'switchkey': {"webkit":"k","mozilla":"y","safari":"k","chrome":"k","msie":"y"},
            'driver': phonetic
        });

        if(pid) alert("আপনার স্ট্যাস ঠিকমত পোস্ট করা হয়েছে");
    });

    function enablePhonetic()
    {
        $(".bangla").bnKb(
        {'switchkey': {"webkit":"k","mozilla":"y","safari":"k","chrome":"k","msie":"y"},
            'driver': phonetic});
    }

    function enableProbhat()
    {
        $(".bangla").bnKb(
        {'switchkey': {"webkit":"k","mozilla":"y","safari":"k","chrome":"k","msie":"y"},
            'driver': probhat});
    }


        </script>
    </body>
</html>
