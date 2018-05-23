<?php $__env->startSection('breadcrumbs'); ?>
	Manage accounts
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<accounts></accounts>	
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>