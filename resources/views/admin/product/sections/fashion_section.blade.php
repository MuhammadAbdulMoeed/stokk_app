<div class="fashion_section">

    <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Material</label>
                <input type="text" name="land_size" class="form-control">
            </div>
        </div>


        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Style</label>
                <input type="text" name="rooms" class="form-control">
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Size</label>
                <select multiple class="form-control multiSelectOption size" name="size_id[]"></select>
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Length</label>
                <input type="text" name="rooms" class="form-control">
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Item Condition</label>
                <select class="form-control itemCondition" name="item_condition_id"></select>
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Select Brand</label>
                <select class="form-control brand" name="brand_id">

                </select>
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Select Clothing Type</label>
                <select class="form-control clothType" name="cloth_type_id">

                </select>
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="form-group">
                <label for="exampleInputEmail1">Gender</label>
                <select class="form-control" name="gender">
                    <option value="" selected disabled>Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
        </div>


        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="form-group">
                <label> Price </label>
                <input type="text" name="price" class="form-control" onkeypress="return isNumberKey(event)">
            </div>
        </div>



    </div>

</div>
