jQuery(document).ready(function(){
    console.log( 'Activating Sortable List' );
    jQuery('label.styleTitle').click(function(){
        var parent = jQuery(this).parents('li').eq(0);
        jQuery(this).hide();
        jQuery(parent).find('input.styleTag').show().focus();
    });
    jQuery('input.styleTag').keyup(function(e){
        if( e.which == 13 ){
            e.preventDefault = true;
            var parent = jQuery(this).parents('li').eq(0);
            var label = jQuery(parent).find('label.styleTitle');
            label.text( jQuery(this).val() );
            jQuery(this).hide();
            jQuery(label).show();
        }
    });
    activateSortableList();
});

function activateSortableList()
{
    var list = jQuery('#sortableStyles');
    jQuery(list).sortable();
    jQuery(list).disableSelection();
}
