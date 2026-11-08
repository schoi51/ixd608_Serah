<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Checkout</title>
    <?php include "parts/meta.php"; ?>
</head>
<body>

    <?php include "parts/navbar.php"; ?>

    <div class="container">
        <div class="card soft">
            <h2>Product Checkout</h2>

            <form action="confirmation.php" method="POST">
                
                <!-- 1. Address Section -->
                <h3 style="margin-top: 20px; margin-bottom: 15px;">Address</h3>
                
                <div class="form-control">
                    <label class="form-label">Street</label>
                    <input class="form-input" type="text" name="street" placeholder="Street name" required>
                </div>

                <div class="form-grid" style="display: flex; gap: 20px;">
                    <div class="form-control" style="flex: 1;">
                        <label class="form-label">City</label>
                        <input class="form-input" type="text" name="city" placeholder="City" required>
                    </div>
                    <div class="form-control" style="flex: 1;">
                        <label class="form-label">State</label>
                        <input class="form-input" type="text" name="state" placeholder="State" required>
                    </div>
                </div>

                <div class="form-grid" style="display: flex; gap: 20px;">
                    <div class="form-control" style="flex: 1;">
                        <label class="form-label">Zip Code</label>
                        <input class="form-input" type="text" name="zip" placeholder="Zip Code" required>
                    </div>
                    <div class="form-control" style="flex: 1;">
                        <label class="form-label">Country</label>
                        <input class="form-input" type="text" name="country" placeholder="Country" required>
                    </div>
                </div>

                <!-- 2. Payment Section -->
                <h3 style="margin-top: 30px; margin-bottom: 15px;">Payment</h3>

                <div class="form-control">
                    <label class="form-label">Full Name</label>
                    <input class="form-input" type="text" name="card_name" placeholder="Name" required>
                </div>

                <div class="form-control">
                    <label class="form-label">Card Number</label>
                    <input class="form-input" type="text" name="card_number" placeholder="####-####-####-####" required>
                </div>

                <div class="form-grid" style="display: flex; gap: 20px;">
                    <div class="form-control" style="flex: 1;">
                        <label class="form-label">Expiration</label>
                        <input class="form-input" type="text" name="expiration" placeholder="MM-YY" required>
                    </div>
                    <div class="form-control" style="flex: 1;">
                        <label class="form-label">CVV</label>
                        <input class="form-input" type="text" name="cvv" placeholder="CVV" required>
                    </div>
                </div>

                <div class="form-control">
                    <label class="form-label">Zip Code</label>
                    <input class="form-input" type="text" name="billing_zip" placeholder="Zip Code" required>
                </div>

                <!-- 3. Complete Checkout Button -->
                <div class="form-control" style="margin-top: 30px;">
                    <button type="submit" class="form-button" style="width: 100%; text-align: center;">Complete Checkout</button>
                </div>

            </form>
        </div>
    </div>

    <?php include "parts/footer.php"; ?>

</body>
</html>