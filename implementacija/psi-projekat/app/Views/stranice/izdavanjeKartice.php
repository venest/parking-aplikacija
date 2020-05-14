<div class="col-md-8 col-xs-12">
            <div class="jumbotron pt-0 mb-1">
                <div class="row justify-content-center py-4">
                    <h4>Izdavanje kartice</h4>
                </div>
                <form method="POST" action="izdavanjeKarticeSubmit" autocomplete="off">
                  <div class="row justify-content-center">
                    <div class="form-group col-lg-9">
                      <label for="email">EMAIL ADRESA</label>
                      <input type="email" class="form-control form-control-lg" name="email" id="email">
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="form-group col-lg-9">
                      <label for="tablice">AUTOMOBIL</label>
                      <input type="text" class="form-control form-control-lg" name="tablice" id="tablice">
                    </div>
                  </div>
                  <div class="row justify-content-center">
                <div class="form-group col-lg-9">
                  <label for="period">PERIOD VAŽENJA</label>
                  <select class="form-control form-control-lg selectpicker" name="period">
                    <option value="dan">DAN, 200 RSD</option>
                    <option value="dan">SEDMICA, 800 RSD</option>
                    <option value="dan">MESEC, 2000 RSD</option>
                  </select>
                </div>
              </div>
                  <div class="row justify-content-center">
                    <div class="col-lg-9">
                      <button type="submit" class="btn btn-plavi btn-block mt-3 py-3">IZDAVANJE KARTICE</button>
                    </div>
                  </div>
                </form>
            </div>
</div>