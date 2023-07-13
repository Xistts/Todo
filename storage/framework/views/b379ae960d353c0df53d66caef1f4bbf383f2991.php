
<?php $__env->startSection('styles'); ?>
<style>
   #outer{
      width: auto;
      text-align: center;
   }
   .inner{
      display: inline-block;
   }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-4">
      
   </div>
   <div class="col-md-8">
      <div class="card">
         <div class="card-header"><?php echo e(__('Список')); ?> <a class="btn btn-sm btn-info float-end" href="<?php echo e(route('todos.create' )); ?>">Создать задачу</a></div>
         <div class="card-header">     
            <div class="filter-container">
               <h2>Фильтр</h2>
               <form class="row">
                     <?php echo csrf_field(); ?>
                     <input name="user_id" type="hidden" class="form-control" value="<?php echo e(auth()->user()->id); ?>">
                     <div class="col-md-3">
                        <label for="">Поиск по названию</label>
                        <input name="title" type="text" class="form-control" >
                     </div>

                     <div class="col-md-2">
                        <label for="">Завершено</label>
                        <select name="завершено" class="form-control" >
                           <option value="">Выберите</option>
                           <option value="1">завершено</option>
                           <option value="0">В завершении</option>
                        </select>
                     </div>

                     <div class="col-md-3">
                        <label for="">Теги</label>
                        <input name="tags" type="text" class="form-control" >
                     </div>

                     <div class="col-md-2" style="display: flex;align-items: flex-end;" >
                        <div>
                           <button type="submit" class="btn btn-primary" >Фильтр</button>
                        </div>
                     </div>
               </form>
            </div>
         </div>

         <div id="table" class="card-body">
               
                  

                     <table class="table">
                        <thead>
                           <tr>
                              <th>Название</th>
                              <th>Описание</th>
                              <th>Изображение</th>
                              <th>Теги</th>
                              <th>Завершено</th>
                              <th>Действия</th>
                           </tr>
                        </thead>
                        <tbody>
                        <?php if(count($todos)>0): ?>
                           <?php $__currentLoopData = $todos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $todo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <tr id="<?php echo e($todo->id); ?>">
                              <td><?php echo e($todo->title); ?></td>
                              <td><?php echo e($todo->description); ?></td>
                              <td>
                                 <?php if($todo->image != '' ): ?>
                                    <?php if(in_array( auth()->user()->id , explode(",",$todo->id_user) ) ): ?>
                                       <a class="" href="<?php echo e(route('todos.edit', $todo->id)); ?>"><img src="/images/thumbnail/<?php echo e($todo->image); ?>" width="150px"></a>
                                    <?php else: ?>
                                       <img src="/images/thumbnail/<?php echo e($todo->image); ?>" width="150px">
                                    <?php endif; ?>
                                 <?php endif; ?>
                              </td>
                              <td id="outer">
                                 <?php $__currentLoopData = explode(",",$todo->keywords); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="inner btn-sm btn-info"><?php echo e($tag); ?></label>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </td>
                              <td id="completed-<?php echo e($todo->id); ?>">
                                 <?php if($todo->is_completed == 1 ): ?>
                                    <a class="btn btn-sm btn-success" 
                                          id="btn-completed"
                                       data-completed="0" data-id="<?php echo e($todo->id); ?>">Завершено</a>
                                 <?php else: ?>
                                    <a class="btn btn-sm btn-danger" 
                                          id="btn-completed"
                                        data-completed="1" data-id="<?php echo e($todo->id); ?>">В Работе</a>
                                 <?php endif; ?>
                              </td>
                              <td id="outer">
                                 <a class="inner btn btn-sm btn-success" href="<?php echo e(route('todos.show', $todo->id)); ?>">Посмотреть</a>
                                 <?php if(in_array( auth()->user()->id , explode(",",$todo->id_user) ) ): ?>
                                 <a class="inner btn btn-sm btn-info" href="<?php echo e(route('todos.edit', $todo->id)); ?>">Редактировать</a>
                                 <form class="inner">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <input type="hidden" name="todo_id" value="<?php echo e($todo->id); ?>">
                                    <input id="btn-delete" type="submit" class="btn btn-sm btn-danger" value="Удалить">
                                 </form>
                                 <?php endif; ?>
                              </td>
                           </tr>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        </tbody>
                     </table>
                  
            </div>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\todo\todo-laravel\resources\views/todos/index.blade.php ENDPATH**/ ?>