<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 10/19/2019
 * Time: 2:54 AM
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(0);
ini_set('memory_limit', '-1');
require __DIR__ . '/vendor/autoload.php';
Unirest\Request::verifyPeer(false);


use InstagramScraper\Instagram;
use InstagramScraper\Model\Story;
Instagram::$root=__DIR__;
//$instagram = Instagram::withCredentials('mahmoodvand_ali', 'newkids', __DIR__.'/cookie');
$instagram = Instagram::withCredentials('decornahid', 'G0nz@le$1242',__DIR__.'/cookie');
$instagram->login();

//$instagram->twoStep();
//$instagram->twoStep('470631');
//$instagram->saveCookie();
//die;
//$instagram->saveTFA();
//die;
//$medias = $instagram->getMedias('38.v3rr8n', 10);
//echo json_encode($medias);
//die;
//$account = $instagram->getAccount('decornahid');
//echo $account->getUsername();
// Get 1000 followers of 'kevin', 100 a time with random delay between requests
$actions = [
    'follow',
    'story',
    'like',
    'comment'
];
$comments = [
    "خیلیم عالی {😄|😉|😋}{😄|😉|😋}",
    "چه دوست داشتنی {😄|😉|😋}{😄|😉|😋}",
    "وای {😄|😉|😋}{😄|😉|😋}",
    "عالیه {😄|😉|😋}{😄|😉|😋}",
    "خیلی خوبه {😄|😉|😋}{😄|😉|😋}",
    "خیلی باحاله {😄|😉|😋}{😄|😉|😋}",
    "چه باحال {😄|😉|😋}{😄|😉|😋}",
    "واو {😄|😉|😋}{😄|😉|😋}",
    "پستای خوبی داری {😄|😉|😋}{😄|😉|😋}",
    "چقدر خوب {😄|😉|😋}{😄|😉|😋}",
    "زیباست {😄|😉|😋}{😄|😉|😋}",
    "چه زیبا {😄|😉|😋}{😄|😉|😋}",
    "خیلیی خوبه {😄|😉|😋}{😄|😉|😋}",
    "مطالب قشنگی داری {😄|😉|😋}{😄|😉|😋}",
    "عالی {😄|😉|😋}{😄|😉|😋}",
    "قشنگه {😄|😉|😋}{😄|😉|😋}",
    "مطالب خیلی خوبی داری {😄|😉|😋}{😄|😉|😋}",
    "چه قشنگه {😄|😉|😋}{😄|😉|😋}",
    "پست های خوبی داری {😄|😉|😋}{😄|😉|😋}"
];
$usernames =
    ["mahanteymouri",
        "wooden_deco",
        "the_special_decoration",
        "rezagolzar",
        "special.desiign",
    ];
$unIndex = rand(0, count($usernames) - 1);

$account = $instagram->getAccount($usernames[$unIndex]);
sleep(1);
$followers = $instagram->getFollowers($account->getId(), 10, 5, true);
var_dump(count($followers));
//
//$media = $instagram->story();

//file_put_contents(time() . ".html", json_encode($media[0]->getJson()[0]['items']));
////echo $followers[0]['username'];
//for ($i = 0; count($media) > $i; $i++) {
//    echo $media[$i]->g() . PHP_EOL;
//}
//
for ($i = 0; $i < count($followers); $i++) {
    $done = true;
//    echo $followers[$i]['isPrivate']?"true":"false";
//    echo "   https://www.instagram.com/" . $followers[$i]['username'] . "  ===>   ". PHP_EOL;
//    die;
    echo "@$usernames[$unIndex]    ";
    $acIndex = rand(0, count($actions) - 1);
//    $acIndex = 1;
    try {
        if ($actions[$acIndex] == 'story') {
            $media = $instagram->getStories([$followers[$i]['id']]);
//            echo isset($media) . "   " . isset($media[0]) . "   " . isset($media[0]->getJson()[0]) . "   " . isset($media[0]->getJson()[0]['items']) . "  " . $followers[$i]['id'];
            if (isset($media) && isset($media[0]) && isset($media[0]->getJson()[0]) && isset($media[0]->getJson()[0]['items'])) {
                $stories = $media[0]->getJson()[0]['items'];
                for ($i = 0; $i < count($stories); $i++) {
//                    echo $stories[$i]['id'] . "    " . $stories[$i]['taken_at_timestamp'] . PHP_EOL;
                    $instagram->story($followers[$i]['id'], $stories[$i]['id'], $stories[$i]['taken_at_timestamp']);
                    $sleep = rand(rand(1, 3), rand(4, 6));
                    sleep($sleep);
                }
                echo "https://www.instagram.com/" . $followers[$i]['username'] . "  ===>   " . $actions[$acIndex] . PHP_EOL;
            } else {
                $done = false;
                echo "***********No Story************ https://www.instagram.com/" . $followers[$i]['username'] . "  ===>   " . $actions[$acIndex] . PHP_EOL;
//                echo "https://www.instagram.com/" . $followers[$i]['username'] . "  ===>   follow" . PHP_EOL;
//                $instagram->follow($followers[$i]['id']);
            }
        } else if ($actions[$acIndex] == 'follow') {
            echo "https://www.instagram.com/" . $followers[$i]['username'] . "  ===>   " . $actions[$acIndex] . PHP_EOL;
            $instagram->follow($followers[$i]['id']);
        } else {
            $medias = $instagram->getMedias($followers[$i]['username'], 1);
            if (count($medias) > 0) {
                $index = rand(0, count($medias) - 1);
//                var_dump($media[$index]);
                echo $followers[$i]['username'] . "  ===>   " . $medias[$index]['link'] . "  ===>   " . $actions[$acIndex] . PHP_EOL;

                if ($actions[$acIndex] == 'like') {
                    $instagram->like($medias[$index]['id']);
                } else {
                    $comIndex = rand(0, count($comments) - 1);
                    $instagram->addComment($medias[$index]['id'], $comments[$comIndex]);
                }
            } else {
                $done = false;
                echo "***********No Media************ https://www.instagram.com/" . $followers[$i]['username'] . "  ===>   " . $actions[$acIndex] . PHP_EOL;
//                echo "https://www.instagram.com/" . $followers[$i]['username'] . "  ===>   follow" . PHP_EOL;
//                $instagram->follow($followers[$i]['id']);
            }
        }
    } catch (Exception $ex) {
        $filename=time() . ".json";
        file_put_contents(__DIR__."/". $filename, $ex->getMessage());
        file_put_contents('D:\Programing\php\scrape\ap'. $filename, $ex->getMessage());
//        echo __DIR__."/". time() . ".html";
//        sleep(20000);
        echo "***********Error************ " . $followers[$i]['username'] . "  ===>   " . $actions[$acIndex] . "  ===>   " . PHP_EOL;

    }
    if ($done) {
        $sleep = rand(rand(34, 99), rand(100, 200));
        echo " sleep " . $sleep . PHP_EOL;
        sleep($sleep);
    } else {
        $sleep = rand(rand(1, 3), rand(4, 6));
        echo " sleep " . $sleep . PHP_EOL;
        sleep($sleep);
    }

}
