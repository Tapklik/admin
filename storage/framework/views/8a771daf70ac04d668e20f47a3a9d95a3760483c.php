<?php $__env->startSection('breadcrumbs'); ?>
    Bid <?php echo e($id); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<bid-show></bid-show>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>