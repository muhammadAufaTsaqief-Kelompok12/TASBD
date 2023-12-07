
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Champion Deleted</h2>
            </div>
            <div class="my-3 col-12 col-sm-8 col-md-5">
                <form action="" method="get">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Keyword" name = "keyword" aria-label="Keyword" aria-describedby="basic-addon1">
                        <button class="input-group-text btn btn-primary" id="basic-addon1">Search</button>
                    </div>
                </form>
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
            <th>ID Champion</th>
            <th>Champion Name</th>
            <th>Description</th>
            <th>Position</th>
            <th>Job</th>
            <th width="280px">Action</th>
        </tr>
        <?php $__currentLoopData = $champions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $champion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($champion->id_champion); ?></td>
            <td><?php echo e($champion->nama_champion); ?></td>
            <td><?php echo e($champion->desc_champion); ?></td>
            <td><?php echo e($champion->id_position); ?></td>
            <td><?php echo e($champion->id_job); ?></td>
            <td>
                <form>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('iwak-delete')): ?>
                    <a class="btn btn-primary" href="trash/<?php echo e($champion ->id_champion); ?>/restore">Restore</a>
                    <?php endif; ?>
                    <?php echo csrf_field(); ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('iwak-delete')): ?>
                    <a class="btn btn-danger" href="trash/<?php echo e($champion->id_champion); ?>/forcedelete" onclick="return confirm('Are you sure?')">Force Delete</a>
                    <?php endif; ?>
                </form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
    <?php echo $champions->links(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Yoga\Kuliah\Semester 5\Praktikum SBD\TA\coba-ta-sbd\resources\views//champions/trash.blade.php ENDPATH**/ ?>