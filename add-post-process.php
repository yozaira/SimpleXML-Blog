<?php           
require_once 'includes/form_functions.inc.php';  

  if (isset($_POST['submit']) ) {  

  $errors = array();  // initialize an array to hold our errors   
  $required_fields = array('title', 'image', 'content', 'first-para', 'second-para');  // perform validation for required fields 
  $errors = array_merge($errors, check_required_fields($required_fields, $_POST));  
     
    if(isset($_POST['title'], $_POST['first-para'], $_POST['second-para'], $_POST['third-para'] ) ) {
      $title_textNode = trim($_POST['title']);
      $firstParagraph_textNode  = trim($_POST['first-para']);
      $secondParagraph_textNode = trim($_POST['second-para']);
      $thirdParagraph_textNode  = trim($_POST['third-para']);
    }
    
    // VALIDATING IMAGE FILE 
    // MAKE IMAGE VARIABLES AVAILABLE AND GET ALL THE OTHER INFORMATION FROM THE FORM     
    $img_name      = trim($_FILES['image']['name']);  
    $img_temp_name = $_FILES["image"]["tmp_name"];    
    $img_type      = $_FILES["image"]["type"];
    $img_size      = number_format($_FILES["image"]["size"]/1024, 1). ' kb'; // convert the image size to kb
    $img_path      = UPLOAD_DIR . $img_name;    
    $img_max_size  = number_format(MAX_FILE_SIZE/1024, 1).' KB';  // convert the max size to kb

    // Create an array of permitted MIME types    
    $permitted_type = array('image/gif','image/jpeg','image/png');

    // Get image extension
    $img_extension = substr($img_name, strrpos($img_name, '.') + 1);

    // Check that everything is ok with the image file
    // check if a file of the same name has been uploaded in the same directory
    if (in_array($img_type, $permitted_type)        
        && !file_exists(UPLOAD_DIR . $img_name)  // check the file is not empty
        && $img_size > 0                         // check the file dont exceed the max size permitted
        && $img_size <= MAX_FILE_SIZE
        && !check_required_fields($required_fields, $_POST)
     ){   
       // If img ok, store it con the defined directory using move_uploaded_file(). IF DESIRED, RANAME 
       // IT(see rename() on www.php.net)               
       // move_uploaded_file() moves the uploaded file from its temporary location to its permanent one.  
       // It will return false if $imageName  is not a valid upload file or if it cannot be moved for any other reason.   
       move_uploaded_file($img_temp_name, UPLOAD_DIR.$img_name);    
      
   }else {  
          // Oherwise, display img errors using switch() and $_FILES error array.   
          // switch ($_FILES['image']['error']) {   
          switch($img_name){ 
            case(file_exists(UPLOAD_DIR . $img_name)): 
            $errors[]= "$img_name already exists.<br/> Choose a different image or change the name of the image you are  trying to upload";
            break; 
            // check that file is of a permitted MIME type
            case(!in_array($img_type, $permitted_type)): 
            $errors[]= "$img_extension is not a valid file type. <br/> Acceptable image formats include: GIF, PJPEG, JPG/JPEG, and PNG.";
            break;
            case(empty($_POST['image']) ): 
            $errors[]= "You cant upload an image alone. It has to be related to post. Please, sumbit a post.";
            break;
            //There are 8 possible errors that we can get back:
            // http://www.php.net/manual/en/features.file-upload.errors.php
            case($img_name == UPLOAD_ERR_NO_FILE):
            $errors[]= "You didn't select a file to be uploaded."; 
            break; 
            //Because switch will keep running code until it finds a break, it's 
            //easy enough to take the concept of fallthrough and run the same 
            //code for more than one case.
            case($img_name == UPLOAD_ERR_INI_SIZE): 
            case($img_name == UPLOAD_ERR_FORM_SIZE):
            $errors[]="$img_name is either too big or not a valid file.";
            break; 
            default: 
            $errors[]= "Error uploading file. Please try again.";                  
            break; 
        }
    }   
    
    if(empty($errors)) {  
      $doc = new DOMDocument();
      $doc->load('articles.xml', LIBXML_NOBLANKS);
      $doc->formatOutput = true;
      
      $root_element = $doc->getElementsByTagName("articles")->item(0); // this is the root element
      $new_article = $doc->createElement("article");  // this was converted to an array

        $title = $doc->createElement("title"); // Create a title element
        $title->appendChild( 
                $doc->createTextNode($title_textNode) 
                ); //Create the text content for title element. This is the data coming from the form.
        $new_article->appendChild($title); // append the element and content to the new article element

        $img = $doc->createElement("image");  // create new image element
        $img->appendChild(
              $doc->createTextNode($img_path) 
              ); // create the text content of image element. This the path of the uploaded image
        $new_article->appendChild($img);
              
        $new_content = $doc->createElement("content");
      
        $new_para1 = $doc->createElement("firstParagraph");
        $new_para1->appendChild(                     
                    $doc->createTextNode($firstParagraph_textNode)
                    );
        $new_content->appendChild($new_para1);
      
        $new_para2 = $doc->createElement("secondParagraph");
        $new_para2->appendChild( 
                    $doc->createTextNode($secondParagraph_textNode)
                    );
        $new_content->appendChild($new_para2);
              
        $new_para3= $doc->createElement("thirdParagraph");
        $new_para3->appendChild( 
                    $doc->createTextNode($thirdParagraph_textNode)
                    );
        $new_content->appendChild($new_para3);
          
        //$new_content->appendChild(  $doc->createTextNode($content_textNode)  );
        $new_article->appendChild($new_content); // append the element and content to the new article element
        $root_element->appendChild($new_article);    // now append the new article created to the root element of the doc
      
        # save changes to XML file
        if ($doc->save("articles.xml") != FALSE ) { 
            # if save was successful, redirect user to main page.
            header('Location: index.php' );
            exit;
        } 
        else {
              echo 'An error occured.'; 
      } 
          
    } 

  } // end of if  POST submit  
  
?>  

