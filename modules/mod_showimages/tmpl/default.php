<?php //foreach ($lists as $row) :  ?>

<!--<img src="images/phocagallery/<? //echo $row->filename; ?>" width="194px" height="147px">-->

<? //endforeach; ?>
<div class="col-group">
    <div id="content" role="main" style ="padding-left:35px">

        <div class="panelcategory" style="margin-top: 20px">
            <label for="gallimage">Select Category</label>
            <form action="">
                <select id="gallimage" name="gallimage" onchange="this.form.submit()">
                    <?php
                    echo '<option value="0"> </option>';
                    foreach ($list_name as $name_cat) {
                        echo '<option value="' . $name_cat->catid . '"' . (($_GET['gallimage'] == $name_cat->catid) ? "selected" : "") . ' >' . $name_cat->title . '</option>';
                    }
                    ?>
                </select>
                <noscript><input type="submit" value="Submit"></noscript>
            </form>


        </div>
        <?php
        foreach ($lists as $image_gallery) :
            $filename = $image_gallery->filename; 
            $img = "/images/phocagallery/" . $filename;
            ?>
            <div class="phocagallery-box-file" style="height:188px; width:120px;">
                <div class="phocagallery-box-file-first" style="height:118px;width:118px;margin:auto;">
                    <div class="phocagallery-box-file-second">
                        <div class="phocagallery-box-file-third" style="margin:auto">
    <!--                                onmouseover="return overlib('&lt;div class=\&quot;pg-overlib\&quot;&gt;&lt;center&gt;&lt;img src=\&quot;<?php //echo $img;      ?>\&quot; alt=\&quot;facility pictures\&quot;  /&gt;&lt;/center&gt;&lt;/div&gt;', CAPTION, 'facility pictures', BELOW, RIGHT, BGCLASS,'bgPhocaClass', FGCOLOR, '#f6f6f6', BGCOLOR, '#666666', TEXTCOLOR, '#000000', CAPCOLOR, '#ffffff');"-->
                            <a class="highslide " href="<?php echo $img; ?>" onclick="return hs.expand(this, {slideshowGroup: 'groupC0', wrapperClassName: 'rounded-white', outlineType: 'rounded-white', dimmingOpacity: 0, align: 'center', transitions: ['expand', 'crossfade'], fadeInOut: true});"   >
                                <img src="<?php echo $img; ?>" alt="" class="pimo" height="118px" width="118px"/>
                            </a>
<!--                            <a class="highslide " href="<?php echo $img; ?>" onclick="return hs.expand(this, {slideshowGroup: 'groupC0', wrapperClassName: 'rounded-white', outlineType: 'rounded-white', dimmingOpacity: 0, align: 'center', transitions: ['expand', 'crossfade'], fadeInOut: true});" onmouseover="return overlib('&lt;div class=\&quot;pg-overlib\&quot;&gt;&lt;center&gt;&lt;img src=\&quot;<?php echo $img; ?>\&quot; alt=\&quot;<?php echo $image_gallery->title; ?>\&quot;  /&gt;&lt;/center&gt;&lt;/div&gt;', CAPTION, '<?php echo $image_gallery->title; ?>facility pictures', BELOW, RIGHT, BGCLASS, 'bgPhocaClass', FGCOLOR, '#f6f6f6', BGCOLOR, '#666666', TEXTCOLOR, '#000000', CAPCOLOR, '#ffffff');" onmouseout="return nd();"  >
                                <img src="<?php echo $img; ?>" alt="" class="pimo" height="118px" width="118px"/>
                            </a>-->

                            <!--<div class="highslide-heading"><?php echo $image_gallery->title; ?></div>-->
                            <!--<div class="highslide-caption"><?php echo $image_gallery->description; ?></div>-->
                            <div class="highslide-caption"><?php echo $image_gallery->title; ?></div>
                        </div>
                    </div>
                </div>

                <div class="phocaname" style="font-size:12px"><?php echo substr($image_gallery->description, 0, 50) . "..."; ?></div>
                <div class="detail" style="margin-top:2px"> <a class="highslide" title="Detail" href="<?php echo $img; ?>" onclick="return hs.htmlExpand(this, phocaZoom)" >
                        <!--<img class="iimage" src="/templates/pepmobile/css/graphics/icon-view.png" alt="Detail"  style="border: none;float:right;"/>-->
                    </a>
                </div>

                <div style="clear:both"></div>
            </div>
        <?php endforeach; ?>

    </div> 

</div>
<div>
    <?php //echo $pagination->getPagination() ?>
</div>