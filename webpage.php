<?php
ob_start();

    $page = isset($_GET['page']) ? $_GET['page'] : header('location: index.php');


      if ($page == 'blog')
      {
        $noNavbar = '';
        $pageTitle = 'Wise group - Our blog';
        include 'init.php';

        ?>
        <section class="page-header page-header-modern bg-color-primary page-header-md" style="background-image:url('<?php echo $images ?>bg.jpg');background-size:cover" >
              <div class="container">
                <div class="row">


                  <div class="col-md-12 order-2 order-md-1 align-self-center p-static" style="text-align:center">
                    <h1 style="text-align:center">Blog </h1>

                  </div>
                </div>
              </div>
            </section>

        <section class="blog-list blog-st-one-mmb" id="blog-list" style="margin:60px 0 !important">
    <div class="container">
      <div class="row">
        <?php
          $stmt = $conn->prepare("SELECT * FROM posts WHERE visibility = 1 ORDER BY id DESC");
          $stmt->execute();
          $posts = $stmt->fetchAll();
         ?>

<?php
$stmt2 = $conn->prepare("SELECT * FROM categories  WHERE visibility = 1 ORDER BY id DESC");
$stmt2->execute();
$categories = $stmt2->fetchAll();
 ?>
        <!-- posts space -->
        <div class="col-md-9 card-styles blog-card-style-2">
          <div class="row">
            <div class="col-md-12">
              <h4 style="text-transform:capitalize">categories</h4>
              <div class="row">
                <div class="col-md-12">
                  <div class="ds" style="margin-bottom:60px">
                    <ul style="display:flex;list-style:none;justify-content:left;margin:20px 0">
                      <li>
                        <?php
                        foreach  ($categories as $ca)
                        {
                          ?>
                            <a href="webpage.php?page=blogcat&id=<?php echo $ca['id'] ?>" style="border-radius: 8px;border: 1px solid rgba(0,0,0,.1);background:#f1f1f1;color:rgba(0,0,0,.6);text-transform:capitalize;font-size:16px;padding:8px 15px;"><?php echo $ca['name'] ?></a>
                          <?php
                        }
                         ?>
                      </li>
                    </ul>
                  </div>
                </div>

              </div>
            </div>
            <?php
              foreach($posts as $post)
              {
                $stmt = $conn->prepare("SELECT * FROM donations WHERE post = ?");
                $stmt->execute(array($post['id']));
                $t2 = $stmt->rowCount();
                $s = $stmt->fetchAll();
                $t = 0;
                foreach($s as $p)
                {
                  $t += $p['amount'];

                }


                ?>
                <?php
      $perc = $t * 100 / $post['donate'];
                 ?>
                <div class="col-md-6">
                  <div class="item">
                                              <div class="causes-wrap">
                                                  <div class="img-wrap">
                                                      <a href="webpage.php?page=post&id=<?php echo $post['id'] ?>"><img src="<?php echo $images . $post['image'] ?>" alt="Event"></a>
                                                      <div class="raised-progress">


                  <div class="skillbar-wrap" style="text-align:left">
                      <div class="clearfix">
                        <span style="float:right" style="font-size:11px !important;color:var(--mainColor)">%<?php echo $perc ?></span>

                           <span style="color:var(--mainColor)"><?php echo $t .'$';  ?></span>  raised <br>  of <?php echo '$'.$post['donate'] ?>        </div>



                      <progress style="height:5px !important;margin:0 !important;" value="<?php echo $perc ?>" max="100">0%</progress>
                  </div>
                                                      </div>
                                                  </div>

                                                  <div class="content-wrap">
                                                <?php
                                                $stmt = $conn->prepare("SELECT * FROM categories  WHERE id = ?");
                                                $stmt->execute(array($post['category']));
                                                $s = $stmt->fetch();

                                                 ?>
                                                      <span class="tag"><?php echo $s['name'] ?></span>
                                                      <h3><a href="webpage.php?page=post&id=<?php echo $post['id'] ?>"><?php echo $post['title'] ?></a></h3>
                                                      <p>
                                                        <?php
                                                          $text =  strip_tags($post['content']);
                                                         ?>
                                                        <?php   echo  mb_strimwidth($text, 0,80, "..."); ?>
                                                      </p>
                                                      <div class="btn-wrap">
                                                          <a class="btn-primary btn" href="">Donate Now</a>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                </div>
                <?php
              }
             ?>




          </div>
        </div>
        <!-- sidebar content space -->
        <div class="col-md-3 sidebar-ctn">
          <div class="row">

            <div class="col-md-12">
              <div class="card-ctn">
                <div class="card-header-ctn">
                  <h1>SORT</h1>
                </div>
                <div class="card-body-ctn">
                  <div class="posts-list">
                    <ul>

                          <li>
                             <a href="webpage.php?page=blogsort&sort=DESC">Newest</a>
                            </li>

                                                      <li>
                                                         <a href="webpage.php?page=blogsort&sort=ASC">oldest</a>
                                                        </li>



                    </ul>
                  </div>
                </div>
              </div>
            </div>


          </div>
        </div>
        </div>
        </div>
      </section>
          <?php


        include $tpl . 'footer.php';
      }


      elseif ($page == 'blogcat')
      {
        $noNavbar = '';
        $pageTitle = 'Wise group - Our blog';
        include 'init.php';


        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : header('location: index.php');
        $stmt = $conn->prepare("SELECT * FROM posts WHERE category = ? AND visibility = 1 ");
        $stmt->execute(array($id));
        $checkIfuserExist = $stmt->rowCount();
        $posts = $stmt->fetchAll();


        ?>
        <section class="page-header page-header-modern bg-color-primary page-header-md" style="background-image:url('<?php echo $images ?>bg.jpg');background-size:cover" >
              <div class="container">
                <div class="row">


                  <div class="col-md-12 order-2 order-md-1 align-self-center p-static" style="text-align:center">
                    <h1 style="text-align:center">Details </h1>

                  </div>
                </div>
              </div>
            </section>
        <section class="blog-list blog-st-one-mmb" id="blog-list" style="margin:60px 0 !important">
    <div class="container">
      <div class="row">


<?php
$stmt2 = $conn->prepare("SELECT * FROM categories  WHERE visibility = 1 ORDER BY id DESC");
$stmt2->execute();
$categories = $stmt2->fetchAll();
 ?>
        <!-- posts space -->
        <div class="col-md-9 card-styles blog-card-style-2">
          <div class="row">
            <div class="col-md-12">
              <h4 style="text-transform:capitalize">categories</h4>
              <div class="row">
                <div class="col-md-12">
                  <div class="ds" style="margin-bottom:60px">
                    <ul style="display:flex;list-style:none;justify-content:left;margin:20px 0">
                      <li>
                        <?php
                        foreach  ($categories as $ca)
                        {
                          ?>
                            <a  href="webpage.php?page=blogcat&id=<?php echo $ca['id'] ?>" style="<?php if ($ca['id'] == $id) { ?> background: var(--mainColor);color:white;<?php }else { ?> background:#f1f1f1;color:rgba(0,0,0,.6); <?php } ?>border-radius: 8px;border: 1px solid rgba(0,0,0,.1);text-transform:capitalize;font-size:16px;padding:8px 15px;"><?php echo $ca['name'] ?></a>
                          <?php
                        }
                         ?>
                      </li>
                    </ul>
                  </div>
                </div>

              </div>
            </div>
            <?php
              foreach ($posts as $post)
              {
                ?>
                <div class="col-md-4">
                  <div class="item">
                                              <div class="causes-wrap">
                                                  <div class="img-wrap">
                                                      <a href="webpage.php?page=post&id=<?php echo $post['id'] ?>"><img src="<?php echo $images . $post['image'] ?>" alt="Event"></a>
                                                      <div class="raised-progress">


                  <div class="skillbar-wrap">
                      <div class="clearfix">
                          $1,350 raised of $7,500        </div>
                      <div class="skillbar" data-percent="18%">
                          <div class="skillbar-percent">18%</div>
                          <div class="skillbar-bar"></div>
                      </div>
                  </div>
                                                      </div>
                                                  </div>

                                                  <div class="content-wrap">
                                                <?php
                                                $stmt = $conn->prepare("SELECT * FROM categories  WHERE id = ?");
                                                $stmt->execute(array($post['category']));
                                                $s = $stmt->fetch();

                                                 ?>
                                                      <span class="tag"><?php echo $s['name'] ?></span>
                                                      <h3><a href="webpage.php?page=post&id=<?php echo $post['id'] ?>"><?php echo $post['title'] ?></a></h3>
                                                      <p>
                                                        <?php
                                                          $text =  strip_tags($post['content']);
                                                         ?>
                                                        <?php   echo  mb_strimwidth($text, 0,80, "..."); ?>
                                                      </p>
                                                      <div class="btn-wrap">
                                                          <a class="btn-primary btn" href="webpage.php?page=post&id=<?php echo $post['id'] ?>">Donate Now</a>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                </div>

                <?php
              }
             ?>




          </div>
        </div>
        <!-- sidebar content space -->
        <div class="col-md-3 sidebar-ctn">
          <div class="row">

            <div class="col-md-12">
              <div class="card-ctn">
                <div class="card-header-ctn">
                  <h1>SORT</h1>
                </div>
                <div class="card-body-ctn">
                  <div class="posts-list">
                    <ul>

                          <li>
                             <a href="webpage.php?page=blogsort&sort=DESC">Newest</a>
                            </li>

                                                      <li>
                                                         <a href="webpage.php?page=blogsort&sort=ASC">oldest</a>
                                                        </li>



                    </ul>
                  </div>
                </div>
              </div>
            </div>


          </div>
        </div>
        </div>
        </div>
      </section>
          <?php


        include $tpl . 'footer.php';
      }

      elseif ($page == 'blogsort')
      {
        $noNavbar = '';
        $pageTitle = 'Wise group - Our blog';
        include 'init.php';


        $ord = 'ASC';

        if (isset($_GET['sort']))
        {
          $ord = $_GET['sort'];
        }

        $stmt = $conn->prepare("SELECT * FROM posts  ORDER BY id $ord");
                  $stmt->execute();
                  $posts = $stmt->fetchAll();


        ?>
        <section class="page-header page-header-modern bg-color-primary page-header-md" style="background-image:url('<?php echo $images ?>bg.jpg');background-size:cover" >
              <div class="container">
                <div class="row">


                  <div class="col-md-12 order-2 order-md-1 align-self-center p-static" style="text-align:center">
                    <h1 style="text-align:center">Details </h1>

                  </div>
                </div>
              </div>
            </section>
        <section class="blog-list blog-st-one-mmb" id="blog-list" style="margin:60px 0 !important">
    <div class="container">
      <div class="row">


<?php
$stmt2 = $conn->prepare("SELECT * FROM categories  WHERE visibility = 1 ORDER BY id DESC");
$stmt2->execute();
$categories = $stmt2->fetchAll();
 ?>
        <!-- posts space -->
        <div class="col-md-9 card-styles blog-card-style-2">
          <div class="row">
            <div class="col-md-12">
              <h4 style="text-transform:capitalize">categories</h4>
              <div class="row">
                <div class="col-md-12">
                  <div class="ds" style="margin-bottom:60px">
                    <ul style="display:flex;list-style:none;justify-content:left;margin:20px 0">
                      <li>
                        <?php
                        foreach  ($categories as $ca)
                        {
                          ?>
                            <a  href="webpage.php?page=blogcat&id=<?php echo $ca['id'] ?>" style="<?php if ($ca['id'] == $id) { ?> background: var(--mainColor);color:white;<?php }else { ?> background:#f1f1f1;color:rgba(0,0,0,.6); <?php } ?>border-radius: 8px;border: 1px solid rgba(0,0,0,.1);text-transform:capitalize;font-size:16px;padding:8px 15px;"><?php echo $ca['name'] ?></a>
                          <?php
                        }
                         ?>
                      </li>
                    </ul>
                  </div>
                </div>

              </div>
            </div>
            <?php
              foreach ($posts as $post)
              {
                ?>
                <div class="col-md-4">
                  <div class="item">
                                              <div class="causes-wrap">
                                                  <div class="img-wrap">
                                                      <a href="webpage.php?page=post&id=<?php echo $post['id'] ?>"><img src="<?php echo $images . $post['image'] ?>" alt="Event"></a>
                                                      <div class="raised-progress">


                  <div class="skillbar-wrap">
                      <div class="clearfix">
                          $1,350 raised of $7,500        </div>
                      <div class="skillbar" data-percent="18%">
                          <div class="skillbar-percent">18%</div>
                          <div class="skillbar-bar"></div>
                      </div>
                  </div>
                                                      </div>
                                                  </div>

                                                  <div class="content-wrap">
                                                <?php
                                                $stmt = $conn->prepare("SELECT * FROM categories  WHERE id = ?");
                                                $stmt->execute(array($post['category']));
                                                $s = $stmt->fetch();

                                                 ?>
                                                      <span class="tag"><?php echo $s['name'] ?></span>
                                                      <h3><a href="webpage.php?page=post&id=<?php echo $post['id'] ?>"><?php echo $post['title'] ?></a></h3>
                                                      <p>
                                                        <?php
                                                          $text =  strip_tags($post['content']);
                                                         ?>
                                                        <?php   echo  mb_strimwidth($text, 0,80, "..."); ?>
                                                      </p>
                                                      <div class="btn-wrap">
                                                          <a class="btn-primary btn" href="">Donate Now</a>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                </div>

                <?php
              }
             ?>




          </div>
        </div>
        <!-- sidebar content space -->
        <div class="col-md-3 sidebar-ctn">
          <div class="row">

            <div class="col-md-12">
              <div class="card-ctn">
                <div class="card-header-ctn">
                  <h1>SORT</h1>
                </div>
                <div class="card-body-ctn">
                  <div class="posts-list">
                    <ul>

                          <li>
                             <a href="webpage.php?page=blogsort&sort=DESC">Newest</a>
                            </li>

                                                      <li>
                                                         <a href="webpage.php?page=blogsort&sort=ASC">oldest</a>
                                                        </li>



                    </ul>
                  </div>
                </div>
              </div>
            </div>


          </div>
        </div>
        </div>
        </div>
      </section>
          <?php


        include $tpl . 'footer.php';
      }
      elseif ($page == "post") {
         $noNavbar = '';
        $pageTitle = 'blog - details pages';
        include 'init.php';
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : header('location: index.php');

        $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute(array($id));
        $post = $stmt->fetch();




              ?>
              <section class="page-header page-header-modern bg-color-primary page-header-md" style="background-image:url('<?php echo $images ?>bg.jpg');background-size:cover" >
            				<div class="container">
            					<div class="row">


                        <div class="col-md-12 order-2 order-md-1 align-self-center p-static" style="text-align:center">
                          <h1 style="text-align:center">Details </h1>

                        </div>
            					</div>
            				</div>
            			</section>

        <section class="blog-list blog-st-one-mmb" id="blog-list">
    <div class="container">
      <div class="row">


        <!-- posts space -->
        <div class="col-md-12">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="post">
                                <div class="post-header" style="text-align:left">
                                  <h1 style="text-align:left"><?php echo $post['title'] ?></h1>
                                  <?php
                                    $text =  strip_tags($post['content']);
                                   ?>
                                  <?php   echo  mb_strimwidth($text, 0,140, "..."); ?>

                                  <ul>
                                     <li> <span class="date"><?php echo $post['created'] ?></span> </li>
                                     <?php
                                        $stmt = $conn->prepare("SELECT * FROM users WHERE id =?");
                                        $stmt->execute(array($post['userid']));
                                        $user = $stmt->fetch();
                                      ?>
                                    <li> <span class="admin"><?php echo $user['fname'] ?></span> </li>
                                  </ul>
                                </div>
                                <div class="post-body" style="text-align:left;color:black">
                                  <div class="row" style="padding:0 !important;">
                                    <div class="col-md-4" style="">
                                      <div class="donation-details" style="text-align:center;background:#f1f1f1;padding:60px 10px">
                                        <?php

                                        $stmt = $conn->prepare("SELECT * FROM donations WHERE post = ?");
                                        $stmt->execute(array($id));
                                        $t2 = $stmt->rowCount();
                                        $s = $stmt->fetchAll();
                                        $t= 0;
                                        foreach($s as $p)
                                        {
                                          $t += $p['amount'];
                                        }
                                        ?>
                                        <h1 style="text-align:center"><?php echo '$' . $t ?></h1>

                                        <span> funded of $<?php echo $post['donate'] ?> USD </span>

                                        <?php
      $perc = $t * 100 / $post['donate'];

                                         ?>
                                        <progress value="<?php echo $perc * 100 ?>" max="100" style="width:100%"><?php $perc ?>%</progress>
                                        <p> <?php echo $perc ?>%, <?php echo $t2 ?> supporters</p>
                                        <div class="doanf" style="text-align:center">
                                          <a href="#">support</a><br>
                                          <p style="margin:20px;color:rgba(0,0,0,.6);font-size:13px">Verified for authenticity <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M10.95 12.7L9.575 11.3C9.375 11.1 9.13767 11 8.863 11C8.58767 11 8.35 11.1 8.15 11.3C7.95 11.5 7.846 11.7373 7.838 12.012C7.82933 12.2873 7.925 12.525 8.125 12.725L10.25 14.85C10.45 15.05 10.6833 15.15 10.95 15.15C11.2167 15.15 11.45 15.05 11.65 14.85L15.9 10.6C16.1 10.4 16.2 10.1623 16.2 9.887C16.2 9.61233 16.1 9.375 15.9 9.175C15.7 8.975 15.4627 8.875 15.188 8.875C14.9127 8.875 14.675 8.975 14.475 9.175L10.95 12.7ZM12 21.925H11.75C11.6667 21.925 11.5917 21.9083 11.525 21.875C9.34167 21.1917 7.54167 19.8373 6.125 17.812C4.70833 15.7873 4 13.55 4 11.1V6.375C4 5.95833 4.121 5.58333 4.363 5.25C4.60433 4.91667 4.91667 4.675 5.3 4.525L11.3 2.275C11.5333 2.19167 11.7667 2.15 12 2.15C12.2333 2.15 12.4667 2.19167 12.7 2.275L18.7 4.525C19.0833 4.675 19.396 4.91667 19.638 5.25C19.8793 5.58333 20 5.95833 20 6.375V11.1C20 13.55 19.2917 15.7873 17.875 17.812C16.4583 19.8373 14.6583 21.1917 12.475 21.875C12.3917 21.9083 12.2333 21.925 12 21.925V21.925ZM12 19.9C13.7333 19.35 15.1667 18.25 16.3 16.6C17.4333 14.95 18 13.1167 18 11.1V6.375L12 4.125L6 6.375V11.1C6 13.1167 6.56667 14.95 7.7 16.6C8.83333 18.25 10.2667 19.35 12 19.9Z" fill="#4AA567"/>
                                          </svg>
</p>
                                        </div>
                                        <div class="donations">
                                          <?php
                                          $stmt3 = $conn->prepare("SELECT * FROM donations WHERE post = ? ORDER BY id DESC LIMIT 5");
                                          $stmt3->execute(array($id));
                                          $dn = $stmt3->fetchAll();

                                           ?>
                                          <a href="#" style="display:block;text-align:"></a>
                                        </div>



                                      </div>
                                    </div>
                                    <div class="col-md-8" style="padding:0">
                                      <img src="<?php echo $images . $post['image'] ?>" style="width:100%;height:400px;margin:60px 0;margin-top:0px;margin-right:0 !important">

                                    </div>

                                  </div>


                                </div>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="row">
                                <div class="col-md-4">
                                  <div class="card-ctn" style="margin:0px 0">
                                    <div class="card-header-ctn">
                                      <h5 style="padding:15px 0px;background: #fff;color:black;text-align:left">Recent supporters</h5>
                                    </div>
                                    <div class="card-body-ctn">
                                      <div class="posts-list">
                                        <ul style="padding:0">
                                          <?php
                                          foreach($dn as $n)
                                          {
                                            ?>
                                            <li style="border-bottom:1px solid rgba(0,0,0,.1)">
                                              <a  style="font-size:17px;"><?php echo $n['fname'] ?></a>
                                              <p style="padding: 0 10px;text-align:left;margin:0;font-size:13px;color:rgba(0,0,0,.5)"><?php echo '$' . $n['amount'] ?>, <?php echo $n['created'] ?></p>
                                            </li>
                                            <?php
                                          }
                                           ?>
                                        </ul>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-8">
                                  <?php
                                    $text =  $post['content'];
                                   ?>
                                  <?php   echo  $text; ?>
                                </div>

                              </div>
                            </div>

                            <hr class="hr-custom">

                          </div>
                      </div>

        </div>
        </div>
      </section>
          <?php


        include $tpl . 'footer.php';
      }

      elseif ($page == "aboutus") {
        $noNavbar = '';
        $pageTitle ='من نحن';
        include 'init.php';
        $stmt = $conn->prepare("SELECT * FROM pages WHERE id = 1");
        $stmt->execute();
        $pg = $stmt->fetch();
        ?>

        <section class="about about-details-mb1" id="about"  style="margin-top:60px !important" >
  <div class="container">
    <div class="row">

      <div class="col-md-6">
      <div class="ctn-abt-mb1">
        <h3>من نحن وما نقدمه لك</h3>
          <p>
          يعمل نظام تتبع المركبات عن طريق ارسال المعلومات الخاصة بالمركبة من خلال جهاز التتبع الموجود بالمركبة والذي يحتوي على جهاز يستقبل موقع السيارة وسرعتها من نظام تحديد المواقع عن طريق الأقمار الصناعية وإرسالها آليا لمحطة التحكم الخاص بلعميل عن طريق شبكة الهاتف الخليوي حيث يتم استقبال هذه المعلومات وعرضها على الخريطة الخاصة بالنظام واستخراج التقارير الخاصة بالسيارات.
          نحن في ابجد التقنية نقدم الحلول العالمية لنظام تعقب المركبات والسيارات والمعدات بطريقة سلسة وباسعار مناسبة .
</p>
        <h3>رسالتنا</h3>
        <p>
        يعمل نظام تتبع المركبات عن طريق ارسال المعلومات الخاصة بالمركبة من خلال جهاز التتبع الموجود بالمركبة والذي يحتوي على جهاز يستقبل موقع السيارة وسرعتها من نظام تحديد المواقع عن طريق الأقمار الصناعية وإرسالها آليا لمحطة التحكم الخاص بلعميل عن طريق شبكة الهاتف الخليوي حيث يتم استقبال هذه المعلومات وعرضها على الخريطة الخاصة بالنظام واستخراج التقارير الخاصة بالسيارات.
        نحن في ابجد التقنية نقدم الحلول العالمية لنظام تعقب المركبات والسيارات والمعدات بطريقة سلسة وباسعار مناسبة .
</p>
<h3>رؤيتنا</h3>
<p>
يعمل نظام تتبع المركبات عن طريق ارسال المعلومات الخاصة بالمركبة من خلال جهاز التتبع الموجود بالمركبة والذي يحتوي على جهاز يستقبل موقع السيارة وسرعتها من نظام تحديد المواقع عن طريق الأقمار الصناعية وإرسالها آليا لمحطة التحكم الخاص بلعميل عن طريق شبكة الهاتف الخليوي حيث يتم استقبال هذه المعلومات وعرضها على الخريطة الخاصة بالنظام واستخراج التقارير الخاصة بالسيارات.
نحن في ابجد التقنية نقدم الحلول العالمية لنظام تعقب المركبات والسيارات والمعدات بطريقة سلسة وباسعار مناسبة .
</p>
      </div>
      </div>
      <div class="col-md-6">
        <div class="img">
          <img src="<?php echo $images ?>bbb.jpg" style="width:100%">
        </div>
      </div>

    </div>
  </div>
</section>


          <?php


        include $tpl . 'footer.php';
      }
      elseif ($page == "idara") {
        $noNavbar = '';
        $pageTitle ='انماء لرعاية الطفولة - مجلس الادارة';
        include 'init.php';
        $stmt = $conn->prepare("SELECT * FROM pages WHERE id = 1");
        $stmt->execute();
        $pg = $stmt->fetch();
        ?>
        <section class="page-header page-header-modern bg-color-primary page-header-md">
              <div class="container">
                <div class="row">


                  <div class="col-md-12 order-2 order-md-1 align-self-center p-static" style="text-align:center">
                    <h1 style="text-align:center">مجلس الادارة</h1>

                  </div>
                </div>
              </div>
            </section>
            <section class="filesdownloads">
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col-md-4">
                    <div class="ds">
                      <h1 style="text-align:center;color:var(--mainColor);margin:10px 0">بيانات مجلس الادارة</h1>
                      <a href="<?php echo $images ?>idara.zip" download target="_blank"> <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M24.375 27.5898H21.4805V18.125C21.4805 17.9531 21.3399 17.8125 21.168 17.8125H18.8242C18.6524 17.8125 18.5117 17.9531 18.5117 18.125V27.5898H15.625C15.3633 27.5898 15.2188 27.8906 15.3789 28.0938L19.7539 33.6289C19.7832 33.6663 19.8205 33.6965 19.8631 33.7172C19.9058 33.738 19.9526 33.7488 20 33.7488C20.0475 33.7488 20.0943 33.738 20.1369 33.7172C20.1795 33.6965 20.2169 33.6663 20.2461 33.6289L24.6211 28.0938C24.7813 27.8906 24.6367 27.5898 24.375 27.5898V27.5898Z" fill="white"/>
                      <path d="M31.6953 14.3242C29.9063 9.60547 25.3477 6.25 20.0078 6.25C14.668 6.25 10.1094 9.60156 8.32031 14.3203C4.97266 15.1992 2.5 18.25 2.5 21.875C2.5 26.1914 5.99609 29.6875 10.3086 29.6875H11.875C12.0469 29.6875 12.1875 29.5469 12.1875 29.375V27.0312C12.1875 26.8594 12.0469 26.7188 11.875 26.7188H10.3086C8.99219 26.7188 7.75391 26.1953 6.83203 25.2461C5.91406 24.3008 5.42578 23.0273 5.46875 21.707C5.50391 20.6758 5.85547 19.707 6.49219 18.8906C7.14453 18.0586 8.05859 17.4531 9.07422 17.1836L10.5547 16.7969L11.0977 15.3672C11.4336 14.4766 11.9023 13.6445 12.4922 12.8906C13.0745 12.1434 13.7643 11.4865 14.5391 10.9414C16.1445 9.8125 18.0352 9.21484 20.0078 9.21484C21.9805 9.21484 23.8711 9.8125 25.4766 10.9414C26.2539 11.4883 26.9414 12.1445 27.5234 12.8906C28.1133 13.6445 28.582 14.4805 28.918 15.3672L29.457 16.793L30.9336 17.1836C33.0508 17.7539 34.5312 19.6797 34.5312 21.875C34.5312 23.168 34.0273 24.3867 33.1133 25.3008C32.665 25.7517 32.1318 26.1092 31.5444 26.3526C30.957 26.596 30.3272 26.7204 29.6914 26.7188H28.125C27.9531 26.7188 27.8125 26.8594 27.8125 27.0312V29.375C27.8125 29.5469 27.9531 29.6875 28.125 29.6875H29.6914C34.0039 29.6875 37.5 26.1914 37.5 21.875C37.5 18.2539 35.0352 15.207 31.6953 14.3242Z" fill="white"/>
                      </svg>
 تحميل</a>
                    </div>
                  </div>
                </div>
              </div>
            </section>

          <?php


        include $tpl . 'footer.php';
      }
      elseif ($page == "dja") {
        $noNavbar = '';
        $pageTitle ='انماء لرعاية الطفولة - الجمعية العمومية';
        include 'init.php';
        $stmt = $conn->prepare("SELECT * FROM pages WHERE id = 1");
        $stmt->execute();
        $pg = $stmt->fetch();
        ?>
        <section class="page-header page-header-modern bg-color-primary page-header-md"  >
              <div class="container">
                <div class="row">


                  <div class="col-md-12 order-2 order-md-1 align-self-center p-static" style="text-align:center">
                    <h1 style="text-align:center">الجمعية العمومية</h1>

                  </div>
                </div>
              </div>
            </section>
            <section class="filesdownloads">
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col-md-4">
                    <div class="ds">
                      <h1 style="text-align:center;color:var(--mainColor);margin:10px 0">ملف الخاص بالجمعية العمومية</h1>
                      <a href="<?php echo $images ?>dja.zip" download target="_blank"> <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M24.375 27.5898H21.4805V18.125C21.4805 17.9531 21.3399 17.8125 21.168 17.8125H18.8242C18.6524 17.8125 18.5117 17.9531 18.5117 18.125V27.5898H15.625C15.3633 27.5898 15.2188 27.8906 15.3789 28.0938L19.7539 33.6289C19.7832 33.6663 19.8205 33.6965 19.8631 33.7172C19.9058 33.738 19.9526 33.7488 20 33.7488C20.0475 33.7488 20.0943 33.738 20.1369 33.7172C20.1795 33.6965 20.2169 33.6663 20.2461 33.6289L24.6211 28.0938C24.7813 27.8906 24.6367 27.5898 24.375 27.5898V27.5898Z" fill="white"/>
                      <path d="M31.6953 14.3242C29.9063 9.60547 25.3477 6.25 20.0078 6.25C14.668 6.25 10.1094 9.60156 8.32031 14.3203C4.97266 15.1992 2.5 18.25 2.5 21.875C2.5 26.1914 5.99609 29.6875 10.3086 29.6875H11.875C12.0469 29.6875 12.1875 29.5469 12.1875 29.375V27.0312C12.1875 26.8594 12.0469 26.7188 11.875 26.7188H10.3086C8.99219 26.7188 7.75391 26.1953 6.83203 25.2461C5.91406 24.3008 5.42578 23.0273 5.46875 21.707C5.50391 20.6758 5.85547 19.707 6.49219 18.8906C7.14453 18.0586 8.05859 17.4531 9.07422 17.1836L10.5547 16.7969L11.0977 15.3672C11.4336 14.4766 11.9023 13.6445 12.4922 12.8906C13.0745 12.1434 13.7643 11.4865 14.5391 10.9414C16.1445 9.8125 18.0352 9.21484 20.0078 9.21484C21.9805 9.21484 23.8711 9.8125 25.4766 10.9414C26.2539 11.4883 26.9414 12.1445 27.5234 12.8906C28.1133 13.6445 28.582 14.4805 28.918 15.3672L29.457 16.793L30.9336 17.1836C33.0508 17.7539 34.5312 19.6797 34.5312 21.875C34.5312 23.168 34.0273 24.3867 33.1133 25.3008C32.665 25.7517 32.1318 26.1092 31.5444 26.3526C30.957 26.596 30.3272 26.7204 29.6914 26.7188H28.125C27.9531 26.7188 27.8125 26.8594 27.8125 27.0312V29.375C27.8125 29.5469 27.9531 29.6875 28.125 29.6875H29.6914C34.0039 29.6875 37.5 26.1914 37.5 21.875C37.5 18.2539 35.0352 15.207 31.6953 14.3242Z" fill="white"/>
                      </svg>
 تحميل</a>
                    </div>
                  </div>
                </div>
              </div>
            </section>

          <?php


        include $tpl . 'footer.php';
      }
      elseif ($page == "haykl") {
        $noNavbar = '';
        $pageTitle ='انماء لرعاية الطفولة - الهيكل التنظيمي';
        include 'init.php';
        $stmt = $conn->prepare("SELECT * FROM pages WHERE id = 1");
        $stmt->execute();
        $pg = $stmt->fetch();
        ?>
        <section class="page-header page-header-modern bg-color-primary page-header-md" >
              <div class="container">
                <div class="row">


                  <div class="col-md-12 order-2 order-md-1 align-self-center p-static" style="text-align:center">
                    <h1 style="text-align:center">الهيكل التنظيمي</h1>

                  </div>
                </div>
              </div>
            </section>
            <section class="filesdownloads">
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col-md-4">
                    <div class="ds">
                      <h1 style="text-align:center;color:var(--mainColor);margin:10px 0">ملفات الهيكل التنظيكي</h1>
                      <a href="<?php echo $images ?>haykl.zip" download target="_blank"> <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M24.375 27.5898H21.4805V18.125C21.4805 17.9531 21.3399 17.8125 21.168 17.8125H18.8242C18.6524 17.8125 18.5117 17.9531 18.5117 18.125V27.5898H15.625C15.3633 27.5898 15.2188 27.8906 15.3789 28.0938L19.7539 33.6289C19.7832 33.6663 19.8205 33.6965 19.8631 33.7172C19.9058 33.738 19.9526 33.7488 20 33.7488C20.0475 33.7488 20.0943 33.738 20.1369 33.7172C20.1795 33.6965 20.2169 33.6663 20.2461 33.6289L24.6211 28.0938C24.7813 27.8906 24.6367 27.5898 24.375 27.5898V27.5898Z" fill="white"/>
                      <path d="M31.6953 14.3242C29.9063 9.60547 25.3477 6.25 20.0078 6.25C14.668 6.25 10.1094 9.60156 8.32031 14.3203C4.97266 15.1992 2.5 18.25 2.5 21.875C2.5 26.1914 5.99609 29.6875 10.3086 29.6875H11.875C12.0469 29.6875 12.1875 29.5469 12.1875 29.375V27.0312C12.1875 26.8594 12.0469 26.7188 11.875 26.7188H10.3086C8.99219 26.7188 7.75391 26.1953 6.83203 25.2461C5.91406 24.3008 5.42578 23.0273 5.46875 21.707C5.50391 20.6758 5.85547 19.707 6.49219 18.8906C7.14453 18.0586 8.05859 17.4531 9.07422 17.1836L10.5547 16.7969L11.0977 15.3672C11.4336 14.4766 11.9023 13.6445 12.4922 12.8906C13.0745 12.1434 13.7643 11.4865 14.5391 10.9414C16.1445 9.8125 18.0352 9.21484 20.0078 9.21484C21.9805 9.21484 23.8711 9.8125 25.4766 10.9414C26.2539 11.4883 26.9414 12.1445 27.5234 12.8906C28.1133 13.6445 28.582 14.4805 28.918 15.3672L29.457 16.793L30.9336 17.1836C33.0508 17.7539 34.5312 19.6797 34.5312 21.875C34.5312 23.168 34.0273 24.3867 33.1133 25.3008C32.665 25.7517 32.1318 26.1092 31.5444 26.3526C30.957 26.596 30.3272 26.7204 29.6914 26.7188H28.125C27.9531 26.7188 27.8125 26.8594 27.8125 27.0312V29.375C27.8125 29.5469 27.9531 29.6875 28.125 29.6875H29.6914C34.0039 29.6875 37.5 26.1914 37.5 21.875C37.5 18.2539 35.0352 15.207 31.6953 14.3242Z" fill="white"/>
                      </svg>
تحميل</a>
                    </div>
                  </div>
                </div>
              </div>
            </section>

          <?php


        include $tpl . 'footer.php';
      }
      elseif ($page == "sisa") {
        $noNavbar = '';
        $pageTitle ='انماء لرعاية الطفولة - السياسات و اللوائح';
        include 'init.php';
        $stmt = $conn->prepare("SELECT * FROM pages WHERE id = 1");
        $stmt->execute();
        $pg = $stmt->fetch();
        ?>
        <section class="page-header page-header-modern bg-color-primary page-header-md"  >
              <div class="container">
                <div class="row">


                  <div class="col-md-12 order-2 order-md-1 align-self-center p-static" style="text-align:center">
                    <h1 style="text-align:center">السياسات و اللوائح</h1>

                  </div>
                </div>
              </div>
            </section>
            <section class="filesdownloads">
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col-md-4">
                    <div class="ds">
                      <h1 style="text-align:center;color:var(--mainColor);margin:10px 0">ملف السياسات و اللوائح</h1>
                      <a href="<?php echo $images ?>sisa.zip" download target="_blank"> <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M24.375 27.5898H21.4805V18.125C21.4805 17.9531 21.3399 17.8125 21.168 17.8125H18.8242C18.6524 17.8125 18.5117 17.9531 18.5117 18.125V27.5898H15.625C15.3633 27.5898 15.2188 27.8906 15.3789 28.0938L19.7539 33.6289C19.7832 33.6663 19.8205 33.6965 19.8631 33.7172C19.9058 33.738 19.9526 33.7488 20 33.7488C20.0475 33.7488 20.0943 33.738 20.1369 33.7172C20.1795 33.6965 20.2169 33.6663 20.2461 33.6289L24.6211 28.0938C24.7813 27.8906 24.6367 27.5898 24.375 27.5898V27.5898Z" fill="white"/>
                      <path d="M31.6953 14.3242C29.9063 9.60547 25.3477 6.25 20.0078 6.25C14.668 6.25 10.1094 9.60156 8.32031 14.3203C4.97266 15.1992 2.5 18.25 2.5 21.875C2.5 26.1914 5.99609 29.6875 10.3086 29.6875H11.875C12.0469 29.6875 12.1875 29.5469 12.1875 29.375V27.0312C12.1875 26.8594 12.0469 26.7188 11.875 26.7188H10.3086C8.99219 26.7188 7.75391 26.1953 6.83203 25.2461C5.91406 24.3008 5.42578 23.0273 5.46875 21.707C5.50391 20.6758 5.85547 19.707 6.49219 18.8906C7.14453 18.0586 8.05859 17.4531 9.07422 17.1836L10.5547 16.7969L11.0977 15.3672C11.4336 14.4766 11.9023 13.6445 12.4922 12.8906C13.0745 12.1434 13.7643 11.4865 14.5391 10.9414C16.1445 9.8125 18.0352 9.21484 20.0078 9.21484C21.9805 9.21484 23.8711 9.8125 25.4766 10.9414C26.2539 11.4883 26.9414 12.1445 27.5234 12.8906C28.1133 13.6445 28.582 14.4805 28.918 15.3672L29.457 16.793L30.9336 17.1836C33.0508 17.7539 34.5312 19.6797 34.5312 21.875C34.5312 23.168 34.0273 24.3867 33.1133 25.3008C32.665 25.7517 32.1318 26.1092 31.5444 26.3526C30.957 26.596 30.3272 26.7204 29.6914 26.7188H28.125C27.9531 26.7188 27.8125 26.8594 27.8125 27.0312V29.375C27.8125 29.5469 27.9531 29.6875 28.125 29.6875H29.6914C34.0039 29.6875 37.5 26.1914 37.5 21.875C37.5 18.2539 35.0352 15.207 31.6953 14.3242Z" fill="white"/>
                      </svg>
تحميل</a>
                    </div>
                  </div>
                </div>
              </div>
            </section>

          <?php


        include $tpl . 'footer.php';
      }

      elseif ($page == "services") {
        $noNavbar = '';
        $pageTitle ='ربيز - خدماتنا';
        include 'init.php';
        $stmt = $conn->prepare("SELECT * FROM pages WHERE id = 1");
        $stmt->execute();
        $pg = $stmt->fetch();
        ?>
          <section class=" page-header page-header-modern bg-color-primary page-header-md">
                  <div class="container">
                    <div class="row">
                      <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                        <h1>خدماتنا</h1>

                      </div>
                      <div class="col-md-4 order-1 order-md-2 align-self-center">
                        <ul class="breadcrumb d-block text-md-right breadcrumb-light">
                          <li><a href="index.php">الرئيسية</a></li>

                          <li class="active">خدماتنا</li>
                        </ul>
                      </div>
                    </div>
                  </div>

                </section>
                <div class="dmpz">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
                    <path class="elementor-shape-fill" d="M421.9,6.5c22.6-2.5,51.5,0.4,75.5,5.3c23.6,4.9,70.9,23.5,100.5,35.7c75.8,32.2,133.7,44.5,192.6,49.7
                    c23.6,2.1,48.7,3.5,103.4-2.5c54.7-6,106.2-25.6,106.2-25.6V0H0v30.3c0,0,72,32.6,158.4,30.5c39.2-0.7,92.8-6.7,134-22.4
                    c21.2-8.1,52.2-18.2,79.7-24.2C399.3,7.9,411.6,7.5,421.9,6.5z"></path>
                  </svg>
                </div>

                    <section class="aboutus sv-page" id="aboutus"  >
                      <div class="container">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="content-header" style="text-align:center">
                              <img src="<?php echo $images ?>zig.png" alt="">

                              <h1 style="text-align:center">الحضانة</h1>

                            </div>
                          </div>





                        </div>
                      </div>
                      <div class="sg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 283.5 27.8" preserveAspectRatio="xMidYMax slice">
                        <path class="elementor-shape-fill" d="M265.8 3.5c-10.9 0-15.9 6.2-15.9 6.2s-3.6-3.5-9.2-.9c-9.1 4.1-4.4 13.4-4.4 13.4s-1.2.2-1.9.9c-.6.7-.5 1.9-.5 1.9s-1-.5-2.3-.2c-1.3.3-1.6 1.4-1.6 1.4s.4-3.4-1.5-5c-3.9-3.4-8.3-.2-8.3-.2s-.6-.7-.9-.9c-.4-.2-1.2-.2-1.2-.2s-4.4-3.6-11.5-2.6-10.4 7.9-10.4 7.9-.5-3.3-3.9-4.9c-4.8-2.4-7.4 0-7.4 0s2.4-4.1-1.9-6.4-6.2 1.2-6.2 1.2-.9-.5-2.1-.5-2.3 1.1-2.3 1.1.1-.7-1.1-1.1c-1.2-.4-2 0-2 0s3.6-6.8-3.5-8.9c-6-1.8-7.9 2.6-8.4 4-.1-.3-.4-.7-.9-1.1-1-.7-1.3-.5-1.3-.5s1-4-1.7-5.2c-2.7-1.2-4.2 1.1-4.2 1.1s-3.1-1-5.7 1.4-2.1 5.5-2.1 5.5-.9 0-2.1.7-1.4 1.7-1.4 1.7-1.7-1.2-4.3-1.2c-2.6 0-4.5 1.2-4.5 1.2s-.7-1.5-2.8-2.4c-2.1-.9-4 0-4 0s2.6-5.9-4.7-9c-7.3-3.1-12.6 3.3-12.6 3.3s-.9 0-1.9.2c-.9.2-1.5.9-1.5.9S99.4 3 94.9 3.9c-4.5.9-5.7 5.7-5.7 5.7s-2.8-5-12.3-3.9-11.1 6-11.1 6-1.2-1.4-4-.7c-.8.2-1.3.5-1.8.9-.9-2.1-2.7-4.9-6.2-4.4-3.2.4-4 2.2-4 2.2s-.5-.7-1.2-.7h-1.4s-.5-.9-1.7-1.4-2.4 0-2.4 0-2.4-1.2-4.7 0-3.1 4.1-3.1 4.1-1.7-1.4-3.6-.7c-1.9.7-1.9 2.8-1.9 2.8s-.5-.5-1.7-.2c-1.2.2-1.4.7-1.4.7s-.7-2.3-2.8-2.8c-2.1-.5-4.3.2-4.3.2s-1.7-5-11.1-6c-3.8-.4-6.6.2-8.5 1v21.2h283.5V11.1c-.9.2-1.6.4-1.6.4s-5.2-8-16.1-8z"></path>
                      </svg>
                      </div>
                    </section>

                    <section class="classes services" id="services">
                      <div class="container">
                        <div class="row">

                          <div class="col-lg-4 col-sm-6 col-xs-12">
                          					<div class="class-item">
                          						<div class="image">
                          						</div>
                          						<ul class="schedule">
                          							<li>
                          								<span>حجم القسم</span>
                          								<span>30 - 40</span>
                          							</li>
                          							<li>
                          								<span>السن</span>
                          								<span>1-2</span>
                          							</li>
                          							<li>
                          								<span>السعر</span>
                          								<span>$1500</span>
                          							</li>
                          						</ul>
                          						<div class="content">
                          							<h4><a href="webpage.php?page=services">الأطفال الصغار </a></h4>
                                        <p>في هذا البرنامج، سيبدأ الأطفال الصغار في التعبير عن أفكارهم ومشاعرهم وسيبدأون في تطوير العلاقات مع بعضهم البعض. سيشجع مقدمو الرعاية الأطفال الصغار على تحويل أفكارهم إلى كلمات وعبارات للتعبير عن أنفسهم بشكل أفضل ، لممارسة قيمة المشاركة والتعاون من خلال اللعب الجماعي. سيبدأ الأطفال في هذه المرحلة في تكوين صداقات واكتساب الثقة أثناء استخدامهم كلماتهم وأفكارهم للتفاعل مع الآخرين.
</p>
                          						</div>
                          						<div class="address">
                          							<p><span><i class="fa fa-home" aria-hidden="true"></i></span> KG1</p>
                          						</div>
                          					</div><!-- class item -->
                          				</div>
                                  <div class="col-lg-4 col-sm-6 col-xs-12">
                                            <div class="class-item">
                                              <div class="image">
                                              </div>
                                              <ul class="schedule">
                                                <li>
                                                  <span>حجم القسم</span>
                                                  <span>30 - 40</span>
                                                </li>
                                                <li>
                                                  <span>السن</span>
                                                  <span>2-3</span>
                                                </li>
                                                <li>
                                                  <span>السعر</span>
                                                  <span>$1500</span>
                                                </li>
                                              </ul>
                                              <div class="content">
                                                <h4><a href="webpage.php?page=services">مرحلة ما قبل المدرسة المبكرة</a></h4>
                                                <p>يتمتع الأطفال في سن ما قبل المدرسة بكمية مذهلة من الطاقة ، وإحساس فطري بالفضول للعالم من حولهم ويعملون بنشاط نحو العديد من مهارات المساعدة الذاتية، لتسخير هذه الطاقة والفضول الفطري بالإضافة إلى بناء هذه المهارات ، سنقدم التدريب على استخدام الحمام، ونشجع اللعب الموازي، ونشجع الإطعام الذاتي بالملاعق واستخدام الكؤوس العادية.
إن مقدمي الرعاية النشطين حريصون على تعزيز ودعم هذه الحاجة للاستقلالية مع توفير العديد من الفرص للأطفال لاتخاذ خيارات آمنة في بيئة محفزة. بالإضافة إلى ذلك ، فإن التعزيز الإيجابي والعناق والثناء والكلمات اللطيفة والمكافآت البسيطة تساعد في جعل هذه الرحلة إلى الاستقلال مشجعة وناجحة. كما هو الحال دائمًا ، سيتم تعزيز هذا النمو والتطور في جميع مجالات التعلم.
</p>
                                              </div>
                                              <div class="address">
                                                <p><span><i class="fa fa-home" aria-hidden="true"></i></span> KG2</p>
                                              </div>
                                            </div><!-- class item -->
                                          </div>


                                          <div class="col-lg-4 col-sm-6 col-xs-12">
                                                    <div class="class-item">
                                                      <div class="image">
                                                      </div>
                                                      <ul class="schedule">
                                                        <li>
                                                          <span>حجم القسم</span>
                                                          <span>30 - 40</span>
                                                        </li>
                                                        <li>
                                                          <span>السن</span>
                                                          <span>3-4</span>
                                                        </li>
                                                        <li>
                                                          <span>السعر</span>
                                                          <span>$1500</span>
                                                        </li>
                                                      </ul>
                                                      <div class="content">
                                                        <h4><a href="webpage.php?page=services">الاستعداد لمرحلة ما قبل المدرسة  </a></h4>
                                                        <p>إن "الاستعداد لمرحلة ما قبل المدرسة لرياض الأطفال" مليء بالعجب ويقضي الأطفال وقتهم في مراقبة واستكشاف العالم من حولهم، إنهم يحبون اللعب بالكلمات واللغة،  ينتقل أطفال ما قبل المدرسة إلى اللعب التعاوني ، لذلك تم تصميم مراكز الفصول الدراسية لمجموعات صغيرة من الأطفال للتفاعل وصقل مهاراتهم الاجتماعية.
إن تعزيز المهارات الأساسية للسماح لمرحلة ما قبل المدرسة بتوسيع آفاقهم والبحث عن المعلومات من خلال استكشاف مناطق جديدة في بيئة داعمة وآمنة هو هدفنا الأول. 
يدرك مقدمو الرعاية أن الأطفال يتعلمون من خلال التكرار ويقدمون مجموعة متنوعة من أنشطة التعلم العملي التي تسمح للأطفال بممارسة وإتقان أهداف المناهج الدراسية المناسبة من الناحية التنموية.
</p>
                                                      </div>
                                                      <div class="address">
                                                        <p><span><i class="fa fa-home" aria-hidden="true"></i></span> KG3</p>
                                                      </div>
                                                    </div><!-- class item -->
                                                  </div>



                        </div>
                      </div>
                      <div class="sg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 283.5 27.8" preserveAspectRatio="xMidYMax slice">
                        <path class="elementor-shape-fill" d="M265.8 3.5c-10.9 0-15.9 6.2-15.9 6.2s-3.6-3.5-9.2-.9c-9.1 4.1-4.4 13.4-4.4 13.4s-1.2.2-1.9.9c-.6.7-.5 1.9-.5 1.9s-1-.5-2.3-.2c-1.3.3-1.6 1.4-1.6 1.4s.4-3.4-1.5-5c-3.9-3.4-8.3-.2-8.3-.2s-.6-.7-.9-.9c-.4-.2-1.2-.2-1.2-.2s-4.4-3.6-11.5-2.6-10.4 7.9-10.4 7.9-.5-3.3-3.9-4.9c-4.8-2.4-7.4 0-7.4 0s2.4-4.1-1.9-6.4-6.2 1.2-6.2 1.2-.9-.5-2.1-.5-2.3 1.1-2.3 1.1.1-.7-1.1-1.1c-1.2-.4-2 0-2 0s3.6-6.8-3.5-8.9c-6-1.8-7.9 2.6-8.4 4-.1-.3-.4-.7-.9-1.1-1-.7-1.3-.5-1.3-.5s1-4-1.7-5.2c-2.7-1.2-4.2 1.1-4.2 1.1s-3.1-1-5.7 1.4-2.1 5.5-2.1 5.5-.9 0-2.1.7-1.4 1.7-1.4 1.7-1.7-1.2-4.3-1.2c-2.6 0-4.5 1.2-4.5 1.2s-.7-1.5-2.8-2.4c-2.1-.9-4 0-4 0s2.6-5.9-4.7-9c-7.3-3.1-12.6 3.3-12.6 3.3s-.9 0-1.9.2c-.9.2-1.5.9-1.5.9S99.4 3 94.9 3.9c-4.5.9-5.7 5.7-5.7 5.7s-2.8-5-12.3-3.9-11.1 6-11.1 6-1.2-1.4-4-.7c-.8.2-1.3.5-1.8.9-.9-2.1-2.7-4.9-6.2-4.4-3.2.4-4 2.2-4 2.2s-.5-.7-1.2-.7h-1.4s-.5-.9-1.7-1.4-2.4 0-2.4 0-2.4-1.2-4.7 0-3.1 4.1-3.1 4.1-1.7-1.4-3.6-.7c-1.9.7-1.9 2.8-1.9 2.8s-.5-.5-1.7-.2c-1.2.2-1.4.7-1.4.7s-.7-2.3-2.8-2.8c-2.1-.5-4.3.2-4.3.2s-1.7-5-11.1-6c-3.8-.4-6.6.2-8.5 1v21.2h283.5V11.1c-.9.2-1.6.4-1.6.4s-5.2-8-16.1-8z"></path>
                      </svg>
                      </div>
                    </section>


                    <section class="sv2">
                      <div class="container">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="content-s s2">
                              <h3>ما بعد الحضانة </h3>
                              <p>في ربيز نساعد الأب والأم العاملين ، ونوفر بيئة آمنة لأطفالنا من بعد انتهاء الروضة إلى حين استلامهم من أهاليهم ، يستمتع الأطفال معنا في هذه الفترة بوجبة الغداء، وراحة ما بعد الظهر بالإضافة إلى تنمية المهارات من خلال اللعب الموجه حتى الساعة الرابعة مساءً  .
</p>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="img" style="text-align:center">
                              <img src="<?php echo $images ?>1.png" alt="image" style="width:80px">
                            </div>
                          </div>
                          <div class="col-md-6">

                          </div>
                          <div class="col-md-6">
                            <div class="content-s s3">
                              <h3>التأسيس التربوية </h3>
<p>نقدم هذه الخدمة للأهالي في التأسيس التربوي للقراءة والكتابة لأبنائنا الطلاب المنتسبين التعليم العام من الصف الأول الابتدائي إلى الثالث الابتدائي، مع مجموعة من الأنشطة والبرامج التربوية القيمية في الفترة المسائية .
</p>
                            </div>
                          </div>
                          <div class="col-md-6">

                          </div>
                          <div class="col-md-6">

                          </div>

                          <div class="col-md-6">
                            <div class="content-s s4">
                              <h3>المتابعة التربوية   </h3>
<p>نقدم هذه الخدمة للأهالي في متابعة أبناءنا الطلاب تعليمياً من الصف الرابع الابتدائي إلى السادس الابتدائي، مع مجموعة من الأنشطة والبرامج التربوية القيمية في الفترة المسائية .
</p>
                            </div>
                          </div>
                          <div class="col-md-6">

                          </div>
                          <div class="col-md-6">

                          </div>


                          <div class="col-md-6">
                            <div class="content-s s5">
                              <h3>المخيمات   </h3>
                              <p>خبرتنا المميزة في برامج وأنشطة مرحلة الطفولة تبلورت في تقديم مخيمات مثيرة للأطفال دون سن الثانية عشر، وهذه المرحلة العمرية مليئة بالأنشطة التعليمية الجذابة حيث يشارك الأطفال في التعلم القائم على اللعب المرتبط بموضوع الأسبوع خلال المخيمات التربوية .
</p>
                            </div>
                          </div>


                        </div>
                      </div>
                      <div class="sg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 283.5 27.8" preserveAspectRatio="xMidYMax slice">
                        <path class="elementor-shape-fill" d="M265.8 3.5c-10.9 0-15.9 6.2-15.9 6.2s-3.6-3.5-9.2-.9c-9.1 4.1-4.4 13.4-4.4 13.4s-1.2.2-1.9.9c-.6.7-.5 1.9-.5 1.9s-1-.5-2.3-.2c-1.3.3-1.6 1.4-1.6 1.4s.4-3.4-1.5-5c-3.9-3.4-8.3-.2-8.3-.2s-.6-.7-.9-.9c-.4-.2-1.2-.2-1.2-.2s-4.4-3.6-11.5-2.6-10.4 7.9-10.4 7.9-.5-3.3-3.9-4.9c-4.8-2.4-7.4 0-7.4 0s2.4-4.1-1.9-6.4-6.2 1.2-6.2 1.2-.9-.5-2.1-.5-2.3 1.1-2.3 1.1.1-.7-1.1-1.1c-1.2-.4-2 0-2 0s3.6-6.8-3.5-8.9c-6-1.8-7.9 2.6-8.4 4-.1-.3-.4-.7-.9-1.1-1-.7-1.3-.5-1.3-.5s1-4-1.7-5.2c-2.7-1.2-4.2 1.1-4.2 1.1s-3.1-1-5.7 1.4-2.1 5.5-2.1 5.5-.9 0-2.1.7-1.4 1.7-1.4 1.7-1.7-1.2-4.3-1.2c-2.6 0-4.5 1.2-4.5 1.2s-.7-1.5-2.8-2.4c-2.1-.9-4 0-4 0s2.6-5.9-4.7-9c-7.3-3.1-12.6 3.3-12.6 3.3s-.9 0-1.9.2c-.9.2-1.5.9-1.5.9S99.4 3 94.9 3.9c-4.5.9-5.7 5.7-5.7 5.7s-2.8-5-12.3-3.9-11.1 6-11.1 6-1.2-1.4-4-.7c-.8.2-1.3.5-1.8.9-.9-2.1-2.7-4.9-6.2-4.4-3.2.4-4 2.2-4 2.2s-.5-.7-1.2-.7h-1.4s-.5-.9-1.7-1.4-2.4 0-2.4 0-2.4-1.2-4.7 0-3.1 4.1-3.1 4.1-1.7-1.4-3.6-.7c-1.9.7-1.9 2.8-1.9 2.8s-.5-.5-1.7-.2c-1.2.2-1.4.7-1.4.7s-.7-2.3-2.8-2.8c-2.1-.5-4.3.2-4.3.2s-1.7-5-11.1-6c-3.8-.4-6.6.2-8.5 1v21.2h283.5V11.1c-.9.2-1.6.4-1.6.4s-5.2-8-16.1-8z"></path>
                      </svg>
                      </div>
                    </section>


                    <section class="sv3">
                      <div class="container">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="content-header">
                              <h1>التدريب</h1>
                              <p>تقدم ربيز خدمات التدريب النوعي للراغبين في الالتحاق بالعمل في مراكز الأطفال، من خلال اعتمادات مهنية دولية، وتشمل خدمات في الفترة الحالية، المجالات التالية:
</p>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="box">
                              <h4>دبلوم مساعدة المربية </h4>
                              <span>50 ساعة تدريبية</span>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="box">
                              <h4>دبلوم مربية الأطفال في مراكز الطفولة  </h4>
                              <span>200 ساعة تدريبية</span>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="box">
                              <h4>	دبلوم مديرة مركز للطفولة </h4>
                              <span>375 ساعة تدريبية</span>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="cte" style="text-align:center;margin:20px 0">
                              <p style="font-size:18px;color:black">كما يوفر المركز خدمات التدريب التربوي للأهالي في مجال إدارة المنزل، والتربية الوالدية من خلال مدربين مؤهلين .
</p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="sg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 283.5 27.8" preserveAspectRatio="xMidYMax slice">
                        <path class="elementor-shape-fill" d="M265.8 3.5c-10.9 0-15.9 6.2-15.9 6.2s-3.6-3.5-9.2-.9c-9.1 4.1-4.4 13.4-4.4 13.4s-1.2.2-1.9.9c-.6.7-.5 1.9-.5 1.9s-1-.5-2.3-.2c-1.3.3-1.6 1.4-1.6 1.4s.4-3.4-1.5-5c-3.9-3.4-8.3-.2-8.3-.2s-.6-.7-.9-.9c-.4-.2-1.2-.2-1.2-.2s-4.4-3.6-11.5-2.6-10.4 7.9-10.4 7.9-.5-3.3-3.9-4.9c-4.8-2.4-7.4 0-7.4 0s2.4-4.1-1.9-6.4-6.2 1.2-6.2 1.2-.9-.5-2.1-.5-2.3 1.1-2.3 1.1.1-.7-1.1-1.1c-1.2-.4-2 0-2 0s3.6-6.8-3.5-8.9c-6-1.8-7.9 2.6-8.4 4-.1-.3-.4-.7-.9-1.1-1-.7-1.3-.5-1.3-.5s1-4-1.7-5.2c-2.7-1.2-4.2 1.1-4.2 1.1s-3.1-1-5.7 1.4-2.1 5.5-2.1 5.5-.9 0-2.1.7-1.4 1.7-1.4 1.7-1.7-1.2-4.3-1.2c-2.6 0-4.5 1.2-4.5 1.2s-.7-1.5-2.8-2.4c-2.1-.9-4 0-4 0s2.6-5.9-4.7-9c-7.3-3.1-12.6 3.3-12.6 3.3s-.9 0-1.9.2c-.9.2-1.5.9-1.5.9S99.4 3 94.9 3.9c-4.5.9-5.7 5.7-5.7 5.7s-2.8-5-12.3-3.9-11.1 6-11.1 6-1.2-1.4-4-.7c-.8.2-1.3.5-1.8.9-.9-2.1-2.7-4.9-6.2-4.4-3.2.4-4 2.2-4 2.2s-.5-.7-1.2-.7h-1.4s-.5-.9-1.7-1.4-2.4 0-2.4 0-2.4-1.2-4.7 0-3.1 4.1-3.1 4.1-1.7-1.4-3.6-.7c-1.9.7-1.9 2.8-1.9 2.8s-.5-.5-1.7-.2c-1.2.2-1.4.7-1.4.7s-.7-2.3-2.8-2.8c-2.1-.5-4.3.2-4.3.2s-1.7-5-11.1-6c-3.8-.4-6.6.2-8.5 1v21.2h283.5V11.1c-.9.2-1.6.4-1.6.4s-5.2-8-16.1-8z"></path>
                      </svg>
                      </div>
                    </section>

                    <section class="sv4">
                      <div class="container">
                        <div class="row justify-content-center">
                          <div class="col-md-12">
                            <div class="content-header">
                              <h1>	المناهج التربوية </h1>

                            </div>
                          </div>
                          <div class="col-md-8">
                            <div class="text">
                              <p>في ربيز  تم تطوير منهج "ربيز" الخاص بنا وتصميمه خصيصًا ليعكس التزامنا بالاهتمام بالقيم الدينية، والدراسات التربوية الحديثة في مجال تعليم التفكير للطفولة المبكرة، وتقديم خبرات تعليمية عالية الجودة في تنشئة وتعليم الصغار. 
</p>
<p> نحن نضمن تعرض الأطفال لجميع مجالات التعلم والنمو بطريقة شاملة، من التعلم الديني إلى محو الأمية المبكرة والحساب المبكر إلى التعبير الإبداعي، والعلوم والتكنولوجيا والهندسة والرياضيات والمهارات البدنية، والأهم من ذلك التربية الأخلاقية .
</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
          <?php


        include $tpl . 'footer.php';
      }
      elseif ($page == "projects") {
              $noNavbar = '';
              $pageTitle = 'wise group - our projects';
              include 'init.php';
      ?>
      <section class="page-header page-header-modern bg-color-primary page-header-md" style="background-image:url('<?php echo $images ?>bg.jpg');background-size:cover" >
            <div class="container">
              <div class="row">


                <div class="col-md-12 order-2 order-md-1 align-self-center p-static" style="text-align:center">
                  <h1 style="text-align:center">projects </h1>

                </div>
              </div>
            </div>
          </section>

          <?php

            $stmts = $conn->prepare("SELECT * FROM portfolio ORDER BY id DESC ");
            $stmts->execute();
            $posts = $stmts->fetchAll();


               ?>


              <div class="posts card-styles blog-card-style-2" style="margin: 60px 0 !important">
                <div class="container">
                  <div class="row">


                <?php

                  foreach ($posts as $post)
                  {
                    ?>
                    <div class="col-md-3">
              <div class="blog-card-2">
              <img src="<?php echo $images . $post['image'] ?>" style="width:100%">
              <div class="card-hf">
              <span class="date">2022-07-02</span>
              <h1><?php echo $post['title']  ?></h1>
              <p></p>
                <a href="<?php echo $post['youtube'] ?>" target="_blank"> <i class="fas fa-long-arrow-alt-right"></i> more</a>
              </div>
              </div>
              </div>
                    <?php
                  }
                 ?>




                  </div>
                </div>
              </div>


      <?php
              include $tpl . 'footer.php';

            }
elseif ($page == "contactus") {
        $noNavbar = '';
        $pageTitle = 'تواصل معنا';
        include 'init.php';
?>

<div class="main">

      <div class="container">


				<div class="row mt-5">



				</div>

				<hr class="solid">

				<div class="row justify-content-center pt-4 mb-4">



					<div class="col-lg-6">
						 <script type="text/javascript">
//<![CDATA[
Sys.WebForms.PageRequestManager._initialize('ScriptManager1', 'form1', ['tUpdatePanel1',''], [], [], 90, '');
//]]>
</script>


<div id="UpdatePanel1">



						<h4 class="font-weight-semibold mb-4" style="text-align:right">ارسل لنا رسالة</h4>
					 <form class="contact-form" action="" method="post" id="form-sd">
             <div class="contact-form" novalidate="novalidate">

               <div class="form-row">
                 <div class="err-msg" style="width:100%">

                 </div>
               </div>
               <div class="form-row">
                 <div class="form-group col">


                   <span id="RequiredFieldValidator7" style="color:Red;display:none;"></span>

                                                  <input name="name" type="text" id="TextBox1" class="form-control" placeholder="اسم الكامل: " data-constraints="@LettersOnly @NotEmpty">

                 </div>
               </div>
               <div class="form-row">
                 <div class="form-group col">
                    <span id="RequiredFieldValidator9" style="color:Red;display:none;"></span>
                                                  <input name="phone" type="text" id="TextBox2" class="form-control" placeholder="الهاتف: " data-constraints="@NotEmpty">
                 </div>
               </div>
               <div class="form-row">
                 <div class="form-group col">

                   <span id="RequiredFieldValidator8" style="color:Red;display:none;"></span>
                                                  <span id="RegularExpressionValidator2" style="color:Red;display:none;"></span>
                                                  <input name="email" type="text" id="TextBox3" class="form-control" placeholder="البريد الالكتروني: " data-constraints="@Email @NotEmpty">

                 </div>
               </div>

               <div class="form-row">
                 <div class="form-group col">

                    <span id="RequiredFieldValidator11" style="color:Red;display:none;"></span>
                                                  <input name="city" type="text" id="TextBox4" class="form-control" placeholder="المدينة: " data-constraints=" @NotEmpty">


                 </div>
               </div>

               <div class="form-row">
                 <div class="form-group col">

                  <span id="RequiredFieldValidator10" style="color:Red;display:none;"></span>
                                                  <input name="title" type="text" id="TextBox5" class="form-control" placeholder="العنوان: " data-constraints=" @NotEmpty">
                 </div>
               </div>













               <div class="form-row">
                 <div class="form-group col">
                    <span id="RequiredFieldValidator12" style="color:Red;display:none;"></span>
                                                  <textarea name="message" rows="5" cols="20" id="TextBox6" class="form-control " placeholder="الرسالة: " data-constraints=" @NotEmpty"></textarea>
                 </div>
               </div>
               <div class="form-row">
                 <div class="form-group col">

                    <input style="background:var(--mainColor);border:none;" type="button" id="sd" name="Button1" value=" ارسل" onclick="javascript:WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions(&quot;Button1&quot;, &quot;&quot;, true, &quot;conform&quot;, &quot;&quot;, false, false))" id="Button1" class="btn btn-primary btn-lg mb-5">
                 </div>
               </div>

             </div>

           </form>
           <div class="err-msg">

           </div>
					</div>

</div>
				</div>

			</div>
</div>
<?php
        include $tpl . 'footer.php';

      }
      elseif ($page == "service") {
              $noNavbar = '';
              $pageTitle = 'مدارك - الخدمات';
              include 'init.php';

              $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : header('location: services.php');
              $stmt = $conn->prepare("SELECT * FROM services WHERE id = ? LIMIT 1");
              $stmt->execute(array($id));
              $info = $stmt->fetch();
              $check = $stmt->rowCount();
      ?>

      <div class="main" style="background-image:url(<?php echo $images ?>42.jpg)">
        <section class="page-header page-header-modern bg-color-primary page-header-md">
      				<div class="container">
      					<div class="row">
      						<div class="col-md-8 order-2 order-md-1 align-self-center p-static">
      							<h1><?php echo $info['name'] ?></h1>

      						</div>
      						<div class="col-md-4 order-1 order-md-2 align-self-center">
      							<ul class="breadcrumb d-block text-md-right breadcrumb-light">
      								<li><a href="index.php">الرئيسية</a></li>
      								<li><a href="services">خدماتنا</a></li>
      								<li class="active"><?php echo $info['name'] ?></li>
      							</ul>
      						</div>
      					</div>
      				</div>
      			</section>
            <div class="container">

    				<div class="row justify-content-end py-5">
    							<div class="col-lg-6" style="text-align:right">
    								<p class="text-uppercase font-weight-semibold mb-1 text-color-primary appear-animation animated fadeInRightShorter appear-animation-visible" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="100" style="animation-delay: 100ms;"><span class="line-pre-title bg-color-primary"></span>مكتب المهندس سعد الربيعي للاستشارات الهندسية
    </p>
    								<h2 class="font-weight-bolder text-capitalize mb-4 custom-letter-spacing-2 custom-text-1 appear-animation animated fadeInRightShorter appear-animation-visible" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="200" style="animation-delay: 200ms;"><?php echo $info['name'] ?></h2>
    								<p class="font-weight-semibold mb-3 appear-animation animated fadeInRightShorter appear-animation-visible" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="300" style="animation-delay: 300ms;">   </p><p></p><p style="text-align: right;">- تصميم كافة أنظمة السلامة الهندسية وفق معايير عالمية.</p>
    <p style="text-align: right;"><?php echo $info['description'] ?></p>


    								<div class="d-flex align-items-center justify-content-start appear-animation animated fadeIn appear-animation-visible" data-appear-animation="fadeIn" data-appear-animation-delay="600" style="animation-delay: 600ms;">




    								</div>
    							</div>
    							<div class="col-lg-6 pt-4 pt-lg-0">
    								<div class="  border-0 mt-4 mt-lg-0 ml-lg-3 p-3 mb-3 mb-lg-0">
    								<img src="<?php echo $images . $info['image'] ?>" class="img-fluid border-radius-0" alt="">
    							</div>
    						</div>
    							</div>

    			</div>
      </div>
      <?php
              include $tpl . 'footer.php';

            }


      else {
        header('location: index.php');
      }



  ob_end_flush();

  ?>
