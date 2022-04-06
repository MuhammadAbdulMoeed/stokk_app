<div class="real_estate_section">

    <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Land Size (In Inch)</label>
                <input type="text" name="land_size" class="form-control" onkeypress="return isNumberKey(event)">
            </div>
        </div>


        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Bed Room</label>
                <input type="text" name="rooms" class="form-control" onkeypress="return isNumberKey(event)">
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Living Room</label>
                <input type="text" name="rooms" class="form-control" onkeypress="return isNumberKey(event)">
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Bath Room</label>
                <input type="text" name="rooms" class="form-control" onkeypress="return isNumberKey(event)">
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
                <label>Rent Price (Per Month)</label>
                <input type="text" name="price" class="form-control" onkeypress="return isNumberKey(event)">
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
