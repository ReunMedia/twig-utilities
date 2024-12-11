<?php

declare(strict_types=1);

use Reun\TwigUtilities\Functions\FormatDateRange;

describe(FormatDateRange::class, function () {
    $function = new FormatDateRange();

    it("should output a date range according to finnish date conventions", function () use ($function) {
        expect($function("2017-03-01", "2017-03-01"))->toEqual("1.3.");
        expect($function("2017-03-01", "2017-03-04"))->toEqual("1.-4.3.");
        expect($function("2017-03-01", "2017-04-04"))->toEqual("1.3.-4.4.");
        expect($function("2017-12-29", "2018-01-04"))->toEqual("29.12.2017-4.1.2018");
        expect($function("2017-01-01", "2018-01-01"))->toEqual("1.1.2017-1.1.2018");
    });

    it("should always include year with `\$includeYear` argument", function () use ($function) {
        expect($function("2017-03-01", "2017-03-01", true))->toEqual("1.3.2017");
        expect($function("2017-03-01", "2017-03-04", true))->toEqual("1.-4.3.2017");
        expect($function("2017-03-01", "2017-04-04", true))->toEqual("1.3.-4.4.2017");
    });

    test("use custom delimiter between dates", function () use ($function) {
        expect($function("2017-03-01", "2017-04-04", false, " _:_ "))->toEqual("1.3. _:_ 4.4.");
    });

    describe("supported input types", function () use ($function) {
        it("should support a string input", function () use ($function) {
            $date1 = "2020-06-16";
            $date2 = "2020-06-17";
            expect($function($date1, $date2, true))->toEqual("16.-17.6.2020");
        });

        it("should support an integer input", function () use ($function) {
            $date1 = 1592327572;
            $date2 = 1592352000;
            expect($function($date1, $date2, true))->toEqual("16.-17.6.2020");
        });

        it("should support a DateTimeInterface input", function () use ($function) {
            $date1 = new DateTime("2020-06-16");
            $date2 = new DateTime("2020-06-17");
            expect($function($date1, $date2, true))->toEqual("16.-17.6.2020");

            $date1 = new DateTimeImmutable("2020-06-16");
            $date2 = new DateTimeImmutable("2020-06-17");
            expect($function($date1, $date2, true))->toEqual("16.-17.6.2020");
        });
    });
});
