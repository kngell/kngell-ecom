<?php declare(strict_types=1);
require_once 'inc/EmailTemplate/header.php'; ?>
<!----------------Body----------------------->
<?= $this->content('body'); ?>
<!----------------xBody---------------------->
<?php require_once 'inc/EmailTemplate/footer.php';