<?php
// expects $formData, $errors
?>

<h3>Contact Details</h3>

<div class="form-group">
    <label>Street:</label>
    <input type="text" class="form-control" name="street" value="<?= htmlspecialchars($formData['street'] ?? '') ?>">
</div>

<div class="form-group">
    <label>Number:</label>
    <input type="text" class="form-control" name="number" value="<?= htmlspecialchars($formData['number'] ?? '') ?>" inputmode="numeric" pattern="[0-9]+" title="Numbers only">
</div>

<div class="form-group">
    <label>City:</label>
    <input type="text" class="form-control" name="city" value="<?= htmlspecialchars($formData['city'] ?? '') ?>">
</div>

<div class="form-group">
    <label>Zip Code: <span class="text-danger">*</span></label>
    <input type="text" class="form-control" name="zip_code" value="<?= htmlspecialchars($formData['zip_code'] ?? '') ?>" required inputmode="numeric" pattern="[0-9]+" title="Numbers only">
    <?php if (isset($errors['zip_code'])): ?>
        <p class="text-danger"><?= $errors['zip_code'] ?></p>
    <?php endif; ?>
</div>

<div class="form-group">
    <label>Country:</label>
    <input type="text" class="form-control" name="country" value="<?= htmlspecialchars($formData['country'] ?? '') ?>">
</div>

<div class="form-group">
    <label>Email: <span class="text-danger">*</span></label>
    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars(strtolower($formData['email'] ?? '')) ?>" required>
    <?php if (isset($errors['email'])): ?>
        <p class="text-danger"><?= $errors['email'] ?></p>
    <?php endif; ?>
</div>

<div class="form-group">
    <label>Phone 1: <span class="text-danger">*</span></label>
    <input type="text" class="form-control" name="phone_1" value="<?= htmlspecialchars($formData['phone_1'] ?? '') ?>" required inputmode="numeric" pattern="[0-9]+" title="Numbers only">
    <?php if (isset($errors['phone_1'])): ?>
        <p class="text-danger"><?= $errors['phone_1'] ?></p>
    <?php endif; ?>
</div>

<div class="form-group">
    <label>Phone 2:</label>
    <input type="text" class="form-control" name="phone_2" value="<?= htmlspecialchars($formData['phone_2'] ?? '') ?>" inputmode="numeric" pattern="[0-9]+" title="Numbers only">
    <?php if (isset($errors['phone_2'])): ?>
        <p class="text-danger"><?= $errors['phone_2'] ?></p>
    <?php endif; ?>
</div>
