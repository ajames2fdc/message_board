<!-- app/View/Layouts/default.ctp -->

<!DOCTYPE html>
<html>

<head>
	<title><?= $title_for_layout ?></title>
	<?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css') ?>

	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>

	<!-- Select2 CSS and JS -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

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