	<section class="content-header">
          <h1>
            <?= $pageTitle?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?= site_url();?>admin"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li><a href="<?= site_url();?><?= $breadcrumbLink?>"><?= $breadcrumbTitle?></a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
		
          <div class="row">

            <div class="col-xs-3">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">
					<span><?= $this->session->userdata('name')?></span>
					</h3>
                </div><!-- /.box-header -->
                <div class="box-body">

			    <img src="<?= base_url();?>assets/admin/img/avatar/thumb/<?= $this->session->userdata('picUser');?>"  class="img-circle" alt="User Image">
			</div>
            </div><!-- /.col -->
			</div>

            <div class="col-xs-9">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">
					<span>Detail User</span>
					</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
				
			<form class="form-horizontal" id="formfield" enctype="multipart/form-data" data-toggle="validator" role="form" method="POST" action="<?= site_url();?><?= $saveLink;?>" >
			
			
			<?php
				if(!empty($formLabel))
				{
				?>
				
						<?php
						$i=0;
						foreach($formLabel as $row)
						{
						?> 
							  <div class="form-group ">
								<label for="inputEmail3" class="col-sm-2 control-label"><?= $row ?></label>														
								<div class="col-sm-10">
								  <?= $formTxt[$i] ?>
									<div class="help-block with-errors"></div>
								</div>
							  </div>
						<?php
						$i++;
						}
						?>
				<?php
				}
				?>
								  
		
			</form>
			
			
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
