<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

// Include the navigation bar
include('includes/nav.php');
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Points History</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="includes/Cinema.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
<div class="container mt-5">
    <h1 class="mb-4 text-white">Booking History</h1>
    <div class="row">

        <?php
        if (!isset($_SESSION['id'])) {
            echo '<div class="alert alert-warning">Please log in to view your booking history.</div>';
        } else {
            require('connect_db.php');

            $q = "SELECT mb.booking_id, mb.total, mb.booking_date, mc.movie_id, mc.quantity, mc.price, ml.movie_title
                  FROM movie_booking mb
                  JOIN booking_content mc ON mb.booking_id = mc.booking_id
                  JOIN movie_listings ml ON mc.movie_id = ml.movie_id
                  WHERE mb.id = {$_SESSION['id']}
                  ORDER BY mb.booking_date DESC";
            $r = mysqli_query($link, $q);

            if (mysqli_num_rows($r) > 0) {
                while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                    $date = date("d/m/Y", strtotime($row["booking_date"]));
                    $qr_code_image = 'Images/QR_code.png';

                    echo '
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Booking #EC1000' . $row['booking_id'] . '</h5>
                                <p class="card-text"><strong>Movie:</strong> ' . $row['movie_title'] . ' (x' . $row['quantity'] . ')</p>
                                <p class="card-text"><strong>Total Paid:</strong> £' . $row['total'] . '</p>
                                <p class="card-text"><strong>Date:</strong> ' . $date . '</p>
                                <img src="' . $qr_code_image . '" alt="QR Code" class="img-fluid mt-2">
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<div class="alert alert-info">You have no booking history yet.</div>';
            }

            mysqli_close($link);
        }
        ?>

    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

</body>

<?php include('includes/footer.php'); ?>

</html>
