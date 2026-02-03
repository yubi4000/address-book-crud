<?php
// expects $formData, $errors, $submitLabel
?>
<form method="post">
    <?= csrf_field() ?>

    <div class="form-group">
        <label>First Name: <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="first_name" value="<?= htmlspecialchars($formData['first_name'] ?? '') ?>" required>
        <?php if (isset($errors['first_name'])): ?>
            <p class="text-danger"><?= $errors['first_name'] ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Last Name: <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="last_name" value="<?= htmlspecialchars($formData['last_name'] ?? '') ?>" required>
        <?php if (isset($errors['last_name'])): ?>
            <p class="text-danger"><?= $errors['last_name'] ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Nickname:</label>
        <input type="text" class="form-control" name="nickname" value="<?= htmlspecialchars($formData['nickname'] ?? '') ?>">
    </div>

    <?php render_contact_details_form($formData, $errors); ?>

    <button type="submit" class="btn btn-warning"><?= htmlspecialchars($submitLabel ?? 'Save') ?></button>
    <a href="index.php" class="btn btn-default">Back to list</a>
</form>
