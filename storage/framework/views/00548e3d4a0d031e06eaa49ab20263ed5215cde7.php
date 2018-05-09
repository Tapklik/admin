<?php $__env->startSection('head_scripts'); ?>
    var obj = {id: '<?php echo $cid; ?>'};
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    Edit campaign
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <campaign-show></campaign-show>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>