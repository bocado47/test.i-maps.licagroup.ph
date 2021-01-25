 <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Config</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-1">
                <!-- <span data-feather="calendar"></span>Date -->
              </div>
              <div class="btn-group mr-2">
                <button class="btn btn-md btn-outline-secondary" id="apo"><span data-feather="user-plus"></span> Add User</button>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <form method="POST" action="<?php echo base_url(); ?>Uploadar/do_upload" enctype="multipart/form-data">
				<input type="file" name="userfile"/>
				<input type="submit"/>
			</form>
          </div>
        </main>
      </div>
    </div>
