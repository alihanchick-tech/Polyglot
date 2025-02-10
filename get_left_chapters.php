<?php require_once('../data_class.php'); ?>

<?php
    
    if(isset($_POST['book_id']))
    {
        $book_id = $_POST['book_id'];
        $book_info = $data_class->get_data('books', 'book_id', $book_id)[0];
        
        $xp_book_content = explode(' --- ', $book_info['book_content']);
    }
    
?>

<div class="left_chapters">
    
<?php
    
    echo '<ul style="list-style-type: none;">';
    
    for($i = 0; $i < count($xp_book_content); $i++)
    {
        $tag_no = strip_tags($xp_book_content[$i]);
                
        if(substr(htmlentities($xp_book_content[$i]), 4, 1) == 'h')
        {
            $tag_name = substr(htmlentities($xp_book_content[$i]), 4, 2);
            $h_index[] = $i;
            
            if($tag_name == 'h1')
            {
                echo '<li><a href="" class="chapter" title="' . $book_id . '" value="' . $i
                    . '" style="display: inline-block; margin: 0 10px;">' . strtoupper($tag_no) . '</a></li>';
            } else if($tag_name == 'h2')
            {
                echo '<li><a href="" class="chapter" title="' . $book_id . '" value="' . $i
                    . '" style="display: inline-block; margin: 0 20px;">' . $tag_no . '</a></li>';
            } else if($tag_name == 'h3')
            {
                echo '<li><a href="" class="chapter" title="' . $book_id . '" value="' . $i
                    . '" style="display: inline-block; margin: 0 30px;"><i>' . $tag_no . '</i></a></li>';
            }
        }
    }
    
    echo '</ul>';
    
?>

</div>

<script>
    
    book_id_for_jq = $('#book_id_for_jq').attr('value');
    hi_for_jq = $('#hi_for_jq').attr('value');
    font_family_for_jq = $('#font_family_for_jq').attr('value');
    font_size_for_jq = $('#font_size_for_jq').attr('value');
    text_align_for_jq = $('#text_align_for_jq').attr('value');
    
    var chapters = $('.left_chapters ul').children().children();
    
    for(var i = 0; i < chapters.length; i++)
    {
        if(chapters[i].getAttribute('value') == hi_for_jq)
        {
            chapters[i].setAttribute('class', 'chapter sel_chapter');
        }
    }
    
    $('.single_right').css({ 'font-family': font_family_for_jq, 'font-size': font_size_for_jq + 'px', 'text-align': text_align_for_jq });
    
    $('.chapter').click(function(e){
            
        e.preventDefault();
        $('.chapter').removeClass('sel_chapter');
        $(this).toggleClass('sel_chapter');
        var book_id = $(this).attr('title');
        var hi = $(this).attr('value');
        $('#hi_for_jq').attr('value', hi);
        
        $.post(
            'includes/jquery/get_book_content.php',
            {
                book_id: book_id,
                hi: hi
            },
            function(data) {
                
                $('.single_right').html(data);
                
            }
        )
    })
    
</script>