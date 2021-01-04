<?php

class Booking
{
    function __construct($username, $date, $time)
    {
        $this->username = $username;
        $this->date = $date;
        $this->time = $time;
    }
}