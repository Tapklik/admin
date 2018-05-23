<?php $__env->startSection('breadcrumbs'); ?>
    Manage Bills
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<billing></billing>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>