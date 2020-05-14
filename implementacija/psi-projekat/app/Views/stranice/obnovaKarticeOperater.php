<div class="col-md-8 col-xs-12">
            <div class="jumbotron pt-0 mb-1">
                <div class="row justify-content-center py-4">
                    <h4>Obnova kartice</h4>
                </div>
                <form method="POST" action="obnovaKarticeSubmit" autocomplete="off">
                  <div class="row justify-content-center">
                    <div class="form-group col-lg-9">
                      <label for="idKartice">ID KARTICE</label>
                      <input type="text" class="form-control form-control-lg" name="idKartice" id="idKartice">
                    </div>
                  </div>
                  <div class="row justify-content-center">
                <div class="form-group col-lg-9">
                  <label for="period">PERIOD</label>
                  <select class="form-control form-control-lg selectpicker" name="period">
                    <option value="dan">DAN, 200 RSD</option>
                    <option value="sedmica">SEDMICA, 800 RSD</option>
                    <option value="mesec">MESEC, 2000 RSD</option>
                  </select>
                </div>
              </div>
                  <div class="row justify-content-center">
                    <div class="col-lg-9">
                      <button type="submit" class="btn btn-plavi btn-block mt-3 py-3">POTVRDI</button>
                    </div>
                  </div>
                </form>
            </div>
</div>