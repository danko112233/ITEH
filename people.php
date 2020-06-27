<?php

$con = mysqli_connect('localhost', 'root', '' );
mysqli_select_db($con, 'userregistration');
$query = "select name from usertable where name like '" .$_GET["q"]."%'";
$output = '';
$x=mysqli_query($con, $query);

if (mysqli_num_rows($x) > 0) {
    $output .= '<div class="table-responsive">
                  <table class "table table bordered">
                    <tr>
                      <th> username </th>
                    </tr>';
    while($row = mysqli_fetch_array($x))
    {
      $output .= '
          <tr>
            <td> <a href="finduser.php?profile='.$row["name"].'"> '.$row["name"].' </a> </td>
          </tr>
          ';
    }
    echo $output;
}
else{
  echo 'No user with this username';
}


?>