import $ from 'jquery';

import "./admin.scss";

$(function(){
    /**
     * Show hide option on themebuilder  (droit template meta)
     * if select mega menu hide display on,  display not on,  user role 
     * if select 404 hide display on,  display not on,  user role 
     * else display all condition 
     * @since 1.0.0
     */
    let templateType = $('#drdt_template_type');
    let templateTypeVal = templateType.val();
    if(templateTypeVal == '404' || templateTypeVal == 'megamenu') {
        $('#drdt_template_display').parent().hide();
        $('#drdt_template_notdisplay').parent().hide();
        $('#drdt_template_role').parent().hide();
    }
    if(templateTypeVal !== '404') {
        $('.is-active-404-wrapper').hide();
    }
    templateType.on('change', function(){
       if($(this).val() == '404' || $(this).val() == 'megamenu'){
           $(this).parent('.section-block').siblings().hide();
       }else{
        $(this).parent('.section-block').siblings().show();
       }
       if($(this).val() == '404'){ 
         $('.is-active-404-wrapper').show();
       }else{
        $('.is-active-404-wrapper').hide();
       }
    });
     // 404 auto active
     $(document).on('change', '.is-active-404', function(){
  
        let ifon = $(this).val();
         var data = {
          'action': 'theme_404_page_active',
          'post_id': $(this).data('post-id'),
          'status' : ifon
        };
    
          jQuery.post(frontend_ajax_object.ajaxurl, data, function(response) {
             $('.droit-error').html(response);
             $('.droit-error').fadeIn('slow').addClass('show');
          });
        
          setTimeout(close_post_box, 3000);
          function close_post_box() {
            if($('.droit-error.show').length > 0 ){
              $('.droit-error').fadeOut('slow');
            }
          }
      });
});