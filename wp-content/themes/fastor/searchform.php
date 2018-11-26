<?php
$fastor_options = fastor_get_options();

?>
<div class="page-searchform">
    <?php if(defined('WC_VERSION')): ?>
    <form action="<?php echo esc_url( home_url( '/' ) ); ?>/" method="get" >
        <input type="hidden" name="post_type" value="product" />
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <input  name="s" id="s" type="text" value="<?php echo isset($_GET['s'])? htmlentities2($_GET['s']) : '' ?>" placeholder="<?php echo esc_html__('Search here', 'fastor'); ?>" autocomplete="off" />
            </div>
            <div class="col-sm-12 col-md-3">
                <?php
                $all_categories = fastor_get_product_categories();
                ?>
                <?php if(!empty($all_categories)): ?>
                    <div class="search-cat">
                        <div class="select">
                            <select name="product_category" class="form-control">
                                <option value=""><?php echo esc_html__('All categories', 'fastor'); ?></option>
                                <?php foreach($all_categories as $category): ?>
                                    <option value="<?php echo $category->slug ?>" <?php echo isset($_GET['product_category']) && $_GET['product_category'] == $category->slug ? 'selected': '' ?>><?php echo $category->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-sm-12 col-md-3">
                <button class="btn" type="submit"><?php echo esc_attr_x( 'Search', 'submit button', 'fastor' ); ?></button>
            </div>
        </div>

    </form>
    <?php else: ?>
        <form action="<?php echo esc_url( home_url( '/' ) ); ?>/" method="get" >
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <input  name="s" id="s" type="text" value="<?php echo isset($_GET['s'])? htmlentities2($_GET['s']) : '' ?>" placeholder="<?php echo esc_html__('Search here', 'fastor'); ?>" autocomplete="off" />
                </div>

                <div class="col-sm-12 col-md-4">
                    <button class="btn" type="submit"><?php echo esc_attr_x( 'Search', 'submit button', 'fastor' ); ?></button>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>
