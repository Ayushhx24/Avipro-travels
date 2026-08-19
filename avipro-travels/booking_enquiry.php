<?php 
require_once('config/db.php');
$prefilled_destination = $_GET['destination'] ?? ''; 
?>

<?php include('admin/includes/header.php'); ?>

    <h1>Travel Package Booking & Enquiry</h1>
    <p>Fill out the details below, and our travel expert will contact you within 24 hours.</p>

    <div id="form-message" style="margin-bottom: 20px; padding: 10px; border-radius: 5px;"></div>

    <form id="bookingForm" method="post" action="process_booking.php" style="max-width: 500px; margin: auto;">
        
        <div>
            <label for="name">Your Full Name *</label>
            <input type="text" id="name" name="name" required>
            <span class="validation-error" id="name-error"></span>
        </div>
        
        <div>
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" required>
            <span class="validation-error" id="email-error"></span>
        </div>
        
        <div>
            <label for="phone">Phone Number *</label>
            <input type="tel" id="phone" name="phone" required>
            <span class="validation-error" id="phone-error"></span>
        </div>
        
        <div>
            <label for="destination">Destination/Package Interested In *</label>
            <input type="text" id="destination" name="destination" value="<?php echo htmlspecialchars($prefilled_destination); ?>" required>
            <span class="validation-error" id="destination-error"></span>
        </div>
        
        <div>
            <label for="travel_date">Tentative Travel Date *</label>
            <input type="date" id="travel_date" name="travel_date" required>
            <span class="validation-error" id="travel_date-error"></span>
        </div>
        
        <div>
            <label for="num_persons">Number of Persons *</label>
            <input type="number" id="num_persons" name="num_persons" min="1" value="1" required>
            <span class="validation-error" id="num_persons-error"></span>
        </div>
        
        <div>
            <label for="message">Your Message/Specific Requests</label>
            <textarea id="message" name="message" rows="4"></textarea>
            <span class="validation-error" id="message-error"></span>
        </div>
        
        <button type="submit" id="submitBtn" style="margin-top: 15px;">Send Enquiry</button>
    </form>

<?php include('admin/includes/footer.php'); ?>

<script src="assets/js/form_handler.js"></script>