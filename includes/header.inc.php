<nav class ="navbar navbar-light bg-success navbar-expand-lg">

			<a class="navbar-brand" href="index.php" ><h2 style="font-family: 'Garamond', cursive; font-size: 4.5rem; font-weight: 300; color: #003CB3;">jobFinder</h2> </a>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu_glowne" aria-controls="menu_glowne" aria-expanded="false" aria-label="przelacznik_nawigacji"> 
				<span class="navbar-toggler-icon"> </span>
			</button>

			<div class="collapse navbar-collapse" id="menu_glowne">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link" href="#" style="margin-right:25px;">
							Visualisations
						</a>
					</li>
				<?php 
				if (isset ($_SESSION["userid"])) { ?>
					<li class="nav-item dropdown" style="margin-right:25px;">
					<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button"
						 aria-expanded="false" id="submenu" aria-haspopup="true">
							<?php echo $_SESSION["username"];?>
						</a>
						<div class="dropdown-menu" aria-labeledby="submenu">
						<a class="dropdown-item" href="watched.php?view=list">
							Watched
						</a>
						<a class="dropdown-item" href="account_settings.php" >
							Account Settings
						</a>
						<a class="dropdown-item" href="includes/logout.inc.php" >
							Sign Out </a></div>
					</li>
				<?php }

				else { ?>
					<li class="nav-item">
						<a class="nav-link" href="login.php">
							Sign In
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="register.php">
							Sign Up
						</a>
					</li>
					<?php
				}

				?>	
				</ul>
			</div>
		</nav>