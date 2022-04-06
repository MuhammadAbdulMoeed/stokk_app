<div class="vehicle_car_section">
    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Select Brand</label>
                <select class="form-control brand" name="brand_id">

                </select>
            </div>
        </div>


        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <div class="form-group">
                <label for="exampleInputEmail1">Select Class</label>
                <select class="form-control class" name="class_id">

                </select>
            </div>
        </div>

        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
            <div class="form-group">
                <label>Additional Option</label>
                <select multiple name="additional_option_id[]" class="form-control multiSelectOption additionalOption">

                </select>
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <div class="form-group">
                <label>Product Type </label>
                <select class="form-control productType" name="product_type">
                    <option value="" selected disabled>Select</option>
                    <option value="for_rent">For Rent</option>
                    <option value="for_sale">For Sale</option>
                </select>
            </div>
        </div>


    </div>

    <div class="row rentPrice" style="display: none">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <div class="form-group">
                <label>Hourly Price (Per Hour)</label>
                <input type="text" name="per_hour" class="form-control" onkeypress="return isNumberKey(event)">
            </div>
        </div>


        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <div class="form-group">
                <label>Full Day Price</label>
                <input type="text" name="full_rate" class="form-control" onkeypress="return isNumberKey(event)">
            </div>
        </div>
    </div>

    <div class="row forSale" style="display: none">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <div class="form-group">
                <label> Price </label>
                <input type="text" name="price" class="form-control" onkeypress="return isNumberKey(event)">
            </div>
        </div>

    </div>

</div>
