	<div class="col-xs-2 sidebar-offcanvas" id="sidebar" style="padding-top: 3.7%; padding-left: 0%">
	<div class="list-group">
		<a  data-toggle="modal" data-target="#upin" class="list-group-item">Upload Pin</a>
		<a  data-toggle="modal" data-target="#wpin" class="list-group-item">Add Pin From Website</a>
            	<a  data-toggle="modal" data-target="#CreateBoard" class="list-group-item">Add Board</a>
              	<a  data-toggle="modal" data-target="#fstream" class="list-group-item">Add Follow Stream</a>
	</div>
</div><!--/span-->
<!--/row-->

<div class="modal fade" id="CreateBoard" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
        	<div class="modal-content">
        		<div class="modal-header">
        		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
               			 <h4 class="modal-title" id="myModalLabel">New Board</h4>
           		</div>
			<form name='board_create' method='POST' action='home.php'> 
			<div class="modal-body">
				<div class="form-group">
                               		<label for="Name">Name</label>
                                	<input type="text" class="form-control" id="Name"  name='Name' placeholder="Enter Board Name">
                		</div>
				<div class="form-group">
                                	<label for="Description">Description</label>
                                	<input type="textarea" class="form-control" id="Description"  name='Description' placeholder="Enter Description">
                		</div>
						
				<div class="form-group">
					<label for="Category">Category</label>							
					<select id="Category" name="Category">                      
					<option value="0">Select Catogery</option>
					<option value="Animals">Animals</option>
					<option value="Architecture">Architecture</option>
					<option value="Art">Art</option>
					<option value="Celebrities">Celebrities</option>
					<option value="Design">Design</option>
					<option value="Education">Education</option>
					<option value="Fashion">Fashion</option>
					<option value="Film, Music & Books">Film, Music  Books</option>
					<option value="Food & Drink">Food & Drink</option>
					<option value="Hair & Beauty">Hair & Beauty</option>
					<option value="Health & Fitness">Health & Fitness</option>
					<option value="History">History</option>
					<option value="Humor">Humor</option>
					<option value="Photography">Photography</option>
					<option value="Science & Nature">Science & Nature</option>
					<option value="Sports">Sports</option>
					<option value="Travel">Travel</option>
					<option value="Vehicles">Vehicles</option>
					<option value="Other">Other</option>
					</select>	
				</div>
				<div class="checkbox">
    					<label>
      						<input type="checkbox" name='only_friends' value="1"/>Only friends comment
    					</label>
  				</div>						
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" name="createB" value='Create' />
                </div>
		</form> 
	</div>
	</div>
                
</div>


<div class="modal fade" id="upin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                 <h4 class="modal-title" id="myModalLabel">New Pin</h4>
                        </div><!-- header-->
                        <form name='board_create' method='POST' action='home.php' enctype="multipart/form-data" >
                        <div class="modal-body">
				
                          	<div class="form-group">
    					<label for="pinFile">Browse image</label>
    					<input type="file" id="pinFile" name="pinFile">
  				</div>
                                <div class="form-group">
                                        <label for="Description">Description</label>
                                   	 <input type="textarea" class="form-control" id="Description"  name='Description' placeholder="Enter Description">
                                </div>
				<div class="form-group">
					<label for="board_id">Board</label>
					<select class="form-control" id='board_id' name="board_id">
					<?php include_once("board.php");
						list_board($sql_con);	
					 ?>
					</select>
				</div>
				<div class="form-group">
                                        <label for="tags">Tags</label>
                                        <input type="text" class="form-control" id="tags"  name='tags' placeholder="Comma Saperated Tags">
                                </div>
			</div><!-- body-->
                	<div class="modal-footer">
                    		<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    		<input type="submit" class="btn btn-primary" name="uploadPin" value='Upload' />
                	</div><!-- footer-->
                	</form>
        	</div>
        </div>

</div>


<div class='modal fade' id='wpin' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                 <h4 class="modal-title" id="myModalLabel">New Pin From URL</h4>
                        </div>
			<div class='modal-body'>
				<form name='wpin'class='form-inline' method='POST' action='wpin.php'>
					<div class="form-group">
    						<input type="url" class="form-control" id="wurl" name="wurl" placeholder="http://..">
  					</div>
					<button type="submit" name='wsubmit' class="btn btn-default">Next</button>					
				</form>
                        </div>
		</div>
	</div>
</div>

<div class='modal fade' id='fstream' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
        <div class='modal-dialog'>
                <div class='modal-content'>
                        <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                 <h4 class="modal-title" id="myModalLabel">Add Stream</h4>
                        </div>
                        <div class='modal-body'>
                                <form name='fs' method='POST' action='fstream.php'>
                                        <div class="form-group">
						<label for="sname">Stream Name</label>
                                                <input type="text" class="form-control" id="sname" name="sname" placeholder="Name Please">
                                        </div>
					<input type="hidden" name='req' value="<?php echo $_SERVER['SCRIPT_NAME']?> ">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                        <button type="submit" name='fssubmit' class="btn btn-primary">Create</button>
				</form>
                        </div>
                </div>
        </div>
</div>

