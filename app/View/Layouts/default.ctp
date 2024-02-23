<!-- app/View/Layouts/default.ctp -->

<!DOCTYPE html>
<html>

<head>
	<title><?= $title_for_layout ?></title>
	<?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css') ?>
	<?php echo $this->Html->script('https://code.jquery.com/ui/1.12.1/jquery-ui.js') ?>
	<?php echo $this->Html->css('https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css') ?>
	<?= $this->Html->css('styles.css') ?> <!-- Add a custom CSS file for additional styles -->
	<!-- Other head elements -->
</head>

<body>

	<?= $this->element('navbar', array('loggedIn' => $loggedIn)) ?>

	<div class="container mt-3">
		<?= $this->Flash->render() ?>
		<?= $this->fetch('content') ?>
	</div>

	<?php echo $this->element('sql_dump'); ?>
	<!-- Scripts -->
	<?= $this->Html->script('https://code.jquery.com/jquery-3.6.0.slim.min.js') ?>
	<?= $this->Html->script('https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js') ?>
</body>

</html>