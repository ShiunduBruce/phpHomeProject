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
    public function destroy()
    {
        session_start();
        $currentUser = $_SESSION['username']['email'];
        $BOOKINGS = new JsonStorage(path('bookings.json'));
        
        $BOOKINGS->delete(BookingController::findID($currentUser));
        $BOOKINGS->save();

        unset($_SESSION["hasBooking"]);
        unset($_SESSION["currentBooking"]);

        return redirect('');
    }
    /**
     * Finds IDS
     * IDS are based int and are auto increasing
     * Thus iteration returns an ID
     */
    static function findID($email)
    {
        $BOOKINGS = new JsonStorage(path('bookings.json'));
        $id =0;
        foreach($BOOKINGS->findAll() as $bk)
        {
            if($bk['username'] == $email)
                return $id;
            $id += 1;
        }
        return -1;
    }
    public function show()
    {
        session_start();
        
        if (! isset($_SESSION['bookedTime']))
            return redirect('');

        $date = $_SESSION['bookedTime'][0];
        $BOOKINGS = new JsonStorage(path('bookings.json')); 
        $USERS = new JsonStorage(path('users.json')); 

        $bookingsForThisDate = $BOOKINGS->findAll(['date'=>$date]);
        $usersWhoAppliedForThisDate = [];

        foreach($bookingsForThisDate as $bk)
            $usersWhoAppliedForThisDate [] =  $USERS->findOne(['email'=>$bk['username']]);

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
        $_SESSION['hasBooking'] = true;
        BookingController::updateAvailableTimes($date, $hour);
        $booking = new Booking($username, $date, $hour);
        BookingController::save($booking);

        return view('successBooking');
    }
    static function save($booking)
    {
        $BOOKINGS = new JsonStorage(path('bookings.json'));
        $BOOKINGS->add($booking);
        $BOOKINGS->save();
    }
    static function updateAvailableTimes($date, $hour)
    {
        $TIMES = new JsonStorage(path('times.json'));
        $id = (int)explode('-', $date)[1] - 1;
        $time = $TIMES->findById($id);
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
            $TIMES->delete($id);
        else
        {
            $time['availableDays'] = $days;
            $TIMES->update($id, $time);
        }
        $TIMES->save();
    }
}
