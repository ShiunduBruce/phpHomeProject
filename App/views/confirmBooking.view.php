<?php require('partials/head.php'); ?>
<div class="hero is-fullheight is-primary">
    <div class="container has-text-centered">
      <div class="column is-8 is-offset-2">
      <h3 class="title has-text-white">The Natonal Health Centre  page</h3>
        <hr class="login-hr">
    </div>

        <p class="title is-1  has-text-black"></p>
        <p class="subtitle is-3  has-text-black" ><?=$_SESSION['username']['name'] ?></p>
        <p class="subtitle is-4  has-text-white">SSN - <?=$_SESSION['username']['SSN'] ?></p>
        <p class="subtitle is-4  has-text-white"><?=$_SESSION['username']['address'] ?></p>

        <p class="title is-2 has-text-black"> Reservation</p>
        <p class="subtitle is-4">Day - <?=$date?></p>
        <p class="subtitle is-4">Time - <?=$time?> hrs</p>
      <form method="POST">
        <div class="box">
        <div class="field">
            <p class="has-text-black">Please note that once a reservation is made it is mandatory to show up for the booking. Failure to adhere may lead to denial of future bookings. 
                Please also note that thre may be minor side effects to the vaccine which passes with time.
                In case of abnormalities please report to us as soon as possible.
            </p>
            <?php if(isset($error)) :?>
            <div>
                  <p style="color:red"><?=$error?></p>
            </div>
          <?php endif?>
            <div class="control">
                <label class="checkbox">
                    <input name='termsAndConditions' type="checkbox"> I agree to the terms and conditions </label>    
            </div>
        </div>
        </div>
        <br/>
          <div class="control">
          <button class="button is-link">Confirm booking</button>
        </div>
      </form>
      <?php if(isset($_SESSION['username']) && $_SESSION['username']['email'] == 'admin@nemkovid.hu') :?>
      <div>
      <br><p class="title is-3 has-text-black">People who have a booking this date</p>
        <div class="box has-background-info column is-three-fifths is-offset-one-fifth">
          <ul>
          <?php if(!empty($usersWhoAppliedForThisDate)) :?>
            <?php foreach($usersWhoAppliedForThisDate as $user) :?>
              <li><?=$user['name'] . ',  ' . $user['SSN'] . ',  ' . $user['email'] ?></li>
            <?php endforeach ?>
            <?php else :?>
              <li class='has-text-danger-dark'>NO ONE HAS APPLIED FOR THIS DATE YET</li>
          <?php endif ?>
          </ul>
        </div>
      </div>
      <?php endif ?>
     </div>
</div>
<?php require('partials/footer.php'); ?>