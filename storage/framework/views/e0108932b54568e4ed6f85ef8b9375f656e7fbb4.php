<?php $__env->startSection('breadcrumbs'); ?>
Edit account
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<accounts-show></accounts-show>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>