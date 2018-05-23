<?php $__env->startSection('head_scripts'); ?>
    var obj = {id: '<?php echo $cid; ?>'};
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    See creatives
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <campaign-creatives></campaign-creatives>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>