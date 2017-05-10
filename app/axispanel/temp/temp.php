<div class="form-group admin-form">
    <div class="col-sm-6">
        <input type="button" value="Add Image" onClick="addRow('addimage')" />
        <input type="button" value="Remove Image" onClick="deleteRow('addimage')"  />
    </div>
</div>
<?php $m=0; ?>
<table id="addimage" class="table">
    <tbody>
    <div class="form-group admin-form">
        <tr>
            <?php $m++; ?>
            <div class="col-sm-1">
                <td>
                    <div class="checkbox-info">
                        <input type="checkbox" id="offered" name="chk[]"">
                        <label></label>
                    </div>
                </td>
            </div>
            <div class="col-sm-4">
                <td>
                    <label class="control-label">Upload Image Item</label>
                    <label class="field prepend-icon file">
                        <span class="button bg-primary" style="color: white;">Choose Image</span>
                        <input type="file" class="gui-file" name="itemimage[]" id="itemImage" onChange="document.getElementById('imagename<?php echo $m; ?>').value = this.value.substr(12);" required>
                        <input type="text" class="gui-input" name="itemImage[]" id="imagename<?php echo $m; ?>" placeholder="Please Select An Image">
                        <label class="field-icon"><i class="fa fa-upload"></i></label>
                    </label>
                </td>
            </div>
            <div class="col-sm-4">
                <td>
                    <input type="text" name="itemName[]" id="additemname" class="form-control" disabled>
                </td>
            </div>
        </tr>
    </div>
    </tbody>
</table>
