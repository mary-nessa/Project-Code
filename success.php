<!DOCTYPE html>
<html>
<head>
    <title>Payment Success</title>
    <style>
        /* CSS styling for the success page */
        body {
            background-image: url('/Applications/XAMPP/xamppfiles/htdocs/YOBUS1-main/Project Code/payments.jpg');
            background-size: cover;
            text-align: center;
            color: white;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            font-size: 24px;
        }

        p {
            font-size: 18px;
        }

        .button {
            background-color: #008CBA;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 2px;
            cursor: pointer;
            border: none;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <section class="sub-header">
        <nav>
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

    <section class="ticketdetails">
        <div class="container">
            <h1>Payment Success</h1>
            <p>Your payment was successful. Here are the details:</p>

            <?php
            if (isset($_POST['complete_payment'])) {
                $externalId = ''; // Retrieve the external ID from the API response in makepayment.php
                $amount = $_POST['amount']; // Retrieve the amount from the form in this page
                $currency = 'EUR'; // Set the currency
                $phone = $_POST['phone']; // Retrieve the phone number from the form in this page

                echo "<p>External ID: $externalId</p>";
                echo "<p>Amount: $amount $currency</p>";
                echo "<p>Phone Number: $phone</p>";
            }
            ?>
            
            <a href="ticketdetails.php" class="button">Complete Details</a>
        </div>
    </section>

    <?php include 'footer.php'; ?>

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
