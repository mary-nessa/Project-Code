<?php
// INCLUDE ACCESS TOKEN
include "createaccesstoken.php";

// Check if the form is submitted
if (isset($_POST['complete_payment'])) {
    // Get phone number and amount from the form
    $phone = $_POST['phone'];
    $amount = $_POST['amount'];

    // Set the request URL
    $url = "https://sandbox.momodeveloper.mtn.com/collection/v1_0/requesttopay";
    // Set the headers
    $headers = array(
        'Authorization: Bearer ' . $access_token,
        'X-Reference-Id: ' . $reference_id,
        'X-Target-Environment: sandbox',
        'Content-Type: application/json',
        'Ocp-Apim-Subscription-Key: ' . $secodary_key
    );

    // Generate an 8-digit external ID
    $external_id = rand(10000000, 99999999);

    // Set the request body using user input
    $body = array(
        'amount' => $amount,       // Use the amount from the form
        'currency' => 'EUR',
        'externalId' => $external_id,
        'payer' => array(
            'partyIdType' => 'MSISDN',
            'partyId' => $phone   // Use the phone number from the form
        ),
        'payerMessage' => 'YoBus Services Ticket Payment',
        'payeeNote' => 'Thank you for using YoBus'
    );
    // Encode the request body as JSON
    $json_body = json_encode($body);
    // Initialize cURL
    $curl = curl_init();
    // Set the cURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => $json_body
    ));
    // Execute the cURL request
    $response = curl_exec($curl);
    // Check for errors
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
        echo "cURL Error: " . $error_msg;
    } else {
        // Process the API response here (check status code, display success or error message)
    }
    // Close the cURL session
    curl_close($curl);
}
?>

<?php include 'header.php'; ?>

<body>
    <?php
    session_start();
    if (!(isset($_SESSION['UserId']) && !empty($_SESSION['UserId']))) {
        header("Location:login.html");
    }
    ?>
    <section class="sub-header">
        <nav> <br>
            <div class="nav-link" id="menu">
                <i class="fas fa-times" onclick="hidemenu()" style="margin-left: 10px; margin-top: 6px;"></i>
                <ul>
                    <li><a href="home.php">HOME</a></li>
                    <li><a href="About.php">ABOUT</a></li>
                    <li><a href="Booking.php">BOOKING</a></li>
                    <li><a href="MyReservation.php">MY RESERVATION</a></li>
                    <li><a href="Contact.php">CONTACT</a></li>
                    <li><a href="logout.php">LOGOUT</a></li>
                </ul>
            </div>
            <i class="fas fa-bars" onclick="showmenu()"></i>
        </nav>
    </section>

    <!-------- Contact -------->

    <section class="ticketdetails">
        <div class="container">
            <h4 class="heading">Payment Details</h4>
            <div
                class="form"
            >
                <div class="content">
                    <form action="success.php" method="post">
                        <label
                            for="phone"
                        >
                            Phone Number:<span>*</span>
                        </label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            required
                        />
                        <label
                            for="amount"
                        >
                            Enter Amount:<span>*</span>
                        </label>
                        <input
                            type="text"
                            id="amount"
                            name="amount"
                            required
                        />

                        <h5
                            class="fees-heading"
                        >
                            Fees
                        </h5>
                        <div
                            class="fees"
                        >
                            <div
                                class="transport-fee"
                            >
                                <?php
                                include 'DBConnect.php';

                                $selectquery = "SELECT * FROM Reservation JOIN Schedule on schedule.ScheduleId = Reservation.ScheduleId WHERE reservation.userId = " . $_SESSION['UserId'];

                                $query = mysqli_query($myconn, $selectquery);

                                $nums = mysqli_num_rows($query);

                                while ($res = mysqli_fetch_array($query)) {
                                ?>
                                    <div
                                        class="transport-fee"
                                    >
                                        <p>
                                            Total: <?php echo $res['Fare'] + 1800 ?>
                                        </p>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <input
                            type="submit"
                            name="complete_payment"
                            value="Complete Payment"
                        />
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <!-------- Javascript -------->

    <script>
        function showmenu() {
            var c = document.getElementById("menu");
            c.style.right = "0";
        }

        function hidemenu() {
            var c = document.getElementById("menu");
            c.style.right = "-200px";
        }
    </script>
</body>

</html>
