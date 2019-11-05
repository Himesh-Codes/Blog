<!--********** Form Section  **********-->
<div class="inner-container">
    <div class="register-container">
      <div class="register-area">

        <!-- ***** Form Begins ****** -->
        <?php 
            if(checkLogin() == TRUE)
            {
              echo form_open('profile/registration/2'); 
            }

            else
            {
               echo form_open('profile/registration/1');
            }
        ?>
           <!-- ******** Username Section ********* --> 
           <div class="input-section">  
           <?php
             if( (checkLogin() == TRUE) && isset($result['details']) )
             {

               foreach ($result['details'] as $item)

               {
                  $row['username'] = $item['username'];
                  $row['firstname'] = $item['firstname'];
                  $row['lastname'] = $item['lastname'];
                  $row['emailid'] = $item['emailid'];
                  $row['gender'] = $item['gender'];
                  $row['frequency'] = $item['frequency'];
               }
             }
              ?> 
                <div class="row">
                    <div class="col-sm-12 col-lg-4">
                       <h5 class="input-text"><label for="username">Username</label>
                        <span class="errors">
                            <?php 
                                    echo "*";
                            ?>
                        </span></h5>
                    </div>
                    <div class="col-sm-12 col-lg-8">
                        <input type="text" name="username"  class="form-control float-right" value="<?php 
                        if(checkLogin() == TRUE)
                        {
                           $username = set_value('username') == false ? $row['username']: set_value('username');
                           echo $username;
                        }
                        else
                        {
                          echo set_value('username'); 
                        }
                         ?>" 
                        size="50" required>
                        <p> Atleast 5 charecters required </p>
                        <div class="errors">
                            <?php echo form_error('username'); ?> 
                        </div>
                    </div>
                </div>
            </div>
            <?php
              if(checkLogin() == FALSE)
              {
            ?>
            <!-- ******Passsword section****** -->
            <div class="input-section">
                <div class="row">
                    <div class="col-sm-12 col-lg-4">
                        <h5 class="input-text"><label for="password">Password</label>
                          <span class="errors">
                              <?php 
                                      echo "*";
                              ?>
                          </span></h5>
                    </div>
                    <div class="col-sm-12 col-lg-8">
                        <input type="password" name="password" class="form-control float-right" value="<?php echo set_value('password'); ?>" size="50" required>
                         <p> Atleast 8 charecters required </p>
                        <div class="errors">
                            <?php echo form_error('password'); ?> 
                        </div>
                    </div>
                </div>
            </div>
            <!-- ******Confirm Passsword section****** -->
            <div class="input-section">
                <div class="row">
                    <div class="col-sm-12 col-lg-4">
                       <h5 class="input-text"><label for="confirm-password">Confirm Password</label>
                          <span class="errors">
                              <?php 
                                      echo "*";
                              ?>
                          </span></h5>
                    </div>
                    <div class="col-sm-12 col-lg-8 ">
                        <input type="password" name="confirm-password" class="form-control float-right" value="<?php echo set_value('confirm-password'); ?>" size="50" required>
                         <p> Atleast 8 charecters required </p>
                        <div class="errors">
                            <?php echo form_error('confirm-password'); ?> 
                        </div>
                    </div>
                </div>
            </div>
            <?php
              }
            ?>
            <!-- ******Firstname section****** -->
            <div class="input-section">
                <div class="row">
                    <div class="col-sm-12 col-lg-4">
                       <h5 class="input-text"><label for="firstname">Firstname</label>
                          <span class="errors">
                              <?php 
                                      echo "*";
                              ?>
                          </span></h5>
                    </div>
                    <div class="col-sm-12 col-lg-8 ">
                        <input type="text" name="firstname" class="form-control float-right" value="<?php
                        if(checkLogin()==TRUE)
                        {
                           $firstname = set_value('firstname') == false ? $row['firstname']: set_value('firstname');
                           echo $firstname;
                        }
                        else
                        {
                          echo set_value('firstname'); 
                        } ?>" size="50" required>
                        <div class="errors">
                            <?php echo form_error('firstname'); ?> 
                        </div>
                    </div>
                </div>
            </div>
             <!-- ******Lastname section****** -->
            <div class="input-section">
                <div class="row">
                    <div class="col-sm-12 col-lg-4">
                       <h5 class="input-text"><label for="lastname">Lastname</label>
                          <span class="errors">
                              <?php 
                                      echo "*";
                              ?>
                          </span></h5>
                    </div>
                    <div class="col-sm-12 col-lg-8 ">
                        <input type="text" name="lastname" class="form-control float-right" value="<?php
                         if(checkLogin()==TRUE)
                        {
                           $lastname = set_value('lastname') == false ? $row['lastname']: set_value('lastname');
                           echo $lastname;
                        }
                        else
                        {
                          echo set_value('lastname'); 
                        } ?>" size="50" required>
                        <div class="errors">
                            <?php echo form_error('lastname'); ?> 
                        </div>
                    </div>
                </div>
            </div>
            <!-- ******Email section****** -->
            <div class="input-section">
                <div class="row">
                    <div class="col-sm-12 col-lg-4">
                       <h5 class="input-text"><label for="email">Email</label>
                          <span class="errors">
                              <?php 
                                      echo "*";
                              ?>
                          </span></h5>
                    </div>
                    <div class="col-sm-12 col-lg-8 ">
                        <input type="email" name="email" class="form-control float-right" value="<?php
                        if(checkLogin()==TRUE)
                        {
                           $emailid = set_value('email') == false ? $row['emailid']: set_value('email');
                           echo $emailid;
                        }
                        else
                        {
                          echo set_value('emailid'); 
                        }  ?>" size="50" required>
                        <div class="errors">
                            <?php echo form_error('email'); ?> 
                        </div>
                    </div>
                </div>
            </div>
            <!-- ******Gender section****** -->
            <div class="input-section">
                <div class="row">
                    <div class="col-sm-12 col-lg-4">
                       <h5 class="input-text"><label for="gender">Gender</label></h5>
                    </div>
                    <div class="col-sm-12 col-lg-8 ">
                      <?php
                      if((checkLogin()==TRUE) && isset($row) )
                        {
                          if(strcmp($row['gender'] , 'male') == 0)
                          {
                            $male = TRUE;
                          }

                          else
                          {
                            $male = FALSE;
                          }
                        }
                        else
                        {
                          $male = FALSE; 
                        } 
                        $male = array(
                                            'name'          => 'gender',
                                            'class'            => 'gender-button',
                                            'value'         => 'male',
                                            'checked'       => $male,

                                    );
                        echo form_radio($male);
                        ?>
                        <span class="radio-text">Male</span>
                        <?php
                        if((checkLogin()==TRUE) && isset($row) )
                        {
                          if(strcmp($row['gender'] , 'female') == 0)
                          {
                            $female = TRUE;
                          }

                          else
                          {
                            $female = FALSE;
                          }
                        }
                        else
                        {
                          $female = FALSE; 
                        } 
                        $female = array(
                                            'name'          => 'gender',
                                            'class'            => 'gender-button',
                                            'value'         => 'female',
                                            'checked'       => $female,
                                    );
                        echo form_radio($female);
                        ?>
                        <span class="radio-text">Female</span>
                        <?php
                        if((checkLogin()==TRUE) && isset($row) )
                        {
                          if(strcmp($row['gender'] , 'not disclose') == 0)
                          {
                            $other = TRUE;
                          }

                          else
                          {
                            $other = FALSE;
                          }
                        }
                        else
                        {
                          $other = FALSE; 
                        } 
                        $no = array(
                                            'name'          => 'gender',
                                            'class'            => 'gender-button',
                                            'value'         => 'not disclose',
                                            'checked'       => $other,
                                    );
                        echo form_radio($no);
                        ?>
                        <span class="radio-text">Not Disclosing</span>
                        <div class="errors">
                            <?php echo form_error('gender'); ?> 
                        </div>
                    </div>
                </div>
            </div>
            <!-- ******Subscription section****** -->
            <div class="input-section">
                <div class="row">
                    <div class="col-sm-12 col-lg-4">
                       <h5 class="input-text"><label for="list">Subscription</label>
                       <span class="errors">
                              <?php 
                                      echo "*";
                              ?>
                          </span></h5>
                    </div>
                    <?php

                    //iterator variable
                    $index = 0;

                      /**
                     * Category  checkbox  checked
                     *
                     * @var array
                     */
                    $checked = array();

                    /**
                     * Blog category options for checkbox 
                     *
                     * @var array
                     */
                    $category = array();

                    foreach ($options as $value) 
                       {
                          $category[$index] = $value['category_name'];
                          $index++;
                       }

                       if( (checkLogin() == TRUE) && isset($result['subscribe']))
                       {
                          //initialise all as false
                          $checked['finance'] = FALSE;
                          $checked['Fun'] = FALSE;
                          $checked['Free thinks & Motivations'] = FALSE;
                          $checked['Science & Technology'] = FALSE;
                          $checked['Stories'] = FALSE;
                          $checked['Travel Experience'] = FALSE;

                          foreach ($result['subscribe'] as $item)
                          {   
                            
                              if(strcmp($item['subscription'] ,'Finance') == 0)
                              {
                                  $checked['finance'] = TRUE;
                              }

                              if(strcmp($item['subscription'] , 'Free thinks & Motivations') == 0)
                              {
                                  $checked['Free thinks & Motivations'] = TRUE;
                              }

                              if(strcmp($item['subscription'] , 'Fun') == 0)
                              {
                                  $checked['Fun'] = TRUE;
                              }
                             

                              if(strcmp($item['subscription'] , 'Science & Technology') == 0)
                              {
                                  $checked['Science & Technology'] = TRUE;
                              }

                              if(strcmp($item['subscription'] , 'Stories') == 0)
                              {
                                  $checked['Stories'] = TRUE;
                              }

                              if(strcmp($item['subscription'] , 'Travel Experience') == 0)
                              {
                                  $checked['Travel Experience'] = TRUE;
                              }
                              
                          } 
                        }                                     
                    ?>
                    <div class="col-sm-12 col-lg-8 ">
                              <input type="checkbox" name="list[]" value="<?php echo $category[0];?>"  <?php 
                              if(checkLogin() == FALSE)
                              {
                                echo set_checkbox('list[]', 
                                $category[0]);
                              }
                              else
                              {
                                if( $checked['finance'] == TRUE)
                                {
                                  echo 'checked';
                                }
                              }
                              ?> /><span class="check-text">&nbsp;<?php echo $category[0];?></span>

                              <input type="checkbox" name="list[]" value="<?php echo $category[1];?>" <?php  
                              if(checkLogin() == FALSE)
                              {
                                echo set_checkbox('list[]', 
                                $category[1]);
                              }
                              else
                              {
                                if( $checked['Free thinks & Motivations'] == TRUE)
                                {
                                  echo 'checked';
                                }
                              } ?> /><span class="check-text">&nbsp;<?php echo $category[1];?></span>

                              <input type="checkbox" name="list[]" value="<?php echo $category[2];?>" <?php 
                              if(checkLogin() == FALSE)
                              {
                                echo set_checkbox('list[]', 
                                $category[2]);
                              }
                              else
                              {
                                if( $checked['Fun'] == TRUE)
                                {
                                  echo 'checked';
                                }
                              } ?> /><span class="check-text">&nbsp;<?php echo $category[2];?></span>

                              <input type="checkbox" name="list[]" value="<?php echo $category[3];?>" <?php 
                              if(checkLogin() == FALSE)
                              {
                                echo set_checkbox('list[]', 
                                $category[3]);
                              }
                              else
                              {
                                if( $checked['Science & Technology'] == TRUE)
                                {
                                  echo 'checked';
                                }
                              }  ?>/><span class="check-text">&nbsp;<?php echo $category[3];?></span>

                              <input type="checkbox" name="list[]" value="<?php echo $category[4];?>" <?php
                               if(checkLogin() == FALSE)
                              {
                                echo set_checkbox('list[]', 
                                $category[4]);
                              }
                              else
                              {
                                if( $checked['Stories'] == TRUE)
                                {
                                  echo 'checked';
                                }
                              }  ?>/><span class="check-text">&nbsp;<?php echo $category[4];?></span>

                              <input type="checkbox" name="list[]" value="<?php echo $category[5];?>" <?php
                              if(checkLogin() == FALSE)
                              {
                                echo set_checkbox('list[]', 
                                $category[5]);
                              }
                              else
                              {
                                if( $checked['Travel Experience'] == TRUE)
                                {
                                  echo 'checked';
                                }
                              }  ?>/><span class="check-text">&nbsp;<?php echo $category[5];?></span>
                        <div class="errors">
                            <?php echo form_error('list[]'); ?> 
                        </div>
                    </div>
                </div>
            </div>
            <!-- ******Gender section****** -->
            <div class="input-section">
                <div class="row">
                    <div class="col-sm-12 col-lg-4">
                       <h5 class="input-text"><label for="frequency">Subscription Frequency</label>
                       <span class="errors">
                              <?php 
                                      echo "*";
                              ?>
                          </span></h5>
                    </div>
                    <div class="col-sm-12 col-lg-8 ">
                      <?php
                      if(checkLogin()==TRUE)
                        {
                           
                           $frequency = $this->input->post('frequency') == '' ? $row['frequency']: $this->input->post('frequency');
                  
                        }
                        else
                        {
                          $frequency = $this->input->post('frequency');
                        } 
                        $weekly = array(
                                            'name'          => 'frequency',
                                            'value'         => 'weekly',
                                            'checked'       => $frequency === 'weekly',
                                    );
                        echo form_radio($weekly);
                        ?>
                        <span class="radio-text">Weekly</span>
                        <?php
                        $biweekly = array(
                                            'name'          => 'frequency',
                                            'value'         => 'bi-weekly',
                                            'checked'       => $frequency === 'bi-weekly',
                                    );
                        echo form_radio($biweekly);
                        ?>
                        <span class="radio-text">Bi-Weekly</span>
                        <?php
                        $monthly = array(
                                            'name'          => 'frequency',
                                            'value'         => 'monthly',
                                            'checked'       => $frequency === 'monthly',
                                    );
                        echo form_radio($monthly);
                        ?>
                        <span class="radio-text">Monthly</span>
                        <div class="errors">
                            <?php echo form_error('frequency'); ?> 
                        </div>
                    </div>
                </div>
            </div>
            <!--********* Agree checkbox ********* -->
            <div class="input-section">
              <input class="form-check-input" type="checkbox" name="agree" required> I agree to all the conditions above
            </div>
            <!-- ******** submit section ********** -->
            <div class="submit-area">
              <?php 
                if(checkLogin() == FALSE)
                {
              ?>
                  <a href="<?php echo base_url(); ?>user">Have already an account?</a>
                  <input type="submit" name="submit" class="login-button float-right" value="Submit" />
              <?php
                }
                else
                {
              ?>
              <p class="delete-profile"><a href="<?php echo base_url(); ?>profile/delete_profile">Delete Profile</a></p>
                  <a href="<?php echo base_url(); ?>blog/home">Back to home</a>
                  <input type="submit" name="submit" class="login-button float-right" value="Update" />
              <?php
                }
              ?>  
            </div>
        </form>
      </div>
    </div>
</div>