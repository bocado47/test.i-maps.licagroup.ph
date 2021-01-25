
<style type="text/css">
  textarea{
    resize: none;
  }
</style>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">File a Ticket</h1>
      <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-1">
        </div>
      </div>
  </div>
  <div class="container">
    <form class="row needs-validation" id="help_form" method="POST" action="<?php echo base_url(); ?>Inventory/HelpForm">
        <div class="col">
          <div class="form-group row">
            <div class="col-sm-6">
              <label for="name" class="col-sm-12 col-form-label">Name:</label>
              <div class="col-sm-12">
                <input type="text"  class="form-control" name="name" id="name" required/>
                <div class="invalid-feedback">
                  Please provide a Name.
                </div>
              </div>

              <label for="name" class="col-sm-12 col-form-label">Email:</label>
              <div class="col-sm-12">
                <input type="email"  class="form-control" name="email" id="email" required/>
                <div class="invalid-feedback">
                  Please provide a Email.
                </div>
              </div>

              <label for="name" class="col-sm-12 col-form-label">Contact Number: (format: 09XX-XXX-XXXX)</label>
              <div class="col-sm-12">
                <input type="tel"  pattern="^\d{4}-\d{3}-\d{4}$" class="form-control" name="contact" id="contact" required/>
              </div>

              <label for="name" class="col-sm-12 col-form-label">Subject:</label>
              <div class="col-sm-12">
                <input type="text"  class="form-control" name="subject" id="subject" required/>
                <div class="invalid-feedback">
                  Please provide a Subject Title.
                </div>
              </div>

              <label for="name" class="col-sm-12 col-form-label">Message:</label>
              <div class="col-sm-12">
                <textarea class="form-control" name="message" rows="6"></textarea>
                <div class="invalid-feedback">
                  Please provide a Message.
                </div>
              </div>
              <div class="col-sm-12">
                <br/>
                <button type="submit" class="col-sm-4 btn btn-primary" style="float:right;">Submit</button>
              </div>
            </div>
            <div class="col-sm-6">
              <h2 style="text-align: center"><u>Contact Person</u></h2>
              <label for="name" class="col-sm-12 col-form-label"><h3>Name:</h3></label>
              <div class="col-sm-12">
                <h5 style="text-indent: 25px;">Jomari Bocado</h5>
              </div>  
              <label for="name" class="col-sm-12 col-form-label"><h3>Email:</h3></label>
              <div class="col-sm-12">
                <h5 style="text-indent: 25px;">bocadojomari18@gmail.com</h5>
              </div>
              <label for="name" class="col-sm-12 col-form-label"><h3>Contact Number:</h3></label>
              <div class="col-sm-12">
                <h5 style="text-indent: 25px;">+63915413747</h5>
              </div>
            </div>
          </div>
        </div>
    </form>
  </div>
</main>
</div>
</div>