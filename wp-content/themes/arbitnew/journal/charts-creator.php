<?php $user = wp_get_current_user(); ?>
<script>
    $( document ).ready(function() {
        new getCurrentAllocation(<?php echo $user->ID; ?>);
    });
</script>