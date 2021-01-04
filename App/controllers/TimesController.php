<?php
namespace App\Controllers;
use JsonStorage;
use DateTime;
use Time;

class TimesController
{
    /**
     * Show the home/main page.
     */
    public function index()
    {
        session_start();
        if(! (isset($_SESSION['monthCounter'])))
            $_SESSION['monthCounter'] =  0;

        $number =  (int)$_SESSION['monthCounter'] + (int) date('m'); 
        $month = ($number == 12) ? 12 : $number % 12;
        if($month < 1)
            $month = 12 + $month;
        $year = (int)date('Y') ;

        $availableSlots =  TimesController::getAvailableSlots($month)[0];
        $availableDays = TimesController::getAvailableSlots($month)[1];
        TimesController::checkHasBooking();
        return view('main', 
                        [
                            'availableSlots' => $availableSlots, 
                            'year'=> $year,
                            'month'=>$month,
                            'availableDays'=> $availableDays
                        ]
                    );
    }
    public function create()
    {
        session_start();
        return view('newBooking');
    }
    public function increase()
    {
        session_start();
        $_SESSION['monthCounter'] += 1;
        return redirect('');
    }
    public function decrease()
    {
        session_start();
        $_SESSION['monthCounter'] += -1;
        return redirect('');
    }
    public function store()
    {
        $errors = [];
        if (! empty($_POST['date']) && ! empty($_POST['time'])
            && ! empty($_POST['totalSlots']) )
        {
            $newDate = $this->read('date');
            $time = $this->read('time');
            $totalSlots = $this->read('totalSlots');
            $errors = TimesController::validate($newDate, $time, $totalSlots);
            if(empty($errors))
            {
                TimesController::save($newDate, $time, $totalSlots);
                return redirect('');
            }         

        }
        else
            $errors['fields'] = 'Missing input fields';

        return view('newBooking',['errors'=>$errors]);
    }
    static function save($newDate, $hour, $totalSlots)
    {
        $storage = new JsonStorage('C:\xampp\htdocs\myHomeProject\database\times.json');
        $id = (int)explode('-', $newDate)[1] - 1;
        $time = $storage->findById($id);
        $hour = explode(':', $hour)[0] . '00';

        if($time == null)
            TimesController::add($storage, $newDate, $hour, $totalSlots);
        else
            TimesController::update($storage, $time, $id, $newDate, $hour, $totalSlots);
           
    }
    static function update($storage, $time, $id, $newDate, $hour, $totalSlots)
    {
        $days = $time['availableDays'];
        $found = false;
        for($i=0; $i< count($days); $i++)
        {
            if(isset($days[$i]['date']))
            {
                if($days[$i]['date'] == $newDate)
                {
                        $days[$i]['availableSlots'][$hour] = $totalSlots; 
                        $found = true;  
                        break;
                }
            }
        }
        if(!$found)
        {
            $day['date'] =  $newDate;
            $day['availableSlots'] = [$hour=>$totalSlots];
            $days [] = $day;
        }
        $time['availableDays'] = $days;
        $storage->update($id, $time);
        $storage->save();
}
  
    

static function add($storage, $newDate, $hour, $totalSlots)
{
    $day['date'] =  $newDate;
    $day['availableSlots'] = [$hour=>$totalSlots];
    $availableDays [] = $day;

    $time['month'] = (int)explode('-', $newDate)[1];
    $time['availableDays'] = $availableDays;

    $storage->add($time);
    $storage->save();
}
    static function validate($newDate, $time, $totalSlots)
    {
        $currentDate = new DateTime('');
        $errors = [];
        if(!(TimesController::isValidDate($newDate) &&  $currentDate < (new DateTime($newDate))) )
            $errors ['date'] = 'Invalid date. Please note the date has to be in future';
        if(! (preg_match("/^(?:2[0-4]|[01][1-9]|10):([0-5][0-9])$/", $time) && 
            strtotime($time) >= strtotime('08:00') && strtotime($time) <= strtotime('18:00'))) 
            $errors ['time'] = 'Invalid time. Please note that valid hours are between 0800hrs - 1800hrs';
        if(!(is_numeric($totalSlots) && $totalSlots > 0 && $totalSlots <= 5
                && $totalSlots == round($totalSlots, 0)))
            $errors['totalSlots'] = 'Invalid total slots. Please note atleast one slot isavailable and a maximum of 5 per hour';        

        return $errors;
    }
    private static function getAvailableSlots($month)
    {
        $availableTimes = [];
        $days = [];
        $storage = new JsonStorage('C:\xampp\htdocs\myHomeProject\database\times.json');
        $month = ( $storage->findOne(['month'=>$month]));
        if(! is_null($month))                
            {$availableDays = $month['availableDays'];
            foreach($availableDays as $day)
            {
                $availableSlots = $day['availableSlots'];
                foreach($availableSlots as $time => $slot)
                {
                    $availableTimes [] = $day['date'] . ' ' . $time . ' ' . $slot . '/5 free slots' ; 
                    $days [] = (explode('-', $day['date']))[2];
                }
            }    
        }        

        return [$availableTimes, $days];
    }
    static function checkHasBooking()
    {
        if(isset($_SESSION['loggedin']))
        {
            $booking = new JsonStorage('C:\xampp\htdocs\myHomeProject\database\bookings.json');    
            $currentUser = $_SESSION['username']; 
            $currentBk = $booking->findOne(['username'=>$currentUser['email']]);
                            
            if(isset($currentBk))
            {
                $bookingInfo = [];
                foreach($currentBk as $bk)
                    $bookingInfo [] = $bk;
                    
                $_SESSION['currentBooking'] = $bookingInfo;
            }
        }
    }
    public function read($name)
    {
        return trim(htmlspecialchars($_POST[$name]));
    }
    static function isValidDate($date)
    {
        $date = explode('-', $date);
        return checkdate($date[1], $date[2], $date[0]);
    }
}