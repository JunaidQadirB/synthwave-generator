<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class NameGenerator
{
    public $nouns = [
        ['word' => 'Time', 'not' => ['Cop']],
        ['word' => 'Cassette'],
        ['word' => 'VHS'],
        ['word' => 'Rental'],
        ['word' => 'Midnight'],
        ['word' => 'Darkness'],
        ['word' => 'Maverick'],
        ['word' => 'Arcade', 'not' => ['High']],
        ['word' => 'Game'],
        ['word' => 'Joystick'],
        ['word' => 'Night'],
        ['word' => 'Knight'],
        ['word' => 'Dream'],
        ['word' => 'Drive'],
        ['word' => 'Cruise'],
        ['word' => 'Stallone'],
        ['word' => 'Arnold'],
        ['word' => 'Hollywood', 'prefix' => true],
        ['word' => 'High'],
        ['word' => 'Club', 'suffix' => true],
        ['word' => 'Storm'],
        ['word' => 'Laser'],
        ['word' => 'Lazer'],
        ['word' => 'Cobra'],
        ['word' => 'Kobra'],
        ['word' => 'Combo'],
        ['word' => 'Ultra'],
        ['word' => 'Streets of', 'prefix' => true, 'separator' => ' '],
        ['word' => 'October', 'plural' => false],
        ['word' => 'July', 'plural' => false],
        ['word' => 'August', 'plural' => false],
        ['word' => 'Summer'],
        ['word' => 'Summer of', 'prefix' => true, 'separator' => ' '],
        ['word' => 'Endless', 'prefix' => true],
        ['word' => 'Boys', 'suffix' => true],
        ['word' => 'Boys of', 'prefix' => true, 'separator' => ' '],
        ['word' => 'Tech'],
        ['word' => 'Neon'],
        ['word' => 'Neo'],
        ['word' => 'Noir'],
        ['word' => 'Uppercut'],
        ['word' => 'Strike'],
        ['word' => 'Fist'],
        ['word' => 'Battle'],
        ['word' => 'scape', 'suffix' => true, 'separator' => ''],
        ['word' => 'tron', 'suffix' => true, 'separator' => ''],
        ['word' => 'Hacker'],
        ['word' => 'Surfer', 'suffix' => true],
        ['word' => 'FM', 'not' => ['83']],
        ['word' => 'Cop'],
        ['word' => 'Hopper'],
        ['word' => 'Eleven'],
        ['word' => 'Strange'],
        ['word' => 'Stranger', 'suffix' => true],
        ['word' => 'Hawkins'],
        ['word' => 'Hawk'],
        ['word' => 'Falcon'],
        ['word' => 'Volt'],
        ['word' => 'Power'],
        ['word' => 'Lightning'],
        ['word' => 'Glove'],
        ['word' => 'Lazers &', 'prefix' => true, 'separator' => ' '],
        ['word' => 'Hackers &', 'prefix' => true, 'separator' => ' '],
        ['word' => 'Rider', 'prefix' => true],
        ['word' => 'Storm'],
        ['word' => 'Miami'],
        ['word' => 'Ocean'],
        ['word' => 'Fury'],
        ['word' => 'Rage'],
        ['word' => 'Highway'],
        ['word' => 'Superhighway'],
        ['word' => 'Weekend'],
        ['word' => 'Force'],
        ['word' => 'Droid'],
        ['word' => 'Moon'],
        ['word' => 'Analog', 'prefix' => true],
        ['word' => 'Electro', 'prefix' => true],
        ['word' => 'Attack', 'not' => ['FM']],
        ['word' => 'Waves of', 'prefix' => true, 'separator' => ' '],
        ['word' => 'Gamer'],
        ['word' => 'Highscore'],
        ['word' => 'Game Over', 'separator' => ' '],
        ['word' => 'Story Mode', 'plural' => false, 'separator' => ' '],
        ['word' => 'Glitch'],
        ['word' => 'Glitch or', 'prefix' => true, 'separator' => ' '],
        ['word' => 'Skate or', 'prefix' => true, 'separator' => ' '],
        ['word' => 'or Die', 'suffix' => true, 'separator' => ' ', 'not' => ['Glitch or', 'Skate or', 'Hackers &', 'Lazers &', 'Waves of', 'Summer of']],
        ['word' => 'Venom or', 'prefix' => true],
        ['word' => 'Elite'],
        ['word' => 'Modem'],
        ['word' => 'Quicksand'],
        ['word' => 'Kids', 'suffix' => true],
    ];

    public $years = [
        "1983",
        "1984",
        "1985",
        "83",
        "84",
        "85",
        "88",
        "'83",
        "'85",
        "'88",
    ];

    public $first;
    public $second;
    public $year;
    public $name;

    public function generate()
    {
        $words = [];

        // Get the first word
        $this->first = $this->getFirstWord();
        $words[] = Arr::get($this->first, 'word');

        // Get the second word
        $this->second = $this->getSecondWord();
        $words[] = Arr::get($this->second, 'word');

        // Join 'em
        $separator = $this->getseparator();
        $this->name = implode($separator, $words);

        // Decide if it should be plural
        if ($this->roll(12) && Arr::get($this->second, 'plural') !== false) {
            $this->name = Str::plural($this->name);
        }

        // Decide if there should be a year at the end
        if ($this->roll(5)) {
            if ($separator !== '') {
                $this->name .= ' ';
            }
            $this->name .= $this->getYear();
        }

        return $this->name;
    }

    public function getWord()
    {
        return Arr::random($this->nouns);
    }

    public function getFirstWord() {
        $word = $this->getWord();

        if (Arr::get($word, 'suffix')) {
            return $this->getFirstWord();
        }

        return $word;
    }

    public function getSecondWord() {
        $word = $this->getWord();

        if (in_array($this->first['word'], Arr::get($word, 'not', []))) {
            return $this->getSecondWord();
        }

        if ($word == $this->first || $this->first === Arr::has($word, 'not') || Arr::get($word, 'prefix')) {
            return $this->getSecondWord();
        }

        return $word;
    }

    public function getYear() {
        return Arr::random($this->years);
    }

    public function getseparator() {
        if ($separator = Arr::get($this->first, 'separator')) return $separator;
        if ($separator = Arr::get($this->second, 'separator')) return $separator;

        return Arr::random([' ', ' ', ' ', ' ', '']);
    }

    public function roll($sides = 20, $weighted = false) {
        return Arr::random(array_pad([true], $sides - 1, $weighted));
    }
}
