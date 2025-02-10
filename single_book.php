<?php require_once('includes/init.php'); ?>

<div class="single_left">
    <div style="text-align: center; margin: 10px 0 auto;">
        <a href="index.php" class="left_btn"><i class="fas fa-hand-point-left"></i></a>
        <a href="#" class="left_btn chapters"><i class="fas fa-list-alt"></i></a>
        <a href="#" class="left_btn settings"><i class="fas fa-cog"></i></a>
    </div>
    <hr>
    <div class="left_content"></div>
</div>
<div class="single_right" style="overflow: scroll; padding: 20px;"></div>

<input type="text" id="book_id_for_jq" hidden="hidden" value="<?php echo $_GET['book_id'] ?>">
<input type="text" id="hi_for_jq" hidden="hidden" value="">
<input type="text" id="font_family_for_jq" hidden="hidden" value="Times New Roman">
<input type="text" id="font_size_for_jq" hidden="hidden" value="<?php echo round(12 * 1.33); ?>">
<input type="text" id="text_align_for_jq" hidden="hidden" value="justify">

<script>
    
    $(document).ready(function(){
        
        var book_id_for_jq = $('#book_id_for_jq').attr('value');
        var hi_for_jq = $('#hi_for_jq').attr('value');
        var font_family_for_jq = $('#font_family_for_jq').attr('value');
        var font_size_for_jq = $('#font_size_for_jq').attr('value');
        var text_align_for_jq = $('#text_align_for_jq').attr('value');
        
        $('.left_content').html($('.left_chapters').html());
        
        $.post(
            'includes/jquery/get_book_content.php',
            {
                book_id: book_id_for_jq
            },
            function(data) {
                
                $('.single_right').html(data);
                
            }
        )
        
        $.post(
            'includes/jquery/get_left_chapters.php',
            {
                book_id: book_id_for_jq,
                hi: hi_for_jq,
                font_family: font_family_for_jq,
                font_size: font_size_for_jq,
                text_align: text_align_for_jq
            },
            function(data) {
                
                $('.left_content').html(data);
                
            }
        )
        
        $('.chapters').click(function(e){
            
            e.preventDefault();
            
            $.post(
                'includes/jquery/get_left_chapters.php',
                {
                    book_id: book_id_for_jq
                },
                function(data) {
                    
                    $('.left_content').html(data);
                    
                }
            )
            
        })
        
        $('.settings').click(function(e){
            
            e.preventDefault();
            
            $.post(
                'includes/jquery/get_left_settings.php',
                {
                    
                },
                function(data) {
                    
                    $('.left_content').html(data);
                    
                }
            )
            
        })
        
    })
    
</script>

<?php require_once('includes/layout/footer.php'); ?>