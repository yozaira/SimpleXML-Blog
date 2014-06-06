<?php  
// This script uses PHP SimpleXML extension to access the element of a XML file and output the value of those elements.
include_once 'includes/header.php';   ?> 

<div class="container"><!--  ends on includes/footer.php -->
  <div class="row">
   <div class="col-lg-12">		
	  <div id="accordion">	
		    <?php			
			libxml_use_internal_errors(true);
			$objXML = simplexml_load_file('articles.xml');
			// print_r($objXML->article->title);   // for testing

			if (!$objXML) {
			   $errors = libxml_get_errors();
			   foreach($errors as $error)  {
			     echo 'ERROR: ' .$error->message,'<br/>';
			   }
			}
			else {
			     foreach($objXML->article as $article) {										 
		       ?>
			<div class="heading" >
			<div class="title"><?php echo $article->title; ?></dsiv>
			</div>
			<div class="content">
			<p>	
			<?php 
			  echo '<p><img  alt="" src=" '.$article->image.' " class="img-responsive"/></p>';  
			  echo '<p>' .$article->content->firstParagraph .'</p>'; 
			  echo '<p>' .$article->content->secondParagraph .'</p>'; 
			  echo '<p>' .$article->content->thirdParagraph .'</p>'; 									  
			?>	
			</p>
			</div>

			<?php	
			  }
			} 
		      ?>											              
	  </div>			
  </div>
</div>
<?php include_once 'includes/footer.php'; ?>


