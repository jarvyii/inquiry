<form id="endshift_form" action="ControllerInquiry.php" method="POST">
    <input type="hidden" name="inquiry" value="endshift">
    <input type="hidden" name="Supervisor" value='.$Operator.'>
    <label for="email">Enter the email address:</label>
    <input type = "email" id = "email" name = "email">
    <div class="modal-footer button-trackinginquiry ">
         <button type="button" class="btn btn-inquiry button-next" > Preview </button>
         <button type="reset"   class="btn btn-inquiry button-next"> Reset </button>
         <button type="button" id="endshift"  class="btn btn-inquiry button-next"> Next </button>
    </div>
</form>