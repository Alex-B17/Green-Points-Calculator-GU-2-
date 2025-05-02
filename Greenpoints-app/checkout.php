<?php # DISPLAY COMPLETE REGISTRATION PAGE.
# Access session.
session_start() ; 
# Redirect if not logged in.
if ( !isset( $_SESSION[ 'id' ] ) ) { require ( 'login_tools.php' ) ; load() ; }


# Check for passed total and cart.
if ( isset( $_GET['total'] ) && ( $_GET['total'] > 0 ) && (!empty($_SESSION['cart']) ) )
{
  # Open database connection.
  require ('connect_db.php');
  
  # Ticket reservation and total in 'bookings' database table.
  $q = "INSERT INTO movie_booking ( id, total, booking_date ) VALUES (". $_SESSION['id'].",".$_GET['total'].", NOW() ) ";
  $r = mysqli_query ($link, $q);
  
  # Retrieve current booking number.
  $booking_id = mysqli_insert_id($link) ;
  
  # Retrieve cart items from 'movie' database table.
  $q = "SELECT * FROM movie_listings WHERE movie_id IN (";
  foreach ($_SESSION['cart'] as $id => $value) { $q .= $id . ','; }
  $q = substr( $q, 0, -1 ) . ') ORDER BY movie_id ASC';
  $r = mysqli_query ($link, $q);

   # Store order contents in 'booking_contents' database table.
  while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC))
  {
    $query = "INSERT INTO booking_content
	( booking_id, movie_id, quantity, price )
    VALUES ( $booking_id, ".$row['movie_id'].",".$_SESSION['cart'][$row['movie_id']]['quantity'].",".$_SESSION['cart'][$row['movie_id']]['price'].")" ;
    $result = mysqli_query($link,$query);
  }
  
  # Close database connection.
  #mysqli_close($link);
  
  
  
	# Display order number.
	echo '
<div class="container">
	
	';
  # Remove cart items.  
  $_SESSION['cart'] = NULL ;
}
# Or display a message.
else { echo '<p></p>' ; }


# Open database connection.
#require ( 'includes/connect_db.php' ) ;
 
# Retrieve items from 'bookings' database table.
$q = "SELECT * FROM movie_booking WHERE id={$_SESSION[id]}
ORDER BY booking_date DESC
LIMIT 1" ;


$r = mysqli_query( $link, $q ) ;
if ( mysqli_num_rows( $r ) > 0 )
{
  
  echo '<img width="256" class="img-fluid" alt="QR Code " src="img/qrcode.png">
			  
			 
				
				';

  while ( $row = mysqli_fetch_array( $r, MYSQLI_ASSOC ))
  {
	  $date= $row["booking_date"];
	  $day = substr($date, 8,2);
	  $month = substr($date, 5,2);
	  $year = substr($date, 0,4);
    echo '
		<p>Booking Reference:  #EC1000' . $row['booking_id'] . '</p> 
		<p>Total Paid:   &pound ' . $row['total'] . ' </p>
		<p>' . $day . '/' . $month . '/' . $year . '.  <p>
				
';
  }
	
  # Close database connection.
  mysqli_close( $link ) ; 
}


?>

