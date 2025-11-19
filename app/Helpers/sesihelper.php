<?php

if (!function_exists('getSesiList')) {
    function getSesiList() {
        return [
            1 => ['07:00', '07:45'],
            2 => ['07:45', '08:30'],
            3 => ['08:30', '09:15'],
            4 => ['09:15', '10:00'],
            5 => ['10:00', '10:45'],
            6 => ['10:45', '11:30'],
            7 => ['11:30', '12:15'],
            8 => ['12:15', '13:00'],
            9 => ['13:00', '13:45'],
            10 => ['13:45', '14:30'],
            11 => ['14:30', '15:15'],
            12 => ['15:15', '16:00'],
        ];
    }
}

if (!function_exists('getHariList')) {
    function getHariList() {
        return [
            'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat',
        ];
    }
}

if (!function_exists('getSesiNumber')) {
    function getSesiNumber($time)
    {
        $sesiList = getSesiList();
        foreach ($sesiList as $num => $sesi) {
            if ($time >= $sesi[0] && $time <= $sesi[1]) {
                return $num;
            }
        }
        return null;
    }
}

if (!function_exists('convertHariToEnglish')) {
    function convertHariToEnglish($hari) {
        $hariMapping = [
            'Senin' => 'Monday',
            'Selasa' => 'Tuesday',
            'Rabu' => 'Wednesday',
            'Kamis' => 'Thursday',
            'Jumat' => 'Friday',
        ];
        
        return $hariMapping[$hari] ?? 'Monday';
    }
}