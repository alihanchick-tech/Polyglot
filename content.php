<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Kitaplar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.php">Baş Sahypa</a></li>
                    <li class="breadcrumb-item active">Kitaplar</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
      
        <div class="row">
          
            <?php
                
                if(isset($_GET['genre_id']))
                {
                    $book_info = $data_class->get_data('books', 'genre_id', $_GET['genre_id']);
                } else if(isset($_GET['writer_id']))
                {
                    $book_info = $data_class->get_data('books', 'writer_id', $_GET['writer_id']);
                } else
                {
                    $book_info = $data_class->get_data('books');
                }
                
                if(empty($book_info))
                {
                    echo '<h3 style="color: crimson;">Goşulan kitap ýok</h3>';
                } else
                {
                    foreach($book_info as $key => $val)
                    {
                        $xp_book_content = explode(" --- ", $val['book_content']);
                
            ?>
            
            <div class="col-lg-2 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <div style="height: 110px;">
                            <h5><?php echo $val['book_name']; ?></h5>
                            <p><?php echo $data_class->get_data('writers', 'writer_id', $val['writer_id'])[0]['writer_name']; ?></p>
                        </div>
                        <img src="<?php if(!empty($val['book_cover'])) { echo $val['book_cover']; } else { echo 'img/photo.png'; } ?>"
                            style="width: 100%; height: auto;">
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="single_book.php?book_id=<?php echo $val['book_id']; ?>" class="small-box-footer">
                        Okamak üçin <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            
            <?php } } ?>
          
        </div>
      
    </div>
</section>