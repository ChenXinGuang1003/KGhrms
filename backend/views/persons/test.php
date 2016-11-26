<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/8/31
 * Time: 14:29
 */
?>
<div class="auth-item-create">


</div>
<div class="row-fluid">
    <div class="box span12">
        <div class="box-header">
            <h2><i class="icon-edit"></i>Form Elements</h2>
            <div class="box-icon">
                <a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal">
                <fieldset>
                    <?/*= $form->field($model, 'name')->textInput(['maxlength' => true]) */?>

                    <div class="control-group">
                        <label class="control-label" for="focusedInput">员工姓名</label>
                        <div class="controls">
                            <input class="input-xlarge focused" id="name"  type="text">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="focusedInput">员工编号</label>
                        <div class="controls">
                            <input class="input-xlarge" id="number"  type="text">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">性别</label>
                        <div class="controls">
                            <label class="radio inline">
                                <div id="uniform-optionsRadios1" class="radio">
                                    <span class="checked">
                                        <input name="optionsRadios" id="optionsRadios1" value="option1" checked="" type="radio">
                                    </span>
                                </div>
                                男
                            </label>
                            <label class="radio inline">
                                <div id="uniform-optionsRadios2" class="radio"><span><input name="optionsRadios" id="optionsRadios2" value="option2" type="radio"></span></div>
                                女
                            </label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="date01">出生年月</label>
                        <div class="controls">
                            <input class="input-xlarge datepicker hasDatepicker" id="date01" value="" type="text">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="date01">入职日期</label>
                        <div class="controls">
                            <input class="input-xlarge datepicker hasDatepicker" id="date01" value="" type="text">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">在职状态</label>
                        <div class="controls">
                            <label class="checkbox inline">
                                <div id="uniform-inlineCheckbox1" class="checker">
                                    <span class="checked"><input id="inlineCheckbox1" value="option1" type="checkbox"></span>
                                </div>
                                在职
                            </label>
                            <label class="checkbox inline">
                                <div id="uniform-inlineCheckbox2" class="checker">
                                    <span><input id="inlineCheckbox2" value="option2" type="checkbox"></span>
                                </div>
                                储备
                            </label>
                            <label class="checkbox inline">
                                <div id="uniform-inlineCheckbox3" class="checker">
                                    <span><input id="inlineCheckbox3" value="option3" type="checkbox"></span>
                                </div>
                                离职
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="selectError3">所属公司</label>
                        <div class="controls">
                            <select id="selectError3">
                                <option>Option 1</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="selectError3">所在岗位</label>
                        <div class="controls">
                            <select id="selectError3">
                                <option>Option 1</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button class="btn">Cancel</button>
                    </div>
                </fieldset>
            </form>

        </div>
    </div><!--/span-->

</div>
