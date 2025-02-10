<div class="left_settings">
    <h5>Font</h5>
    
    <?php
        
        $fonts = array('Arial', 'Calibri', 'Chaparrel Pro', 'Georgia', 'Bookman Old Style', 'Times New Roman', 'Cambria', 'Comic Sans MS');
        
        for($i = 0; $i < count($fonts); $i++)
        {
            echo '<a href="#" class="font font_family" value="' . $fonts[$i] . '"><span style="font-family: '
                    . $fonts[$i] . ';">' . $fonts[$i] . '</span></a>';
        }
        
    ?>
    
    <hr>
    <h5>Font Ölçegi</h5>
    
    <?php
        
        $font_sizes = array(8, 10, 12, 14, 16, 18, 20);
        
        for($i = 0; $i < count($font_sizes); $i++)
        {
            echo '<a href="" class="font font_size" value="' . round($font_sizes[$i] * 1.33) . '"><span style="font-size: '
                    . $font_sizes[$i] * 1.33 . 'px;">' . $font_sizes[$i] . '</span></a>';
        }
        
    ?>
    
    <hr>
    <h5>Font Ýerleşişi</h5>
    <a href="" class="align text_align" value="left"><i class="fas fa-align-left"></i></a>
    <a href="" class="align text_align" value="center"><i class="fas fa-align-center"></i></a>
    <a href="" class="align text_align" value="right"><i class="fas fa-align-right"></i></a>
    <a href="" class="align text_align" value="justify"><i class="fas fa-align-justify"></i></a>
</div>

<script>
    
    book_id_for_jq = $('#book_id_for_jq').attr('value');
    hi_for_jq = $('#hi_for_jq').attr('value');
    font_family_for_jq = $('#font_family_for_jq').attr('value');
    font_size_for_jq = $('#font_size_for_jq').attr('value');
    text_align_for_jq = $('#text_align_for_jq').attr('value');
    
    var font_familys = $('.font_family');
    var font_sizes = $('.font_size');
    var text_aligns = $('.text_align');
    
    for(var i = 0; i < font_familys.length; i++)
    {
        if(font_familys[i].getAttribute('value') == font_family_for_jq)
        {
            font_familys[i].setAttribute('class', 'font font_family font_active');
        }
    }
    
    for(var i = 0; i < font_sizes.length; i++)
    {
        if(font_sizes[i].getAttribute('value') == font_size_for_jq)
        {
            font_sizes[i].setAttribute('class', 'font font_size font_active');
        }
    }
    
    for(var i = 0; i < text_aligns.length; i++)
    {
        if(text_aligns[i].getAttribute('value') == text_align_for_jq)
        {
            text_aligns[i].setAttribute('class', 'align text_align align_active');
        }
    }
    
    $('.chapters').click(function(e){
            
        e.preventDefault();
        $('.left_content').html($('.left_chapters').html());
        
    })
    
    $('.font_family').click(function(e){
        
        e.preventDefault();
        var font_family = $(this).attr('value');
        
        $('.font_family').removeClass('font_active');
        $(this).toggleClass('font_active');
        $('.single_right').css('font-family', font_family);
        $('#font_family_for_jq').attr('value', font_family);
        
    })
    
    $('.font_size').click(function(e){
        
        e.preventDefault();
        var font_size = $(this).attr('value');
        
        $('.font_size').removeClass('font_active');
        $(this).toggleClass('font_active');
        $('.single_right p').css('font-size', font_size + 'px');
        $('#font_size_for_jq').attr('value', font_size);
        
    })
    
    $('.text_align').click(function(e){
        
        e.preventDefault();
        var text_align = $(this).attr('value');
        
        $('.font_align').removeClass('align_active');
        $(this).toggleClass('align_active');
        $('.single_right').css('text-align', text_align);
        $('#text_align_for_jq').attr('value', text_align);
        
    })
    
</script>