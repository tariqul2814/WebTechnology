<?php
    $con = mysqli_connect("localhost","root","","blog_cms");
    $num_of_post = 0;
    $post_per_page = 5;
    $num_of_pages = 1;

    $page = 1;

    if(isset($_GET['page']))
    {
        $page = $_GET['page'];
    }

    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    else{
        $sql2 = "SELECT * FROM posts WHERE is_active=1;";
        $sql = "SELECT * FROM posts WHERE is_active=1 LIMIT ".($page*5-5).", 5;";
        $result = $con->query($sql);

        $num_of_post = mysqli_num_rows($con->query($sql2));

        $num_of_pages = ceil($num_of_post/$post_per_page);        
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
                    <div class="dt"><p><?php echo strtok($row["created_date"], ' '); ?></p></div>
                    <div class="cat">
                        <p> <?php
                                $sql="SELECT c.category_name FROM category c, post_category p WHERE c.category_id=p.category_id AND p.post_id='".$row['post_id']."';";
                                //$sql = "SELECT category.category_name FROM category INNER JOIN post_category WHERE post_category.post_id=".$row["post_id"].";";
                                $cat = $con->query($sql);
                                if ($cat->num_rows > 0) {
                                    foreach ($cat as $catT) {
                                        echo $catT['category_name'];
                                    }
                                }else{
                                    echo "No Catagory";
                                }
                            ?>
                        </p>
                    </div>
                    <h3><a href="post.php?id=<?php echo $row["post_id"]; ?>"><?php echo '<br>'.$row["title"] ;?></a></h3>
                </div>
                <div class="postBody"><p><?php echo explode("<div style=\"page-break-after:always\"><span style=\"display:none\">&nbsp;</span></div>",$row['body'])[0]."..." ;?></p>
                </div>
                <div class="postFooter">
                    <a href="post.php?id=<?php echo $row["post_id"]; ?>">READ MORE</a>
                    <p>
                        <?php
                                $sql = "SELECT tag_name FROM tags WHERE post_id=".$row["post_id"].";";
                                $tag = $con->query($sql);
                                if ($tag->num_rows > 0) {
                                    foreach ($tag as $tagT) {
                                        echo $tagT['tag_name']." ";
                                    }
                                }else{
                                    echo "No Tags";
                                }
                            ?>
                    </p>
                </div>
            </div>
            <?php 
                    }
                }
                else{
                    echo "<div class='posts'><h3>So Empty!!! Create New Post</h3></div></div>";
                } 
            ?>
        </div>

        <?php

            


            
                        if($page !=1)
                        {
                            echo " <div class=\"pageNo\">
                    <div class=\"pagination\">
                        <a href=\"?page=".($page-1)."\">&laquo;</a>";
                        }
                        else
                        {
                            echo " <div class=\"pageNo\">
                    <div class=\"pagination\">
                        <a>&laquo;</a>";
                        }
                    
                    $i = 1;
                    while($i <= $num_of_pages)
                    {
                        
                        echo "<a";


                        if($i == $page)
                        {
                           echo " class=\"active\"";
                        }

                        echo " href=\"?page=".$i."\">".$i."</a>";
                        
                        $i++;
                    }


                        if($page == $num_of_pages)
                        {
                            echo "<a>&raquo;</a>
                        </div>
                    </div>";
                        }
                        else
                        {
                            echo "<a href=\"?page=".($page+1)."\">&raquo;</a>
                        </div>
                    </div>";
                        }

                        
        ?>

        
        
        <?php
            include_once "footer.php"; 
        ?>


        


    </body>
</html>
