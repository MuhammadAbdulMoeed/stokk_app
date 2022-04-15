<div class="pre-included-filter-section">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h5>Pre-Included Fields</h5>
        </div>


        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <label class="sc-featur">Brand
                <input type="radio" class="sale-checkbox" value="brand"
                       name="value_taken_from" {{isset($data->value_taken_from) ? $data->value_taken_from == 'brand' ? "checked":'':''}}>
                <span class="checkmark"></span>
            </label>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <label class="sc-featur">Class
                <input type="radio" class="sale-checkbox" value="class"
                       name="value_taken_from" {{isset($data->value_taken_from) ? $data->value_taken_from == 'class' ? "checked":'':''}}>
                <span class="checkmark"></span>
            </label>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <label class="sc-featur">Rating
                <input type="radio" class="sale-checkbox" value="rating"
                       name="value_taken_from" {{isset($data->value_taken_from) ? $data->value_taken_from == 'rating' ? "checked":'':''}}>
                <span class="checkmark"></span>
            </label>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <label class="sc-featur">Additional Options
                <input type="radio" class="sale-checkbox" value="additional_option"
                       name="value_taken_from" {{isset($data->value_taken_from) ? $data->value_taken_from == 'additional_option' ? "checked":'':''}}>
                <span class="checkmark"></span>
            </label>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <label class="sc-featur">Size
                <input type="radio" class="sale-checkbox" value="size"
                       name="value_taken_from" {{isset($data->value_taken_from) ? $data->value_taken_from == 'size' ? "checked":'':''}}>
                <span class="checkmark"></span>
            </label>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <label class="sc-featur">Item Condition
                <input type="radio" class="sale-checkbox" value="item_condition"
                       name="value_taken_from" {{isset($data->value_taken_from) ? $data->value_taken_from == 'item_condition' ? "checked":'':''}}>
                <span class="checkmark"></span>
            </label>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <label class="sc-featur">Clothing Type
                <input type="radio" class="sale-checkbox" value="clothing_type"
                       name="value_taken_from" {{isset($data->value_taken_from) ? $data->value_taken_from == 'clothing_type' ? "checked":'':''}}>
                <span class="checkmark"></span>
            </label>
        </div>




    </div>

</div>
