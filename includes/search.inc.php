<form class="form-inline" method="GET" action="search.php">
						<input hidden name = "view" value = "<?php if(isset($_GET['view'])) { echo $_GET['view']; } else { echo "list"; }?>">
						<input class="form-control mr-1" type="search" placeholder="Keywords..." aria-label="wyszukaj" id = "item" name = "k" autocomplete="off" style="width:500px;" maxlength=75 minlength=3 required> 
						<div class="form-group" style="padding-left: 5px;"> 
						<select class="form-control" id="voivodeship" name="voivodeship" style="width:175px;">
							<option value="" selected>Poland...</option>
						<?php 
							$sql = "SELECT * FROM voivodeships;";
							$result = mysqli_query($conn, $sql);
								while($row = mysqli_fetch_array($result)){ 
									?><option value="<?php echo $row["voivodeship_id"];?>"><?php echo $row["voivodeship"];?></option><?php
								}	
						?>
						</select></div><div class="form-group" style="padding-left: 5px;"> 
						<select class="form-control" id="city" name="city" style="width:175px;"> 
						<option value="" disabled selected>City...</option>
							
						</select></div>
						<div style="padding-left: 10px;">
						<button class="btn btn-success" type="submit">Search </button> </div>
						</form>