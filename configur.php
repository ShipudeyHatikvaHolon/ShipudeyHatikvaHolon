<?php 
$servername = "localhost:3306";
$username = "robiso_robiso";
$password = "rakmaccabi";

$message = '';

$locationRestaurant = 'מסעדת שיפודי התקווה, הפלד 7 חולון';
$emailSite = '';

$dbname = "robiso_hatikva";
// adds  category  contacts order pitas	products sauces tableorders tables users vouchers

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


mysqli_query($conn,"set character_set_client='utf8'");
mysqli_query($conn,"set character_set_results='utf8'");
mysqli_query($conn ,"set collation_connection='utf8'");
mysqli_set_charset($conn,"utf8");
// Check connection
if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
} 

// Display messages about success and errors
function displayMessage() {

    $style = 'style="text-align:center; padding:8px;"';
    $script = 
    '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>' .
    "<script>
        
                var message = $('.message');
                if(message.length) {
                    setTimeout(function() {
                        message.slideUp('fast');
                    }, 5000)
                }

            </script>
            " ;

     if(isset($_GET['message'])){
        echo '<div ' . $style . ' class="bg-success message">' .
          $_GET['message'] .
    '</div>' . $script;
     } elseif(isset($_GET['errorMessage'])) {
        echo '<div ' . $style . ' class="bg-danger message">' .
             $_GET['errorMessage'] .
        '</div>' . $script;
     }
}

function old($field) {
    return isset($_REQUEST[$field]) ? $_REQUEST[$field] : '';
}

?>
