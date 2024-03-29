<!-- app/View/Layouts/default.ctp -->

<!DOCTYPE html>
<html>

<head>
	<title><?= $title_for_layout ?></title>
	<?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css') ?>

	<!-- jQuery -->
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<!-- Select2 CSS and JS -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

	<!-- Custom Css -->
	<?php
	echo $this->fetch('css');
	echo $this->fetch('script');
	echo $this->Html->css('styles');
	echo $this->Html->css('flash');
	echo $this->Html->css('conversations');
	?>
</head>

<body>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

	<?= $this->element('navbar', array('loggedIn' => $loggedIn)) ?>

	<div class="container mt-3">
		<?= $this->Flash->render() ?>
		<?= $this->fetch('content') ?>
	</div>
</body>

</html>