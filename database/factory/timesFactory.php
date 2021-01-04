<?php
//This file was used to generate dummy data ( available dates and times)
require_once('storage.php');

for($i = 1; $i <= 6; $i++)
{
    $first = '2021-0' . $i . '-01';
    $begin = new DateTime($first);
    $end = new DateTime( date('Y-m-d', strtotime($first . ' + ' 
            .  cal_days_in_month(CAL_GREGORIAN, $i, 2021) . 'days')));
    $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
    $availableDates = generateRandomDates($daterange);
    store($i, $availableDates);
}

function generateRandomDates($daterange)
{
    $dates = [];
    foreach($daterange as $date)
        $dates [] = $date;

    shuffle($dates);
    $availableDates = array_slice($dates, 0, 12);
    sort($availableDates);

    return $availableDates;
}

function store($month, $availableDates)
{
    $storage = new JsonStorage('times.json');
    $allTimes = [];
    foreach($availableDates as $date)
    {
        $day['date'] =  $date->format('Y-m-d');
        $day['availableSlots'] = randomValidHours();
        $allTimes [] = $day;
    }
    $time['month'] = $month;
    $time['availableDays'] = $allTimes;

    $storage->add($time);
    $storage->save();
}

function randomValidHours()
{
    $availableHours = rand(1, 3);
    $times = [];
    for($i = 0; $i<$availableHours; $i++)
    {
        $validhour = rand(8, 18);
        $validhour = $validhour < 10 ? '0' . $validhour . '00' : $validhour . '00';
        $times [$validhour] = rand(1,5);
    }
    ksort($times);
    return $times;
}
