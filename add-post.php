<?php  include_once 'add-post-process.php';  ?>  
<?php  include_once 'includes/header.php';   ?>  

<div class="container">
  <div class="row">
   <div class=" col-sm-10">

	<div class="alert alert-info"><h2>Add a New Post</h2></div>
	<!-- Display error msg-->			

	 <?php if (!empty($message)) {echo '<p class="msg">' . $message . '</p>';} ?>			
	 <?php if (!empty($errors)) { ?>
	           <div class="alert alert-danger"><?php  display_errors($errors);  ?></div>			 
	 <?php } ?>	
	 
	<!-- enctype="multipart/form-data" attributes givse HTML the power to search the users local disk with the 'Browse' button.-->
	<form action="" method="post" enctype="multipart/form-data" role="form"  class="myform" >
	<!-- PHP abandons the upload if the file is bigger than the stipulated value, avoiding unnecessary delay if the file is too big. -->
	<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" >      
	
	<div class="control-group">
	 <label>Title:</label>
	 <input type="text" name="title" size="55" class="form-control"  value="<?php if(isset($_POST['title']) ) {echo $_POST['title']; }?>" />
	</div>
	<!-- 
	There is no image data to enter in the form, since the data in image element will come from 
	the name of the image submited using $_FILES['image']['name']-->
	<div class="control-group">
	 <label>Upload new image:</label>			   
	 <!-- //the input type, 'file', which takes the file and passes it to the server, in a temporary place. -->
	 <input  type="file" name="image" value="<?php if(isset($_POST['image']) ) {echo $_POST['image']; } ?>"  id="image">
	 <span><small>Acceptable image formats: gif, pjpeg, jpg/jpeg, and png.</small></span> 
	</div>

									
	<div class="alert alert-info">
	 <label>Write the Content of your Article:</label>
	 <span><small> ( bold tags and links can be included ) </small></span>
	</div>

	<div class="control-group"> 
	 <label>Paragraph 1:</label>
	 <textarea class="form-control" rows="7"  name="first-para" value=""><?php if(isset($_POST['first-para']) ) { echo $_POST['first-para']; } ?></textarea>
	</div>

	<div class="control-group">
	 <label>Paragraph 2:</label>
	 <textarea name="second-para" class="form-control"  rows="7"    value=""><?php if(isset($_POST['second-para']) ) {echo $_POST['second-para']; } ?></textarea>

	</div>

	<div class="form-group">
	 <label>Paragraph 3:</label>
	 <span><small>( This paragraph is optional ) </small></span>
	 <textarea name="third-para"   class="form-control"  rows="7"  value=""><?php if(isset($_POST['third-para']) ) { echo $_POST['third-para']; } ?></textarea>
	</div>
	 <input type="submit" name="submit" value="Submit Post" class="btn btn-primary btn-lg"> <br/>       
	</form>	            

  </div>
</div>
<?php include_once 'includes/footer.php'; ?>
