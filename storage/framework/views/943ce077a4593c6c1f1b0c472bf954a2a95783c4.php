
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>List View Join</h2>
            </div>
        </div>
    </div>
    <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success">
            <p><?php echo e($message); ?></p>
        </div>
    <?php endif; ?>
    <table class="table table-bordered">
        <tr>
            <th>Champion</th>
            <th>Description</th>
            <th>Position</th>
            <th>Job</th>
        </tr>
        <?php $__currentLoopData = $joins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $join): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($join->nama_champion); ?></td>
            <td><?php echo e($join->desc_champion); ?></td>
            <td><?php echo e($join->nama_position); ?></td>
            <td><?php echo e($join->nama_job); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
    <?php echo $joins->links(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Semester 5\Prak SBD\TA\coba-ta-sbd\resources\views/totals/index.blade.php ENDPATH**/ ?>