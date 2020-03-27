<table class="inactiveuserData">
   <thead>
      <tr>
         <th scope="col">ID</th>         
         <th scope="col">Name</th>
         <th scope="col">Email</th>
         <th scope="col">Created On</th>
         <th scope="col">Actions</th>
      </tr>
   </thead>
   <tbody>
      <?php foreach($Get_all_users as $allusers){
		 if($allusers->status == 0){?>
	  <tr>
		 <td scope="col"><?php echo $allusers->admin_id;?></td>
         <td scope="col"><?php echo $allusers->name;?></td>
         <td scope="col"><?php echo $allusers->email;?></td>
         <td scope="col"><?php echo $allusers->createdOn;?></td>
         <td scope="col">
            <a href="javascript:void(0);" data-user='<?php echo json_encode($allusers);?>' class="btn btn-warning btn-xs change_password"><i class="fa fa-key" aria-hidden="true"></i></a>
			<a href="javascript:void(0);" data-user='<?php echo json_encode($allusers);?>' class="btn btn-success btn-xs active"><i class="fas fa-check"></i></a>
            <a href="javascript:void(0);" data-user='<?php echo json_encode($allusers);?>' data-target="#editevent" data-toggle="modal" class="btn btn-warning btn-xs userEdit"><i class="fa fa-pencil"></i></a>
            <a href="javascript:void(0);" data-user='<?php echo json_encode($allusers);?>' data-target="#delete_consultants" data-toggle="modal" class="btn btn-danger btn-xs user_delete"><i class="fa fa-trash"></i></a>
         </td>
      </tr>
		 <?php }} ?>
   </tbody>
</table>