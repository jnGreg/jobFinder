<center>
<div id="clause">
<h6><i>Copyright jobFinder 2022</i> </h6><br>
<a style="margin-right: 25px; color: indigo;" href = "terms.php"> Terms of Services  </a>
<a>authors' page: </a><a style="margin-right: 25px; color: indigo;" href = "https://github.com/jnGreg/jobFinder"> GitHub  </a>
<?php require_once ('includes/config.inc.php'); ?>
<a>scrapped site: </a><a style="color: indigo;" href = "https://justjoin.it/"> JustJoinIT  </a><br><br>
<a style="margin-right: 18px;">Last scrapped: <?php $query_last = "SELECT * FROM crawler_status ORDER BY time_parsed DESC LIMIT 1;";
										$results_last = mysqli_query($conn, $query_last); 
										while($row = mysqli_fetch_array($results_last)) {
										$last = $row['time_parsed'];
										$num_offers = $row['active_len'];
										echo $last . '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspOffers obtained: ' . $num_offers; }?> </a><br><br><br>
</div>
</center>
