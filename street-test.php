<?php

require 'Regex.php';

$regexes = [
    [
        'name' => 'mlsNumber',
        'regex' => Regex::create()
            ->literal('(')
            ->whitespace()->optional()
            ->literal('MLS')->whitespace()->optional()
            ->literal('#')->whitespace()->optional()
            ->capture('mlsNumber')->digit()->atLeastOne()->endCapture()
            ->literal(')')
    ],
    [
        'name' => 'zipCode',
        'regex' => Regex::create()
            ->capture('zipCode')->digit(5)->endCapture()
            ->literal('-')->optional()
            ->digit(4)->optional()
            ->endOfString()
    ],
    [
        'name' => 'state',
        'regex' => Regex::create()
            ->literal(',')
            ->whitespace()->atLeastOne()
            ->capture('state')->letter(2)->endCapture()
            ->whitespace()->endOfString()
    ],
    [
        'name' => 'city',
        'regex' => Regex::create()
            ->literal(',')
            ->whitespace()->atLeastOne()
            ->capture('city')->anything()->lazy()->endCapture()
            ->endOfString()
    ],
    [
        'name' => 'directionAndUnit',
        'regex' => Regex::create()
            ->wordBoundary()
            ->capture('direction')->either('N', 'S', 'E', 'W')->endCapture()
            ->wordBoundary()
            ->whitespace()->anyTimes()
            ->capture('unit')->nonWhitespace()->anyTimes()->endCapture()
            ->endOfString()
    ],
    [
        'name' => 'unit',
        'regex' => Regex::create()
            ->lookBehind('\s')
            ->literal('#')
            ->capture('unit')->word()->endCapture()
            ->wordBoundary()
    ],
    [
        'name' => 'streetUnit',
        'regex' => Regex::create()
            ->whitespace()->anyTimes()
            ->literal('#')
            ->capture('streetUnit')->word()->endCapture()
            ->whitespace()->anyTimes()
    ],
    [
        'name' => 'numberAndStreet',
        'regex' => Regex::create()
            ->capture('number')->digit()->atLeastOne()->optional()->endCapture()
            ->whitespace()->anyTimes()
            ->either('Acres', 'Lot', 'Tract', 'Tr', 'ac', 'TBD', 'd')->anyTimes()
            ->digit()->atLeastOne()->optional()
            ->whitespace()->anyTimes()
            ->capture('street')->anything()->anyTimes()->endCapture()
            ->endOfString()
    ],
];

foreach ($regexes as $regexEntry) {
    echo "Pattern for {$regexEntry['name']}: {$regexEntry['regex']->getRegex()}\n";
}
