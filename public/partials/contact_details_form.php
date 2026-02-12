<?php
// expects $formData, $errors
?>

<div class="form-group col-md-8">
    <label>Street:</label>
    <input type="text" class="form-control" name="street" value="<?= esc($formData['street'] ?? '') ?>">
</div>

<div class="form-group col-md-4">
    <label>Number:</label>
    <input type="text" class="form-control" name="number" value="<?= esc($formData['number'] ?? '') ?>" inputmode="numeric" pattern="[0-9]+" title="Numbers only">
</div>

<div class="form-group col-md-5">
    <label>City:</label>
    <input type="text" class="form-control" name="city" value="<?= esc($formData['city'] ?? '') ?>">
</div>

<div class="form-group col-md-3">
    <label>Zip Code: <span class="text-danger">*</span></label>
    <input type="text" class="form-control" name="zip_code" value="<?= esc($formData['zip_code'] ?? '') ?>" required inputmode="numeric" pattern="[0-9]+" title="Numbers only">
    <?php if (isset($errors['zip_code'])): ?>
        <p class="text-danger"><?= $errors['zip_code'] ?></p>
    <?php endif; ?>
</div>

<div class="form-group col-md-4">
    <label>Country:</label>
    <input type="text" class="form-control" name="country" value="<?= esc($formData['country'] ?? '') ?>">
</div>

<div class="form-group col-md-12">
    <label>Email: <span class="text-danger">*</span></label>
    <input type="email" class="form-control" name="email" value="<?= esc(strtolower($formData['email'] ?? '')) ?>" required>
    <?php if (isset($errors['email'])): ?>
        <p class="text-danger"><?= $errors['email'] ?></p>
    <?php endif; ?>
</div>

<div class="form-group col-md-6">
    <label>Phone 1: <span class="text-danger">*</span></label>
    <input type="text" class="form-control" name="phone_1" value="<?= esc($formData['phone_1'] ?? '') ?>" required inputmode="numeric" pattern="[0-9]+" title="Numbers only">
    <?php if (isset($errors['phone_1'])): ?>
        <p class="text-danger"><?= $errors['phone_1'] ?></p>
    <?php endif; ?>
</div>

<div class="form-group col-md-6">
    <label>Phone 2:</label>
    <input type="text" class="form-control" name="phone_2" value="<?= esc($formData['phone_2'] ?? '') ?>" inputmode="numeric" pattern="[0-9]+" title="Numbers only">
    <?php if (isset($errors['phone_2'])): ?>
        <p class="text-danger"><?= $errors['phone_2'] ?></p>
    <?php endif; ?>
</div>
<div class="form-group col-md-6">
    <p class="text-muted"><span class="text-danger">*</span> Required fields</p>
</div>

