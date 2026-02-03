<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle ?? 'Address Book') ?></title>

    <!-- Bootstrap 3 (CDN) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-main" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Address Book</a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-main">
                <ul class="nav navbar-nav">
                    <li class="<?= ($activePage ?? '') === 'index' ? 'active' : '' ?>"><a href="index.php">Home</a></li>
                    <li class="<?= ($activePage ?? '') === 'create' ? 'active' : '' ?>"><a href="create.php">Add New Person</a></li>
                </ul>
                <?php if (!empty($showSearch)): ?>
                    <form class="navbar-form navbar-left pull-right" method="get" action="" role="search">
                        <input type="hidden" name="sort" value="<?= htmlspecialchars($sort ?? '') ?>">
                        <input type="hidden" name="dir" value="<?= htmlspecialchars($dir ?? '') ?>">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" value="<?= htmlspecialchars($search ?? '') ?>" placeholder="Search by name, email, city...">
                                <?php if (!empty($search)): ?>
                                    <span class="input-group-btn">
                                        <button
                                            type="button"
                                            class="btn btn-default"
                                            title="Clear"
                                            onclick="this.form.search.value=''; this.form.submit();"
                                        >&times;</button>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-warning">Search</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </nav>
