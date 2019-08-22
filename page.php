<?php
if(isset($_GET['id'])){
    $con = mysqli_connect("localhost","root","","blog_cms");

    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    else{
        $sql = "SELECT * FROM pages WHERE page_id=".$_GET['id'].";";
        $result = $con->query($sql);
    }
}else{
    header("Location:index.php");
    exit();
}
include_once "header.php";
?>
<!DOCTYPE html>
<html>
    <body>
        <div class="mainBody">
            <?php
                if ($result->num_rows > 0) {
                    foreach ($result as $row) {
                        ?>
                        <div class="posts">
                            <div class="postHead">
                                <h3><?php echo $row["page_title"]; ?></h3>
                            </div>
                            <div class="postBody"><p><?php echo $row["page_body"]; ?></p>
                                <?php
                                if($row["contact"]==1){
                                    include_once "contact.php";
                                }

                                if($row["comment"]==1){
                                    include_once "comment.php";
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                }
            ?>
        </div>
        <?php include_once "footer.php" ?>
    </body>
</html>
