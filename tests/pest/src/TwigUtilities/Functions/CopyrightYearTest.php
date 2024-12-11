<?php

declare(strict_types=1);

use Reun\TwigUtilities\Functions\CopyrightYear;

test(CopyrightYear::class, function () {
    $function = new CopyrightYear();

    $nowYear = date("Y");

    expect($function($nowYear))->toEqual("{$nowYear}");
    expect($function(2012))->toEqual("2012-{$nowYear}");
    expect($function("2012", "2000"))->toEqual("2012");
    expect($function(2012, 2012))->toEqual("2012");
    expect($function(2012, 2013))->toEqual("2012-2013");
});
