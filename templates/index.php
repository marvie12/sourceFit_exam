<?php include INCLUDE_PATH.'/head.inc.php' ?>
<section id="content">
    <table class="table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Date of Birth</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($users)): ?>                
                <?php foreach ($users as $user): ?>                    
                    <tr>
                        <td><?php echo $user->user_id; ?></td>
                        <td width="150px"><?php echo $user->name; ?></td>
                        <td width="150px"><?php echo $user->address; ?></td>
                        <td><?php echo $user->mobile; ?></td>
                        <td><a href="#"><?php echo $user->email; ?></a></td>
                        <td><?php echo date("M d, Y", $user->birthdate); ?></td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-small" href="/edit/<?php echo $user->user_id; ?>"><i class="icon-edit"></i> Edit</a>
                                <a class="btn btn-small" href="/delete/<?php echo $user->user_id; ?>"><i class="icon-trash"></i> Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr><td colspan="7"><center><i>No Record.</i></center></td></tr>
            <?php endif ?>
        </tbody>
    </table>
    <div class="row-fluid">
        <a href="/add" class="btn"><i class="icon-plus"></i> Add Record</a>
    </div>
</section>
<?php include INCLUDE_PATH.'/footer.inc.php' ?>