<?php
$imagesArr = json_decode($contentdetails['image'],true);

?>
<main class="mainContainer">
<section class="section seller-dashboard">
<div class="container">
<div class="d-flex tab-head-sec flex-wrap mb30">
<div>
<h2 class="heading"><?php echo $contentdetails['title']?></h2> 
</div>
<div class="d-block w-100">
<div class="dashboard-wrap mt30">
<?php
if($imagesArr[0] !='')
{
?><figure>
<img src="<?php echo base_url();?>uploads/images_extra/<?php echo $imagesArr[0];?>" alt="">
</figure>
<?php
}
?>

<?php echo $contentdetails['description']?>
<p>Contributed By: <?php echo $contentdetails['author']?></p>
</div>
</div>
</div>
</div>
</section>
</main>