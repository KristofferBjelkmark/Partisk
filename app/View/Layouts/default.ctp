<?php
/** 
 * Default layout
 *
 * Partisk : Political Party Opinion Visualizer
 * Copyright (c) Partisk.nu Team (https://www.partisk.nu)
 *
 * Partisk is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Partisk is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Partisk. If not, see http://www.gnu.org/licenses/.
 *
 * @copyright   Copyright (c) Partisk.nu Team (https://www.partisk.nu)
 * @link        https://www.partisk.nu
 * @package     app.View.Layouts
 * @license     http://www.gnu.org/licenses/ GPLv2
 */
?>

<!DOCTYPE html>
<html>
	<head>
		<?php echo $this->Html->charset(); ?>
		<title>
			Partisk.nu (Testversion) - 
			<?php echo $title_for_layout; ?>
		</title>

		<script type="text/javascript">
			var appRoot = "<?php echo Router::url('/', false); ?>"; 
		</script>
		
		<?php
			echo $this->Html->meta('icon');

			echo $this->Html->css('bootstrap.min');
			echo $this->Html->css('font-awesome.min');
			echo $this->Html->css('nv.d3');
			echo $this->Html->css('datepicker');
			echo $this->Html->css('style');
			echo $this->Html->script('jquery');
			echo $this->Html->script('bootstrap');
			echo $this->Html->script('bootstrap-datepicker');
			echo $this->Html->script('bootstrap-datepicker.sv.js', false);
			echo $this->Html->script('d3.v2');
			echo $this->Html->script('nv.d3');
			echo $this->Html->script('partisk');

			echo $this->fetch('meta');
			echo $this->fetch('css');
			echo $this->fetch('script');
		?>
	</head>
	<body>
		<nav class="navbar navbar-default" role="navigation">
	      	<div class="navbar-header">
	      	  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
	      	    <span class="sr-only">Toggle navigation</span>
	      	    <span class="icon-bar"></span>
	      	    <span class="icon-bar"></span>
	      	    <span class="icon-bar"></span>
	      	  </button>
	      	  <?php echo $this->Html->link('<i class="fa fa-check-square"></i>Partisk.nu', array('controller' => 'pages', 'action' => 'index'), 
	      	  					array('class' => 'navbar-brand', 'escape' => false)); ?>
	      	</div>
	      	<div class="collapse navbar-collapse navbar-ex1-collapse">
	      	  <ul class="nav navbar-nav navbar-left">
	      	    <li><?php echo $this->Html->link('<i class="fa fa-thumbs-o-up"></i> Frågor och svar', array('controller' => 'questions', 'action' => 'index'), array('escape' => false, 'class' => $currentPage == "questions" ? 'active' : '')); ?></li>
	      	    <li><?php echo $this->Html->link('<i class="fa fa-tags"></i> Taggar', array('controller' => 'tags', 'action' => 'index'), array('escape' => false, 'class' => $currentPage == "tags" ? 'active' : '')); ?></li>
	      	    <li><?php echo $this->Html->link('<i class="fa fa-globe"></i> Partier', array('controller' => 'parties', 'action' => 'index'), array('escape' => false, 'class' => $currentPage == "parties" ? 'active' : '')); ?></li>
	      	    <li><?php echo $this->Html->link('<i class="fa fa-check-square-o"></i> Quiz', array('controller' => 'quiz', 'action' => 'index'), array('escape' => false, 'class' => $currentPage == "quiz" ? 'active' : '')); ?></li>
	      	  </ul>
		  <ul class="nav navbar-nav navbar-right">
			<li><?php echo $this->Html->link('<i class="fa fa-info-circle"></i> Om sidan', array('controller' => 'pages', 'action' => 'about'), 
								array('escape' => false, 'class' => $currentPage == "about" ? 'active' : '')); ?></li>
			<li><?php echo $this->Html->link('<i class="fa fa-envelope"></i> Kontakt', array('controller' => 'pages', 'action' => 'contact'), 
								array('escape' => false, 'class' => $currentPage == "contact" ? 'active' : '')); ?></li>
		    <?php if (isset($current_user)) { ?>
		    <li><?php echo $this->Html->link('<i class="fa fa-group"></i> Användare', array('controller' => 'users', 'action' => 'index'), 
		    								array('escape' => false)); ?></li>
	      	<li><?php echo $this->Html->link('<i class="fa fa-user"></i> ' . $current_user['username'], 
	      									array('controller' => 'users', 'action' => 'view', $current_user['id']), 
	      									array('escape' => false)); ?></li>
		    <li><?php echo $this->Html->link('<i class="fa fa-sign-out"></i> Logga ut', array('controller' => 'users', 'action' => 'logout'), 
		    								array('escape' => false)); ?></li>
		    <?php } else { ?>
		    <li><?php echo $this->Html->link('<i class="fa fa-sign-in"></i> Logga in', array('controller' => 'users', 'action' => 'login'), array('escape' => false, 'class' => $currentPage == "login" ? 'active' : '')); ?></li>
		    <?php } ?>
		  </ul>
	      	</div><!-- /.navbar-collapse -->
	      </nav>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php echo $this->Html->getCrumbList(array('class' => 'breadcrumb'), 'Hem'); ?>
					<?php echo $this->Session->flash(); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?php echo $this->fetch('content'); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
				<?php if (Configure::read('debug') >= 2) { ?>
				<div class="alert alert-info">
					<?php echo $this->element('sql_dump'); ?>
				</div>
				<?php } ?>
				</div>
			</div>
		</div>
		<div id="footer">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<p><i class="fa fa-check-square"></i> Partisk.nu är skapad av <a href="http://www.linkedin.com/in/rasmushaglund">Rasmus 	Haglund</a> 2013.
							</p>
						</div>
					</div>
				</div>
			</div>
		<?php echo $this->element('feedback'); ?>
	</body>
</html>