<?php require('partials/head.php'); ?>

<section class="section">
    <div class="container">
      <h1 class="title">The National Health Centre</h1>
      <p>Welcome to The National Health Centre homepage. For more information on  booking an appointment
       and  the available time slots for vaccination at our main building scroll below.      </p>
    <?php if(isset($_SESSION['currentBooking']) ) :?>
    <div>
    <br><p class="title is-3 has-text-black"> Your reservation</p>
      <div class="box has-background-primary	column is-one-quarter">
        <p><?= $_SESSION['currentBooking'][0]?></p>
        <p>Date - <?= $_SESSION['currentBooking'][1]?></p>
        <p>Time - <?= $_SESSION['currentBooking'][2]?> hrs</p>
      </div>
    </div>
    <?php endif?>
      <h2 class="title">Available slots</h2>
      <h3 class='title is-4 has-text-primary'><?=date('F', mktime(0, 0, 0, $month, 10)) . ' ' . $year?></h3>
      <?= draw_calendar($month,$year, $availableDays); ?>
      <br/>
      <button class="button is-success navigateMonth" >Previous</button>
      <button class="button is-success navigateMonth" >Next</button><br/><br/>
      <div class="control has-icons-left">
      <div class="control has-icons-left">
      <div class="select is-medium is-rounded is-primary">
      <form id='book' method="POST">
        <select  name='selectedTime' required>
          <option value="" selected disabled hidden>Available times</option>
          <?php foreach($availableSlots as $slot):?>
          <option><?=$slot?></option>
          <?php endforeach ?>
        </select>
        <br/>
        <?php if(! isset($_SESSION['currentBooking']) ) :?>
            <button class="button is-primary">Book</button>
        <?php endif?>
      </form>
      
      </div>
      </div>
      </div>
      <br/><br/><br/>
      <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && 
      isset($_SESSION['username']) && $_SESSION['username']['email'] == 'admin@nemkovid.hu') :?>
      <div>
      <br><p class="title is-4 has-text-black">
        Hey admin, 
         <a href="post-new-date" class="button is-link">
            <strong>Post a new date</strong>
          </a>
      </p>
      </div>
      <?php endif ?>
      <p id='myDiv'></p>
  </section>
  <script type="text/javascript">
  var buttons = document.querySelectorAll('.navigateMonth');
  buttons.forEach(button => button.addEventListener('click', navigateCalender))
function navigateCalender() 
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {   // XMLHttpRequest.DONE == 4
           if (xmlhttp.status == 200) {
              var newDoc = document.open("text/html", "replace");
              newDoc.write(xmlhttp.responseText);
              newDoc.close();
           }
           else if (xmlhttp.status == 400) {
              alert('There was an error 400');
           }
           else {
               alert('something else other than 200 was returned');
           }
        }
    };
    if(event.target.innerHTML == 'Next')
      xmlhttp.open("GET", "/next-month", true);
    else
      xmlhttp.open("GET", "/previous-month", true);

    xmlhttp.send();
}
</script>
<?php require('partials/footer.php'); ?>

