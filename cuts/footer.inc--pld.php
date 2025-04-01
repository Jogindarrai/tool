<footer>

      <div class="copyright">Copyright 2015. All rights reserved</div>

      <div class="powered">Powered by <?=POWERED_BY?></div>

      <div class="cl"></div>

    </footer>

    

  </div>

  <div class="cl"></div>

  

  

</div>


<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
             <div class="modal-dialog"> 
                  <div class="modal-content"> 
                  
                       <div class="modal-header"> 
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button> 
                            <h4 class="modal-title"><i class="glyphicon glyphicon-envelope"></i> Send Message</h4> 
                       </div> 
                       <div class="modal-body"> 
                       
                       	   <div id="modal-loader" style="display: none; text-align: center;">
                       	   	<img src="<?=SITE_PATH_ADM?>modules/project/ajax-loader.gif">
                       	   </div>
                            
                           <!-- content will be load here -->                          
                           <div id="dynamic-content"></div>
                           <fieldset>
<legend>Message to Client</legend>
<input type="hidden" id="upid" name="upid" value="" />
<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
  <input name="phone" placeholder="9999999999" class="form-control" type="text" id="phone4msg" onkeyup="mobileNumber(this.value)">
  <i class="form-control-feedback bv-no-label glyphicon glyphicon-ok" data-bv-icon-for="Message" style="display: none;"></i>
  </div><small class="help-block" style="display: none;">Please supply your phone number</small>
</div>
<div class="form-group">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
        	<textarea class="form-control" name="msg" placeholder="Message Description" id="dis4msg" onkeyup="checkmsg(this.value)"></textarea>
            <i class="form-control-feedback bv-no-label glyphicon glyphicon-ok" data-bv-icon-for="Message" style="display: none;"></i>
  </div><small class="help-block" style="display: none;">Please supply your Message</small>
</div>
<div class="form-group">
<div class="input-group">
<button type="button" class="btn btn-warning" onclick="validate4msg()" >Send <span class="glyphicon glyphicon-send"></span></button>
  </div>
  
</div>
<div class="form-group" id="success4msg" style="display:none;">
<div class="alert alert-success fade in">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Success!</strong> Your message has been sent successfully.
    </div>
</div>  
<div class="form-group" id="error4msg" style="display:none;">
<div class="alert alert-danger fade in">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Error!</strong> A problem has been occurred while sending your message.
    </div>
</div>
</fieldset>  
                        </div> 
                        <div class="modal-footer"> 
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                        </div> 
                        
                 </div> 
              </div>
       </div>
<script type="text/javascript">

var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");

var Accordion1 = new Spry.Widget.Accordion("Accordion1");

</script>
 <script>
    var btns = document.querySelectorAll('.copy');
    var clipboard = new Clipboard(btns);

    clipboard.on('success', function(e) {
        console.log(e);
		alert('Text has been copied to clipboard. !\n\n'+e.text);
    });

    clipboard.on('error', function(e) {
        alert('Something went wrong. Please copy manually');
    });
    </script>
</body>

</html>

