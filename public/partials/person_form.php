<?php
// expects $formData, $errors, $submitLabel, $backUrl, $backParams
?>
<form method="post">
    <?= csrf_field() ?>
    <?php if (!empty($backParams)): ?>
        <?php foreach ($backParams as $key => $value): ?>
            <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars((string) $value) ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="form-group col-md-4">
        <label>First Name: <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="first_name" value="<?= htmlspecialchars($formData['first_name'] ?? '') ?>" required>
        <?php if (isset($errors['first_name'])): ?>
            <p class="text-danger"><?= $errors['first_name'] ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group col-md-4">
        <label>Last Name: <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="last_name" value="<?= htmlspecialchars($formData['last_name'] ?? '') ?>" required>
        <?php if (isset($errors['last_name'])): ?>
            <p class="text-danger"><?= $errors['last_name'] ?></p>
        <?php endif; ?>
    </div>

    <div class="form-group col-md-4">
        <label>Nickname:</label>
        <input type="text" class="form-control" name="nickname" value="<?= htmlspecialchars($formData['nickname'] ?? '') ?>">
    </div>

    <?php render_contact_details_form($formData, $errors); ?>
    
    <div class="col-md-12 submit_button">
        <a href="<?= htmlspecialchars($backUrl ?? 'index.php') ?>" class="btn btn-warning col-md-2">Cancel</a>
        <button type="submit" class="btn btn-primary   col-md-2 pull-right"><?= htmlspecialchars($submitLabel ?? 'Save') ?></button>        
    </div>
    
</form>
