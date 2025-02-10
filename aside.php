<aside class="main-sidebar sidebar-light-primary elevation-4">
      
    <a href="index.php" class="brand-link">
        <img src="img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><b>akylly</b><b><b>kitap</b></b></span>
    </a>
    
    <div id="popup_back" style="display: none;"></div>
    <div id="popup_front" style="display: none;">
        <div class="popup_close">
            <i class="fa fa-window-close"></i>
        </div>
        <form method="post" class="login" style="width: 80%;">
            <ul>
                <li>
                    <input type="text" id="username" placeholder="ulanyjy ady">
                </li>
                <li>
                    <input type="password" id="password" placeholder="ulanyjy paroly">
                </li>
                <li>
                    <input type="submit" value="Ulgama gir" class="btn btn-success">
                </li>
                <li>
                    <span id="login_msg" style="color: brown; font-weight: bold;"></span>
                </li>
            </ul>
        </form>
    </div>
    <div id="popup_front2" style="display: none;">
        <div class="popup_close">
            <i class="fa fa-window-close"></i>
        </div>
        <form method="post" class="register" style="width: 80%;">
            <ul>
                <li>
                    <input type="text" id="first_name" placeholder="ady">
                </li>
                <li>
                    <input type="text" id="last_name" placeholder="familiýasy">
                </li>
                <li>
                    <input type="text" id="phone" placeholder="telefon belgisi">
                </li>
                <li>
                    <input type="text" id="username2" placeholder="ulanyjy ady">
                </li>
                <li>
                    <input type="password" id="password2" placeholder="ulanyjy paroly">
                </li>
                <li>
                    <input type="submit" value="Ulanyjy goş" class="btn btn-success">
                </li>
                <li>
                    <span id="register_msg" style="color: brown; font-weight: bold;"></span>
                </li>
            </ul>
        </form>
    </div>

    <div class="sidebar" style="margin-top: 10px;">
      
        <?php if($_SERVER['PHP_SELF'] != '/book_reader/index.php') { ?>
    
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              
                <li class="nav-item">
                    <a href="logout.php" id="sign_out" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Ulgamdan çyk
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="change_password.php" class="nav-link">
                        <i class="nav-icon fas fa-key"></i>
                        <p>
                            Parol üýtget
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="words.php" class="nav-link">
                        <i class="nav-icon fas fa-language"></i>
                        <p>
                            Sözler
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="genres.php" class="nav-link">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            Žanrlar
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="writers.php" class="nav-link">
                        <i class="nav-icon fas fa-feather"></i>
                        <p>
                            Ýazyjylar
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="books.php" class="nav-link">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>
                            Kitaplar
                        </p>
                    </a>
                </li>
              
            </ul>
        </nav>
        
        <?php } else { ?>
        
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              
                <?php if(isset($_SESSION['user'])) { ?>
                
                <li class="nav-item">
                    <a href="admin_panel.php" class="nav-link">
                        <i class="nav-icon fas fa-sliders-h"></i>
                        <p>
                            Panele git
                        </p>
                    </a>
                </li>
                
                <?php } else { ?>
                
                <li class="nav-item">
                    <a href="#" id="sign_in" class="nav-link">
                        <i class="nav-icon fas fa-sign-in-alt"></i>
                        <p>
                            Ulgama gir
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" id="register" class="nav-link">
                        <i class="nav-icon fas fa-sign-in-alt"></i>
                        <p>
                            Agza bol
                        </p>
                    </a>
                </li>
                
                <?php } ?>
              
            </ul>
        </nav>
      
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Gözle" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              
                <li class="nav-header">ŽANRLAR</li>
                
                <?php foreach($data_class->get_data('genres') as $key => $val) { ?>
              
                <li class="nav-item">
                    <a href="index.php?genre_id=<?php echo $val['genre_id']; ?>" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            <?php echo $val['genre_name']; ?>
                            <span class="badge badge-info right">
                                <?php echo count($data_class->get_data('books', 'genre_id', $val['genre_id'])); ?>
                            </span>
                        </p>
                    </a>
                </li>
                
                <?php } ?>
              
                <li class="nav-header">ÝAZYJYLAR</li>
                
                <?php foreach($data_class->get_data('writers') as $key => $val) { ?>
              
                <li class="nav-item">
                    <a href="index.php?writer_id=<?php echo $val['writer_id'] ?>" class="nav-link">
                        <i class="nav-icon fas fa-feather"></i>
                        <p>
                            <?php echo $val['writer_name']; ?>
                            <span class="badge badge-info right">
                                <?php echo count($data_class->get_data('books', 'writer_id', $val['writer_id'])); ?>
                            </span>
                        </p>
                    </a>
                </li>
                
                <?php } ?>
              
            </ul>
        </nav>
        
        <?php } ?>
      
    </div>
  
</aside>