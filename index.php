<?php

require_once __DIR__ . '/vendor/autoload.php';

//.envから読み込み
$dotenv = new \Dotenv\Dotenv(__DIR__);
$dotenv->load();

$time_zone = 'Asia/Tokyo';

//timezoneを日本に
date_default_timezone_set(env('TIME_ZONE', $time_zone));

$name = env('GITHUB_USER_NAME');

$github_api = new \App\GithubAPI(new \GuzzleHttp\Client());

$commits = $github_api->getCommitsByName($name);

$today_date = \Carbon\Carbon::now($time_zone)->toDateString();

$today_data = array_filter($commits, function ($commit) use ($today_date, $time_zone) {
    $utc = new \Carbon\Carbon($commit['created_at']);
    $jst = $utc->copy()->setTimezone($time_zone);
    $commit_date = $jst->toDateString();

    return $commit_date == $today_date;
});

$today_commit_number = count($today_data);

$message = '';
if ($today_commit_number) {
    $message = "今日のコミット数は${today_commit_number}です！";
} else {
    $message = "今日はまだコミットしてないよ！！！サボり？？？";
}

$slack_uri = env('SLACK_WEB_HOOK_URL');

$slack_api = new \App\SlackAPI(new \GuzzleHttp\Client());

$slack_api->sendMessage($slack_uri, $message);
