<?php
namespace App\Controllers;
use Booking;
use JsonStorage;

class BookingController
{
    public function index()
    {

        session_start();
        if (! ( isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) )
            return redirect('login');
        
        $_SESSION['bookedTime'] = (explode(' ', $_POST['selectedTime'])); 
        return redirect ('book-this-date');
    }
    public function show()
    {
        session_start();
        
        if (! isset($_SESSION['bookedTime']))
            return redirect('');

        $date = $_SESSION['bookedTime'][0];
        $bookings = new JsonStorage('C:\xampp\htdocs\myHomeProject\database\bookings.json'); 
        $users = new JsonStorage('C:\xampp\htdocs\myHomeProject\database\users.json'); 

        $bookingsForThisDate = $bookings->findAll(['date'=>$date]);
        $usersWhoAppliedForThisDate = [];

        foreach($bookingsForThisDate as $bk)
        {
            $usersWhoAppliedForThisDate [] =  $users->findOne(['email'=>$bk['username']]);
        }
        return view('confirmBooking', 
                        [
                            'date'=> $_SESSION['bookedTime'][0], 
                            'time'=> $_SESSION['bookedTime'][1],
                            'usersWhoAppliedForThisDate'=>$usersWhoAppliedForThisDate
                        ]);
    }
    public function store()
    {
        session_start();
        
        if (! isset($_POST['termsAndConditions']))
        {
            $error = "Please agree to our terms and conditions"; 
            return view('confirmBooking', [
                                    'error'=>$error,
                                    'date'=> $_SESSION['bookedTime'][0], 
                                    'time'=> $_SESSION['bookedTime'][1]
                                ]);   
        }  
        $username = $_SESSION['username']['email'];
        $date = $_SESSION['bookedTime'][0];
        $hour = $_SESSION['bookedTime'][1];

        BookingController::updateAvailableTimes($date, $hour);
        $booking = new Booking($username, $date, $hour);
        BookingController::save($booking);

        return view('successBooking');
    }
    static function save($booking)
    {
        $storage = new JsonStorage('C:\xampp\htdocs\myHomeProject\database\bookings.json');
        $storage->add($booking);
        $storage->save();
    }
    static function updateAvailableTimes($date, $hour)
    {
        $storage = new JsonStorage('C:\xampp\htdocs\myHomeProject\database\times.json');
        $id = (int)explode('-', $date)[1] - 1;
        $time = $storage->findById($id);
        $days = $time['availableDays'];
        for($i=0; $i< count($days); $i++)
        {
            if(isset($days[$i]['date']))
            {
                if($days[$i]['date'] == $date)
                {
                    if($days[$i]['availableSlots'][$hour] == 1)
                        unset($days[$i]['availableSlots'][$hour]);
                    else
                        $days[$i]['availableSlots'][$hour] -= 1;

                    if(empty($days[$i]['availableSlots']))
                        unset($days[$i]);
                    
                    break;
                }
            }
        }
        if(empty($days))
            $storage->delete($id);
        else
        {
            $time['availableDays'] = $days;
            $storage->update($id, $time);
        }
        $storage->save();
    }
}
