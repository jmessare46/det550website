<script src='<?php echo base_url("js/addCadet.js"); ?>'></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("css/admin.css"); ?>">

<body>
  <div class="jumbotron jumbotron-fluid">
    <div class="row">
      <div class="col-4">
        <div class="card">
          <div id="memWrapper" class="card-body">
            <h5 id="memHeader" class="card-title">Add User</h5> 
            <?php echo form_open('cadet/add'); ?>
                <div>
                  First Name:<br>
                  <input class="form-control" type="text" name="firstname" size="30" id="firstname" required/>
                </div>
                <div>
                  Last Name:<br>
                  <input class="form-control" type="text" name="lastname" size="30" id="lastname" required/>
                </div>
                <div>
                  RIN:<br>
                  <input class="form-control" type="text" name="rin" size="30" id="rin" required/>
                </div>
                <div>
                  Email:<br>
                  <input class="form-control" type="text" name="primaryEmail" size="30" id="primaryEmail" required/>
                </div>
                <div>
                  Administrative Privileges:<br>
                  <select name="admin">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                  </select>
                </div>
                <div>
                  Rank:<br>
                  <select name="rank">
                    <option value="None">None</option>
                    <optgroup label="ROTC Ranks">
                        <option value="AS100">AS100</option>
                        <option value="AS200">AS200</option>
                        <option value="AS250">AS250</option>
                        <option value="AS300">AS300</option>
                        <option value="AS350">AS350</option>
                        <option value="AS400">AS400</option>
                        <option value="AS500">AS500</option>
                    </optgroup>
                    <optgroup label="Enlisted Ranks">
                        <option value="Airman Basic">Airman Basic</option>
                        <option value="Airman">Airman</option>
                        <option value="Airman First Class">Airman First Class</option>
                        <option value="Senior Airman">Senior Airman</option>
                        <option value="Staff Sergeant">Staff Sergeant</option>
                        <option value="Technical Sergeant">Technical Sergeant</option>
                        <option value="Master Sergeant">Master Sergeant</option>
                        <option value="Senior Master Sergeant">Senior Master Sergeant</option>
                        <option value="Chief Master Sergeant">Chief Master Sergeant</option>
                    </optgroup>
                    <optgroup label="Officer Ranks">
                        <option value="Second Lieutenant">Second Lieutenant</option>
                        <option value="First Lieutenant">First Lieutenant</option>
                        <option value="Captain">Captain</option>
                        <option value="Major">Major</option>
                        <option value="Lieutenant Colonel">Lieutenant Colonel</option>
                        <option value="Colonel">Colonel</option>
                        <option value="Brigadier General">Brigadier General</option>
                        <option value="Major General">Major General</option>
                        <option value="Lieutenant General">Lieutenant General</option>
                        <option value="General">General</option>
                    </optgroup>
                  </select>
                </div>
                <div>
                  Flight:<br>
                  <select name="flight">
                    <option value="None">None</option>
                    <option value="Alpha">Alpha</option>
                    <option value="Bravo">Bravo</option>
                    <option value="Charlie">Charlie</option>
                    <option value="Delta">Delta</option>
                    <option value="Echo">Echo</option>
                    <option value="Foxtrot">Foxtrot</option>
                  </select>
                </div>
                <div class="clearfix">
                    Card Input:<br>
                    <input class="form-control" type="text" name="rfid"/>
                </div><br>
                <div class="clearfix">
                  <input class="btn btn-sm btn-primary" type="submit" value="Add User" />
                  <input class="btn btn-sm btn-primary" type="reset" value="Reset"/>
                </div>
              </form><br>
            </div>
          </div>
        </div>

      <div class="col-4">
        <div id="makeuser" class="card">  
          <div id="memWrapper" class="card-body">
            <h5 id="memHeader" class="card-title">Remove User</h5>
            <?php echo form_open('cadet/remove'); ?>
                    <select name="remove" style="width:80%;">
                      <?php           
                        foreach($cadets as $cadet)
                        {
                            echo "<option value='" . $cadet['rin'] . "'>" . $cadet['firstName'] . " " . $cadet['lastName'] . "</option>";
                        }
                      ?>
                    </select><br><br>
                    <button class="btn btn-sm btn-primary" name="submit" type="submit">Remove</button>
                </form>
          </div>
        </div><br>

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Modify User Info</h5>
          <?php echo form_open('cadet/select'); ?>
            <strong>Select User</strong><br>
            <select name="modify" style="width:80%;margin:auto">
              <?php           
                foreach($cadets as $cadet)
                {
                    echo "<option value='" . $cadet['rin'] . "'>" . $cadet['firstName'] . " " . $cadet['lastName'] . "</option>";
                }
              ?>
                <br>
            </select><br><br>
                <button class="btn btn-sm btn-primary" type="submit" name="submit">Modify Cadet Info</button>
            </form>
          </div>
        </div>
      </div>

        <div class="col-4">
          <div class="card">  
            <div class="card-body">
              <h5 class="card-title">Additional Admin Links</h5>
                <h6 class="card-title">Set Event Attendance</h6>
                    <?php echo form_open('cadetevent/view'); ?>
                        <select name="event">
                            <?php
                                foreach( $events as $event )
                                {
                                    echo "<option value='" . $event['eventID'] . "'>" . $event['name'] . "</option>";
                                }
                            ?>
                        </select><br><br>
                        <button class="btn btn-sm btn-primary" type="submit">Select Event</button>
                </form><br><br>
              
                <h6>Delete an Event</h6>
                <?php echo form_open('cadetevent/remove'); ?>
                  <select name="event">
                    <?php
                        foreach($events as $event)
                        {
                            echo "<option value='" . $event['eventID']."'>" . $event['name'] . " " . $event['date'] . "</option>";
                        }
                      
                    ?>
                  </select><br><br>
                  <button class="btn btn-sm btn-primary" type="submit" name="devent">Delete</button>
                </form><br><br>
            
                <h6>Delete an Announcement</h6>
                <?php echo form_open('announcement/remove'); ?>
                  <select name="announcement">
                    <?php
                        foreach($announcements as $announcement)
                        {
                            echo "<option value='" . $announcement['uid'] . "'>" . $announcement['title'] . " " . $announcement['date'] . "</option>";
                        }
                    ?>
                  </select><br><br>
                <button class="btn btn-sm btn-primary" type="submit" name="dannouncement">Delete</button>
                </form><br><br>

                <h6>Unlock Cadet Account</h6>
                <?php echo form_open('cadet/unlock'); ?>
                    <select name="cadet" style="width:80%;">
                      <?php           
                        foreach($cadets as $cadet)
                        {
                            echo "<option value='" . $cadet['rin'] . "'>" . $cadet['firstName'] . " " . $cadet['lastName'] . "</option>";
                        }
                      ?>
                    </select><br><br>
                <button class="btn btn-sm btn-primary" type="submit" name="unlock">Unlock</button>
                </form><br><br>

                <h6>Create/Modify/Delete a Group</h6>
              <?php echo anchor('cadetgroup/view', 'Edit Group', 'class="btn btn-sm btn-primary"'); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>