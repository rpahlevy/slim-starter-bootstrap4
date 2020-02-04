<?php

$container = $app->getContainer();

function dump($var, $die=true) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    if ($die) {
        die();
    }
}

// env
function env($key, $defaultValue='') {
    return isset($_ENV[$key]) ? $_ENV[$key] : $defaultValue;
}
$env = new Twig\TwigFunction('env', function ($key, $defaultValue='') {
	return env($key, $defaultValue);
});
$container->get('view')->getEnvironment()->addFunction($env);


// asset
function asset($path) {
    if ($path[0] != '/') {
        $path = "/{$path}";
    }
    return "{$_ENV['APP_URL']}{$path}";
}
$asset = new Twig\TwigFunction('asset', function ($path) {
	return asset($path);
});
$container->get('view')->getEnvironment()->addFunction($asset);


// url
function url($path) {
    if ($path[0] != '/') {
        $path = "/{$path}";
    }
    return "{$_ENV['APP_URL']}{$path}";
}
$url = new Twig\TwigFunction('url', function ($path) {
	return url($path);
});
$container->get('view')->getEnvironment()->addFunction($url);


// session
$session = new Twig\TwigFunction('session', function () {
	return Session::getInstance();
});
$container->get('view')->getEnvironment()->addFunction($session);


// flash
$flash = new Twig\TwigFunction('flash', function ($key) use ($container) {
    return $container->get('flash')->getMessage($key);
});
$container->get('view')->getEnvironment()->addFunction($flash);


// user
$user = new Twig\TwigFunction('user', function () use ($container) {
	return $container->get('user');
});
$container->get('view')->getEnvironment()->addFunction($user);


// number_digit
function number_digit($number, $digit=1) {
    $target = pow(10, intval($digit)-1);
    if ($number > $target) {
        return $number;
    }
    $target_str_len = strlen((string)$target);
    $number_str = "$number";
    while (strlen($number_str) < $target_str_len) {
        $number_str = "0$number_str";
    }
    return $number_str;
}


// tanggal_format
function tanggal_format($time, $usetime=false) {
    switch (date('n', $time)) {
        case 1: $month = 'Januari'; break;
        case 2: $month = 'Februari'; break;
        case 3: $month = 'Maret'; break;
        case 4: $month = 'April'; break;
        case 5: $month = 'Mei'; break;
        case 6: $month = 'Juni'; break;
        case 7: $month = 'Juli'; break;
        case 8: $month = 'Agustus'; break;
        case 9: $month = 'September'; break;
        case 10: $month = 'Oktober'; break;
        case 11: $month = 'November'; break;
        default: $month = 'Desember'; break;
    }
    return date('j', $time) .' '. $month .' '. date('Y', $time) . ($usetime ? ' '. date('H:i', $time) : '');
}
