<?php $__env->startSection('breadcrumbs'); ?>
    Edit Creative <?php echo e($creativeUuId); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <creative></creative>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>