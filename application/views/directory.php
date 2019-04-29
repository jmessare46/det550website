<link rel="stylesheet" type="text/css" href="<?php echo base_url("css/directory.css"); ?>">

<div class="jumbotron container-fluid">
    <h1 class="display-4"> Detachment Directory </h1><br>
      <?php echo form_open('cadetdirectory/major'); ?>
        <select class="form-control" name="showcadets">
<?php
    if(strcmp("all", $selected) == 0 )
    {
        echo "<option selected value='all'>All</option>";
    }
    else
    {
        echo "<option value='all'>All</option>";
    }
    foreach( $majors as $major )
    {
        if( strcmp($major->major, "") != 0 && strcmp($major->major, $selected) == 0 )
        {
            echo "<option selected value='" . $major->major . "'>" . $major->major . "</option>";
        }
        else if( strcmp($major->major, "") != 0 )
        {
            echo "<option value='" . $major->major . "'>" . $major->major . "</option>";
        }
    }
?>
        </select><br>
        <button class="btn btn-sm btn-primary" type="submit" value="Submit" name="submit">Show Cadets</button><br><br>
    </form>

    
<?php
//TODO: Find a better way to do this
$images = scandir("./images");
foreach( $users as $user )
{
    if( in_array($user->username . ".jpg", $images) )
    {
        $file = base_url("images/" . $user->username . ".jpg" );
    }
    else if( in_array($user->username . ".png", $images) )
    {
        $file = base_url("images/" . $user->username . ".png" );
    }
    else if( in_array($user->username . ".jpeg", $images) )
    {
        $file = base_url("images/" . $user->username . ".jpeg" );
    }
    else
    {
        $file = base_url("images/default.jpeg");
    }
    
    echo "<div class='card' style='display:inline-block;text-align:center;'>";
    
    // This needs to be fixed with cadet's picture
    echo "  <img class='img-fluid' style='padding:5px;height:200px;width:200px;' src='" . $file . "' alt='Cadet Profile Picture'>";
    echo "<div class='card-body'>";
    if(strpos($user->class, "AS") !== false)
    {
        echo "<h5 class='card-title'>Cadet " . $user->last_name . "</h5>";
    }
    else if(strpos($user->class, "None") !== false)
    {
        echo "<h5 class='card-title'> " . $user->first_name . " " . $user->last_name . "</h5>";
    }
    else
    {
        echo "<h5 class='card-title'>" . $user->rank . " " . $user->last_name . "</h5>";
    }
    echo "<p class='card-text'><strong>Rank: </strong>" . $user->rank . "<br><strong>Flight: </strong>" . $user->flight . "</p>";
    echo form_open('cadetdirectory/profile');
    echo "<input value='" . $user->id . "' name='rin' style='display:none;' readonly>";
    echo "<button class='btn btn-sm btn-primary' type='submit'>View Profile</button></form></div></div>";
}
?>
</div>