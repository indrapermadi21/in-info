<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang('index_heading');?>
		<small><?php echo lang('index_subheading');?></small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<a href="<?php echo site_url();?>">
				<i class="fa fa-fw ti-home"></i> Home
			</a>
		</li>
		<li>
			<a href="<?php echo site_url('auth');?>">User</a>
		</li>
		<li class="active">Index</li>
	</ol>
</section>
<!-- Main content -->
<section class="content p-l-r-15">
	<div class="row">
		<div class="col-lg-12">
			<!-- First Basic Table strats here-->
			<div class="panel ">
				<div class="panel-heading">
					<h3 class="panel-title">
						<i class="ti-layout-cta-left"></i> Users
					</h3>
					<span class="pull-right">
						<i class="fa fa-fw ti-angle-up clickable"></i>
						<i class="fa fa-fw ti-close removepanel clickable"></i>
					</span>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<?php 
								if ($this->ion_auth->is_admin()):
								echo anchor('auth/create_user', lang('index_create_user_link'),array('class'=>'btn btn-primary pull-sm'));
							?>
								&nbsp;&nbsp;&nbsp;
							<?php
								echo anchor('auth/create_group', lang('index_create_group_link'),array('class'=>'btn btn-primary pull-sm'));
								endif;
							?>
						</div>
					</div>
					<div class="row">
						<hr>
					</div>
					<div class="row" id="infoMessage">
						<div class="col-md-12">
							<?php echo $message;?>
						</div>
					</div>
					<div class="table-responsive">
						<table class="table table-striped" id="mytable">
							<thead>
							<tr>
								<th><?php echo lang('index_fname_th');?></th>
								<th><?php echo lang('index_lname_th');?></th>
								<th><?php echo lang('index_email_th');?></th>
								<th><?php echo lang('index_groups_th');?></th>
								<th><?php echo lang('index_status_th');?></th>
								<th><?php echo lang('index_action_th');?></th>
							</tr>
							</thead>
							<tbody>
							<?php foreach ($users as $user):?>
								<tr>
									<td><?php echo htmlspecialchars($user->name,ENT_QUOTES,'UTF-8');?></td>
									<td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
									<td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
									<td>
										<?php foreach ($user->groups as $group):?>
											<?php echo htmlspecialchars($group->name,ENT_QUOTES,'UTF-8') ;?><br />
										<?php endforeach?>
									</td>
									<td>
										<?php if ( $this->ion_auth->is_admin()):?>
										<?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link'),array('class'=>'btn btn-default dropdown-toggle')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'),array('class'=>'btn btn-default dropdown-toggle'));?>
										<?php endif;?>
									</td>
									<td>
										<?php if ( $this->ion_auth->is_admin() || $this->ion_auth->user()->row()->id == $user->id):?>
										<?php echo anchor("auth/edit_user/".$user->id, 'Edit',array('class'=>'btn btn-default dropdown-toggle')) ;?>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>