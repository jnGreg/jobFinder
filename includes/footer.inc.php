<center>
<div id="clause">
<h6><i>Copyright jobFinder 2022</i> </h6><br>
<a style="margin-right: 25px; color: indigo;" href = "terms.php"> Terms of Services  </a>
<a>authors' page: </a><a style="margin-right: 25px; color: indigo;" href = "https://github.com/jnGreg/jobFinder"> GitHub  </a>
<?php require_once ('includes/config.inc.php'); ?>
<a>scrapped site: </a><a style="color: indigo;" href = "https://justjoin.it/"> JustJoinIT  </a><br><br>
<a style="margin-right: 50px;">Last scrapped: 22-05-2022 1:11 PM </a><a> Offers obtained: <?php $query = $conn->prepare("SELECT * FROM offers;");
														$query->execute();
														$query->store_result();
														$num_offers = $query->num_rows;
														echo $num_offers; ?>
</a><br><br>
</div>
</center>