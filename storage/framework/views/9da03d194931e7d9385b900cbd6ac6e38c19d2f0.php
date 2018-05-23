<?php $__env->startSection('breadcrumbs'); ?>
    Manage users
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<users></users>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>