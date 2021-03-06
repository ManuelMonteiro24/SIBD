<?php
  require_once('sql_funcs.php');
  session_start();
  if(isset($_POST['patient_name'])){
      $_SESSION['try_name'] = $_POST['patient_name'];
  }
?>
<html>
    <head>
        <title>SIBD project part 3</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css" >
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    </head>
    <body>

      <div class="center_ct">
        <div class ="center">
            <?php
                $connection = null;
                new_connection($connection);

                $sql =  "SELECT * FROM patient WHERE name like :patient_name ORDER BY name";
                $result = sql_secure_query($connection,  $sql , Array(":patient_name" =>  '%'.$_SESSION['try_name'].'%' ) );
                $connection = null;

                $nrows = $result->rowCount();

                if ($nrows == 0)
                    echo("<p class=\"alert alert-warning\">There is no registed patient with the name:  {$_SESSION['try_name']} .</p>");

                else{
                  echo ("<h3>Select Patient</h3>");

                  if( $nrows == 1)
                    echo ("<p class=\"alert alert-info\"> 1 match found for <b>".$_SESSION['try_name']."</b></p>");
                  else
                    echo ("<p class=\"alert alert-info\"> ".$nrows." matches found for <b>".$_SESSION['try_name']."</b></p>");

                    echo("<table class=\"table table-striped table-bordered\"> ");
                    echo("<tr><td>patient_id</td><td>name</td><td>birthday</td><td>address</td></tr>");

                    foreach($result as $row){
                        echo("<tr><td>" . $row['patient_id']  . "</td>" );
                        echo("<td>"     . $row['name']        . "</td>" );
                        echo("<td>"     . $row['birthday']    . "</td>" );
                        echo("<td>"     . $row['address']     . "</td>" );
                        echo("<td><a href=\"newappointment.php?patient_id=" . $row['patient_id'] ."&patient_name=".$row['name']."\">" );
                        echo("<span class=\"glyphicon glyphicon-search\" aria-hidden=\"true\"></span>Schedule appointment</a> </td>");
                        echo("</tr>");
                    }

                    echo("</table>");
                }
            ?>
            <p><a href="insert_patient_data.php">Register new patient</a></p>
            <p><a href="patient_regist.php">Check the patients registed</a></p>
            <p><a href="session_end.php" class=" btn btn-danger">Cancel</a></p>
        </div>
      </div>

</html>
