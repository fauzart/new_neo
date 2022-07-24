			</div>

			<!--Footer-->
			<footer class="footer">
				<div class="container">
					<div class="row align-items-center flex-row-reverse">
						<div class="col-md-12 col-sm-12 mt-3 mt-lg-0 text-center">
							Copyright ©2020 <a target="_blank" href="http://www.matrik.co.id">Matrik</a>. All rights reserved.
						</div>
					</div>
				</div>
			</footer>
			<!-- End Footer-->

		</div>
	
		<!-- Back to top -->
		<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

	  <div class="modal fade" id="modal_delete">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Delete Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Delete this data?</p>
            </div>
			<div class="modal-footer justify-content-between">
				
				<button type="button" class="btn btn-danger" onclick="deleteData();">Delete</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				
			</div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
	  
	  <div class="modal fade" id="modal_process">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="process_title">Process</h4>
              <!--button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button-->
            </div>
            <div class="modal-body" id="process_result">
              <p>Processing, please wait ...</p>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
