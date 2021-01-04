<?php require('partials/head.php'); ?>
<div class="hero is-fullheight is-primary">
  <div class="hero-body">
    <div class="container has-text-centered">
    <h3 class="title has-text-white">The Natonal Health Centre Administration Page</h3>
        <div class="box">
        <div class="title has-text-grey is-5">Please fill in the data below.</div>
        <?php if(isset($errors['fields'])) :?>
              <p class="help is-danger"><?=$errors['fields']?></p>
        <?php endif?>
      <section class="section">
              <div class="columns">
                  <div class="column is-4 is-offset-4">
                  <form method="POST">
                    <div class="field">
                        <label class="label">Date</label>
                        <div class="control">
                          <input class="input" name='date' type="date">
                        </div>
                        <?php if(isset($errors['date'])) :?>
                            <p class="help is-danger"><?=$errors['date']?></p>
                        <?php endif?>
                    </div>
                    <div class="field">
                        <label class="label">Time</label>
                        <div class="control">
                          <input class="input" name='time' type="time" step="3600">
                        </div>
                        <?php if(isset($errors['time'])) :?>
                            <p class="help is-danger"><?=$errors['time']?></p>
                        <?php endif?>
                    </div>
                    <div class="field">
                        <label class="label">Total slots</label>
                        <div class="control">
                          <input class="input" name='totalSlots' type="number" placeholder="Total available slots">
                        </div>
                        <?php if(isset($errors['totalSlots'])) :?>
                            <p class="help is-danger"><?=$errors['totalSlots']?></p>
                        <?php endif?>
                    </div>
                    <div class="field is-grouped">
                        <div class="control">
                          <button class="button is-link">Submit</button>
                        </div>
                    </div>
                    </form>
                  </div>
              </div>
            </section>  
    </div>
  </div>
<?php require('partials/footer.php'); ?>
