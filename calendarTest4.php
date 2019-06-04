<?php 
    require_once 'configur.php';
    
?>

<!DOCTYPE html>
<?php 

    include_once 'header.php';

   

?>
<?php      

    if(isset($_SESSION['id'])) {
      $user = $_SESSION['id'];
    }

    if(isset($_SESSION['admin'])) {
      $admin = $_SESSION['admin'];
    }

    if (!isset($_SESSION['id'])){
        header('Location: signin.php');
        exit;
    }

    $message = "";
    // Create connection

    // query to show the table from db in the button
    $sql = "SELECT `name` FROM tables";
    $result = mysqli_query($conn, $sql);
      while ($res=mysqli_fetch_assoc($result)){
        $finelResults[]=$res;
      }


    // array of the hours for the restaurant table reservations
     $OpeningHours=array("11:00:00","12:00:00","13:00:00","14:00:00","15:00:00","16:00:00","17:00:00","18:00:00","19:00:00","20:00:00","21:00:00","22:00:00","23:00:00");


?>

<html>
    <head>
      
      <link href="https://fonts.googleapis.com/css?family=Assistant" rel="stylesheet">	        
      <link rel="stylesheet" type="text/css" href="stylesheet.css">
      <link rel="stylesheet" type="text/css" href="calendar.css">
        
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css?family=Assistant" rel="stylesheet">
        
        
        
    </head>

    <body>
<div class="container">
  <?php displayMessage(); ?>
        <h1>יומן הזמנות - מסעדת שיפודי התקווה</h1>
        <div class="row">
    <div class="col-lg-9" id="iframeContainer">

    <iframe id="calendarIframe" src="https://calendar.google.com/calendar/embed?src=nv0m9m8g38tjbn0aq2j7bhqcd4%40group.calendar.google.com&ctz=Asia%2FJerusalem" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
</div>   
           <div class="col-lg-3" id="formContainer">

   
<p>לפניך טופס הזמנת שולחן למסעדה מלא את הפרטים בהתאם לבחירתך.</p>
    <div class="form-group"><div><p><label>מועד מבוקש : <input id ="date" type="date" name="date"></label></p></div></div>
   
 <div class="form-group"><p><label> שולחן : </label></p><select name = "tableName" id="tableName" size="1"> 
    <option value="" selected="selected" disabled="disabled"> בחר שולחן</option>
            <?php foreach($finelResults as $finelResult): ?>
                <option value="<?php echo $finelResult['name'] ?>"><?php echo $finelResult['name'] ?></option>
            <?php endforeach; ?>  </select></div>
    
    


 <div class="form-group" id="hoursContainer"><p><label> בחר שעה 
  </label></p><select name="Openhours" id="hours" size="1"> 
    <option value=NULL selected="selected" disabled="disabled"> בחר שעה</option>
            <?php foreach($OpeningHours as $OpeningHours): ?>
                <option value="<?php echo $OpeningHours ?>"><?php echo $OpeningHours ?></option>
            <?php endforeach; ?>  </select></div>
    
  <div class="form-group">
    <label for="phone">פלאפון:</label>
    <br>
    <input id="phone" class="" type="text" name="phone" onclick="">
  </div>

  <div class="form-group">
    <label for="name">שם מלא:</label>
    <br>
    <input id="fullName" class="" type="text" name="name" onclick="">
  </div>
  
    
  <input class="btn btn-primary" type="button" name="submit" value="שלח" onclick="addEvent()">
    </div> 
    
    
    <pre id="content" style="width:75%"></pre>
    
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
      
      function addEvent() {
        var date = $('#date').val();
        var hours = $('#hours').val();
        var tableType = $('#tableName').val(); 
        var phone = $('#phone').val(); 
        var name = $('#fullName').val(); 
        var data;

        if(!date.length || !hours.length || !tableType.length || !phone.length || !name.length ) {
          window.location.href = window.location.pathname + '?errorMessage=כל השדות הם שדות חובה';
          return;
        }

        var data = {
          'tableName': tableType,
          'name': name,
          'phone': phone,
          'dateTime': date + ' ' +hours
        };

        $.ajax({
          url: "add_table_order.php",
          data: data,
          method: 'GET',
          success: function() {
            
            window.location.href = window.location.pathname +'?message=ההזמנה נשמרה בהצלחה';
          }
        });
         
      }

    </script>


<?php include_once 'footer.php'?>


    
    </body>


</html>