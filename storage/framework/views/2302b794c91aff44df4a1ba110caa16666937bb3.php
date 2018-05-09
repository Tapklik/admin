<?php $__env->startSection('breadcrumbs'); ?>
    Campaign
<?php $__env->stopSection(); ?>

<?php $__env->startSection('head_scripts'); ?>
    var obj = {id: '<?php echo $id; ?>'}
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <campaigns-show></campaigns-show>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modals'); ?>

    <div id="_modal_json" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">
                    <div class="jsonify"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>