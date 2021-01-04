<?php require('partials/head.php'); ?>
<div class="hero is-fullheight is-primary">
  <div class="hero-body">
    <div class="container has-text-centered">
    <h3 class="title has-text-white">The Natonal Health Centre Registration Page</h3>
        <div class="box">
        <div class="title has-text-grey is-5">Please enter your details below.</div>
        <?php if(isset($errors['fields'])) :?>
            <p class="help is-danger"><?=$errors['fields']?></p>
        <?php endif?>
      <section class="section">
              <div class="columns">
                  <div class="column is-4 is-offset-4">
                  <form method="POST">
                    <div class="field">
                        <label class="label">Full Name</label>
                        <div class="control">
                          <input class="input" name='fullName' type="text" placeholder="Full name">
                        </div>
                        <?php if(isset($errors['name'])) :?>
                            <p class="help is-danger"><?=$errors['name']?></p>
                        <?php endif?>
                    </div>
                    <div class="field">
                        <label class="label">Address</label>
                        <div class="control">
                          <input class="input" name='address' type="text" placeholder="Street name, Zip Code, City, Country">
                        </div>
                        <?php if(isset($errors['address'])) :?>
                            <p class="help is-danger"><?=$errors['address']?></p>
                        <?php endif?>                        
                    </div>
                    <div class="field">
                        <label class="label">Social Security Number</label>
                        <div class="control has-icons-left has-icons-right">
                          <input class="input is-success" name='SSN' type="text" placeholder="SSN input" >
                          <span class="icon is-small is-left">
                          <i class="fa fa-user"></i>
                          </span>
                          <span class="icon is-small is-right">
                          <i class="fa fa-check"></i>
                          </span>
                        </div>
                        <?php if(isset($errors['SSN'])) :?>
                            <p class="help is-danger"><?=$errors['SSN']?></p>
                        <?php endif?>
                    </div>
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control has-icons-left has-icons-right">
                          <input class="input is-danger" name='email' type="email" placeholder="Email input" >
                          <span class="icon is-small is-left">
                          <i class="fa fa-envelope"></i>
                          </span>
                          <span class="icon is-small is-right">
                          <i class="fa fa-warning"></i>
                          </span>
                        </div>
                        <?php if(isset($errors['email'])) :?>
                            <p class="help is-danger"><?=$errors['email']?></p>
                        <?php endif?>
                        <?php if(isset($errors['exists'])) :?>
                            <p class="help is-danger"><?=$errors['exists']?></p>
                        <?php endif?>
                      </div>
                    <div class="field">
                        <label class="label">Phone</label>
                        <div class="control">
                          <input class="input" name='phoneNumber' type="text" placeholder="399-2191-3399">
                        </div>
                        <?php if(isset($errors['phone'])) :?>
                            <p class="help is-danger"><?=$errors['phone']?></p>
                        <?php endif?>
                    </div>
                    <div class="field">
                      <label class="label">Password</label>
                      <div class="control">
                      <input class="input is-large" name='password' type="password" placeholder="Password">
                      </div>
                    </div>
                    <div class="field">
                      <label class="label">Confirm password</label>
                      <div class="control">
                      <input class="input is-large" name='confirmPassword' type="password" placeholder="confirm password">
                      </div>
                      <?php if(isset($errors['password'])) :?>
                            <p class="help is-danger"><?=$errors['password']?></p>
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
