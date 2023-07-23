<?php include('partials/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Add Category</h1>

            <br><br>

            <?php
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }

                if(isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }
            ?>

            <br><br>
            
            <!-- Add Category Form Starts -->
            <form action="" method="POST" enctype="multipart/form-data">
                
                <table class="tbl-30">
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" placeholder="category title">
                        </td>
                    </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name='image'>
                    </td>
                </tr>

                    <tr>
                        <td>Featured:</td>
                        <td>
                            <input type="radio" name="featured" value="Yes"> Yes
                            <input type="radio" name="featured" value="No"> No

                        </td>
                    </tr>

                    <tr>
                        <td>Active:</td>
                        <td>
                            <input type="radio" name="active" value="Yes"> Yes
                            <input type="radio" name="active" value="No"> No

                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                        </td>
                    </tr>
                </table>

            </form>
            <!-- Add Category Form Ends -->

            <?php
            // To check whether submit button is clicked or not
            if(isset($_POST['submit']))
            {
                //echo "clicked";

                //1. Get the value from category form
                $title = $_POST['title'];

                //For Radio input, we need to check whether the button is selected or not
                if(isset($_POST['featured']))
                {
                    //Get value from form
                    $featured = $_POST['featured'];
                }
                else
                {
                    //Set the default value
                    $_featured = 'No';
                }
                
                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";
                }
                
                // Check whether the image is selected or not and set the value for image name accordingly
                // print_r($_FILES['image']);

                // die(); //Break the code here

                if(isset($_FILES['image']['name']))
                {
                    //upload the image
                    //To upload image we need image name, source path and destination path
                    $image_name = $_FILES['image']['name'];

                    //Upload the image only if image is selected
                    if($image_name!="")
                    {

                        //Auto Rename our imgae
                        //Get the extension of our image (jpg, png, gif) e.g "specialfood1.jpg"
                        $ext = end(explode('.', $image_name));

                        //Rename the image
                        $image_name="Food_Category_".rand(000, 999).'.'.$ext;  // e.g Food_Category_834.jpg

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/category/".$image_name;

                        //finally upload the image
                        $upload = move_uploaded_file($source_path, $destination_path);
                    
                        //Check whether the image is uploaded or not
                        //and if the image is not uploaded then we will stop the process and redirect with error message
                        if($upload==false)
                        {
                            //set message
                            $_SESSION['upload']="<div class='error'>failed to upload image.<div>";
                            //Redirect to add category page
                            header('location:'.SITEURL.'admin/add-category.php');
                            //stop the process
                            die();
                        }

                    }
                }
                else
                {
                    //Don't upload image and set the image_name value as blank
                    $image_name="";
                }



                //2. Create SQL Query to insert category into Database
                $sql = "INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                    ";

                    //3. Execute the query and save in database
                    $res = mysqli_query($conn, $sql);

                    //4. Check whether the query exectued or not and data added or not
                    if($res==true)
                    {
                        //Query Executed and category added
                        $_SESSION['add']="<div class='success'>Category Added Successfully.</div>";
                        //Rediredct to the Manage Category Page
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }
                    else
                    {
                        //failed to add category
                        $_SESSION['add']="<div class='success'>Failed to add Category</div>";
                        //Rediredct to the Manage Category Page
                        header('location:'.SITEURL.'admin/add-category.php');
                    }
            }

            ?>

        </div>
    </div>

<?php include('partials/footer.php'); ?>