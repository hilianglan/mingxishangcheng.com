<?php /*a:3:{s:70:"/www/wwwroot/hh.xzhyu.com/app/admin/view/ownshop/storejoinin_edit.html";i:1657785098;s:59:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/header.html";i:1657785098;s:64:"/www/wwwroot/hh.xzhyu.com/app/admin/view/public/admin_items.html";i:1657785098;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo htmlentities((isset($html_title) && ($html_title !== '')?$html_title:config('ds_config.site_name'))); ?><?php echo htmlentities(lang('system_backend')); ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/css/admin.css">
        <link rel="stylesheet" href="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery-ui/jquery-ui.min.css">
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/jquery-2.1.4.min.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/jquery.validate.min.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/jquery.cookie.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/common.js"></script>
        <script src="<?php echo htmlentities(ADMIN_SITE_ROOT); ?>/js/admin.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery-ui/jquery-ui.min.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery-ui/jquery.ui.datepicker-zh-CN.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/perfect-scrollbar.min.js"></script>
        <script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/layer/layer.js"></script>
        <script type="text/javascript">
            var BASESITEROOT = "<?php echo htmlentities(BASE_SITE_ROOT); ?>";
            var ADMINSITEROOT = "<?php echo htmlentities(ADMIN_SITE_ROOT); ?>";
            var BASESITEURL = "<?php echo htmlentities(BASE_SITE_URL); ?>";
            var HOMESITEURL = "<?php echo htmlentities(HOME_SITE_URL); ?>";
            var ADMINSITEURL = "<?php echo htmlentities(ADMIN_SITE_URL); ?>";
        </script>
    </head>
    <body>
        <div id="append_parent"></div>
        <div id="ajaxwaitid"></div>










<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3><?php echo htmlentities(lang('ds_ownshop')); ?></h3>
                <h5></h5>
            </div>
            <?php if($admin_item): ?>
<ul class="tab-base ds-row">
    <?php if(is_array($admin_item) || $admin_item instanceof \think\Collection || $admin_item instanceof \think\Paginator): if( count($admin_item)==0 ) : echo "" ;else: foreach($admin_item as $key=>$item): ?>
    <li><a href="<?php echo htmlentities($item['url']); ?>" <?php if($item['name'] == $curitem): ?>class="current"<?php endif; ?>><span><?php echo htmlentities($item['text']); ?></span></a></li>
    <?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
<?php endif; ?>
        </div>
    </div>
  <div class="homepage-focus" dstype="editStoreContent">
      <form id="joinin_form" enctype="multipart/form-data" method="post">
          <input type="hidden" name="member_id" value="<?php echo htmlentities($joinin_detail['member_id']); ?>" />
          <?php if($joinin_detail['store_type'] != 1): ?>

          <table border="0" cellpadding="0" cellspacing="0" class="store-joinin ds-default-table">
              <thead>
                  <tr>
                      <th colspan="20"><?php echo htmlentities(lang('company_contact_information')); ?></th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <th class="w150"><?php echo htmlentities(lang('company_name')); ?>：</th>
                      <td colspan="20"><input type="text" class="txt" name="company_name" value="<?php echo htmlentities($joinin_detail['company_name']); ?>"></td>
                  </tr>
                  <tr>
                      <th><?php echo htmlentities(lang('company_location')); ?>：</th>
                      <td><input type="hidden" name="company_address" id="company_address" value="<?php echo htmlentities($joinin_detail['company_address']); ?>"></td>
                      <th><?php echo htmlentities(lang('company_address')); ?>：</th>
                      <td><input type="text" class="txt w300" name="company_address_detail" value="<?php echo htmlentities($joinin_detail['company_address_detail']); ?>"></td>
                      <th><?php echo htmlentities(lang('registered_capital')); ?>：</th>
                      <td><input type="text" class="txt w72" name="company_registered_capital" value="<?php echo htmlentities($joinin_detail['company_registered_capital']); ?>">&nbsp;<?php echo htmlentities(lang('ten_thousand')); ?><?php echo htmlentities(lang('ds_yuan')); ?> </td>
                  </tr>
                  <tr>
                      <th><?php echo htmlentities(lang('contact_name')); ?>：</th>
                      <td><input type="text" class="txt" name="contacts_name" value="<?php echo htmlentities($joinin_detail['contacts_name']); ?>"></td>
                      <th><?php echo htmlentities(lang('contact_number')); ?>：</th>
                      <td><input type="text" class="txt" name="contacts_phone" value="<?php echo htmlentities($joinin_detail['contacts_phone']); ?>"></td>
                      <th><?php echo htmlentities(lang('e_mail')); ?>：</th>
                      <td><input type="text" class="txt" name="contacts_email" value="<?php echo htmlentities($joinin_detail['contacts_email']); ?>"></td>
                  </tr>
              </tbody>
          </table>
          <table border="0" cellpadding="0" cellspacing="0" class="store-joinin ds-default-table">
              <thead>
                  <tr>
                      <th colspan="20"><?php echo htmlentities(lang('business_license_information')); ?></th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <th class="w150"><?php echo htmlentities(lang('business_license_number')); ?>：</th>
                      <td><input type="text" class="txt" name="business_licence_number" value="<?php echo htmlentities($joinin_detail['business_licence_number']); ?>"></td></tr><tr>

                      <th><?php echo htmlentities(lang('place_business_license')); ?>：</th>
                      <td><input type="hidden" name="business_licence_address" id="business_licence_address" value="<?php echo htmlentities($joinin_detail['business_licence_address']); ?>"></td></tr><tr>

                      <th><?php echo htmlentities(lang('validity_business_license')); ?>：</th>
                      <td><input type="text" class="txt" name="business_licence_start" id="business_licence_start" value="<?php echo htmlentities($joinin_detail['business_licence_start']); ?>"> - <input type="text" class="txt" name="business_licence_end" id="business_licence_end" value="<?php echo htmlentities($joinin_detail['business_licence_end']); ?>"></td>
                  </tr>
                  <tr>
                      <th><?php echo htmlentities(lang('legal_scope_business')); ?>：</th>
                      <td colspan="20"><input type="text" class="txt w300" name="business_sphere" value="<?php echo htmlentities($joinin_detail['business_sphere']); ?>"></td>
                  </tr>
                  <tr>
                      <th><?php echo htmlentities(lang('business_license')); ?><br /><?php echo htmlentities(lang('electronic_version')); ?>：</th>
                      <td colspan="20">
                          <?php if(!(empty($joinin_detail['business_licence_number_electronic']) || (($joinin_detail['business_licence_number_electronic'] instanceof \think\Collection || $joinin_detail['business_licence_number_electronic'] instanceof \think\Paginator ) && $joinin_detail['business_licence_number_electronic']->isEmpty()))): ?>
                          <a data-lightbox="lightbox-image"  href="<?php echo get_store_joinin_imageurl($joinin_detail['business_licence_number_electronic']); ?>"> <img src="<?php echo get_store_joinin_imageurl($joinin_detail['business_licence_number_electronic']); ?>" height="100"/> </a>
                          <?php endif; ?>
                          <input class="w200" type="file" name="business_licence_number_electronic">
                      </td>
                  </tr>
              </tbody>
          </table>

          <table border="0" cellpadding="0" cellspacing="0" class="store-joinin ds-default-table">
              <thead>
                  <tr>
                      <th colspan="20"><?php echo htmlentities(lang('bank_information')); ?>：</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <th class="w150"><?php echo htmlentities(lang('bank_name')); ?>：</th>
                      <td><input type="text" class="txt w300" name="bank_account_name" value="<?php echo htmlentities($joinin_detail['bank_account_name']); ?>"></td>
                  </tr><tr>
                      <th><?php echo htmlentities(lang('company_bank_account')); ?>：</th>
                      <td><input type="text" class="txt w300" name="bank_account_number" value="<?php echo htmlentities($joinin_detail['bank_account_number']); ?>"></td></tr>
                  <tr>
                      <th><?php echo htmlentities(lang('name_branch_bank')); ?>：</th>
                      <td><input type="text" class="txt w300" name="bank_name" value="<?php echo htmlentities($joinin_detail['bank_name']); ?>"></td>
                  </tr>
                  <tr>
                      <th><?php echo htmlentities(lang('location_bank_account')); ?>：</th>
                      <td colspan="20"><input type="hidden" name="bank_address" id="bank_address" value="<?php echo htmlentities($joinin_detail['bank_address']); ?>"></td>
                  </tr>
           
              </tbody>

          </table>
          <table border="0" cellpadding="0" cellspacing="0" class="store-joinin ds-default-table">
              <thead>
                  <tr>
                      <th colspan="20"><?php echo htmlentities(lang('settlement_account_information')); ?>：</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <th class="w150"><?php echo htmlentities(lang('bank_name')); ?>：</th>
                      <td><input type="text" class="txt w300" name="settlement_bank_account_name" value="<?php echo htmlentities($joinin_detail['settlement_bank_account_name']); ?>"></td>
                  </tr>
                  <tr>
                      <th><?php echo htmlentities(lang('company_bank_account')); ?>：</th>
                      <td><input type="text" class="txt w300" name="settlement_bank_account_number" value="<?php echo htmlentities($joinin_detail['settlement_bank_account_number']); ?>"></td>
                  </tr>
                  <tr>
                      <th><?php echo htmlentities(lang('name_branch_bank')); ?>：</th>
                      <td><input type="text" class="txt w300" name="settlement_bank_name" value="<?php echo htmlentities($joinin_detail['settlement_bank_name']); ?>"></td>
                  </tr>

                  <tr>
                      <th><?php echo htmlentities(lang('location_bank_account')); ?>：</th>
                      <td><input type="hidden" name="settlement_bank_address" id="settlement_bank_address" value="<?php echo htmlentities($joinin_detail['settlement_bank_address']); ?>"></td>
                  </tr>
              </tbody>

          </table>

          <?php else: ?>
          <table border="0" cellpadding="0" cellspacing="0" class="store-joinin ds-default-table">
              <thead>
                  <tr>
                      <th colspan="6"><?php echo htmlentities(lang('store_and_contact_info')); ?></th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <th><?php echo htmlentities(lang('company_name')); ?>：</th>
                      <td><input type="text" class="txt" name="company_name" value="<?php echo htmlentities($joinin_detail['company_name']); ?>"></td>
                      <th><?php echo htmlentities(lang('company_location')); ?>：</th>
                      <td><input type="hidden" name="company_address" id="company_address" value="<?php echo htmlentities($joinin_detail['company_address']); ?>"></td>
                      <th><?php echo htmlentities(lang('company_address')); ?>：</th>
                      <td colspan="3"><input type="text" class="txt w300" name="company_address_detail" value="<?php echo htmlentities($joinin_detail['company_address_detail']); ?>"></td>
                  </tr>
                  <tr>
                      <th><?php echo htmlentities(lang('contact_name')); ?>：</th>
                      <td><input type="text" class="txt" name="contacts_name" value="<?php echo htmlentities($joinin_detail['contacts_name']); ?>"></td>
                      <th><?php echo htmlentities(lang('contact_number')); ?>：</th>
                      <td><input type="text" class="txt" name="contacts_phone" value="<?php echo htmlentities($joinin_detail['contacts_phone']); ?>"></td>
                      <th><?php echo htmlentities(lang('e_mail')); ?>：</th>
                      <td><input type="text" class="txt" name="contacts_email" value="<?php echo htmlentities($joinin_detail['contacts_email']); ?>"></td>
                  </tr>
              </tbody>
          </table>
          <table border="0" cellpadding="0" cellspacing="0" class="store-joinin ds-default-table">
              <thead>
                  <tr>
                      <th colspan="20"><?php echo htmlentities(lang('business_license_information')); ?></th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <th class="w150"><?php echo htmlentities(lang('business_license_number')); ?>：</th>
                      <td><input type="text" class="txt" name="business_licence_number" value="<?php echo htmlentities($joinin_detail['business_licence_number']); ?>"></td></tr><tr>

                      <th><?php echo htmlentities(lang('place_business_license')); ?>：</th>
                      <td><input type="hidden" name="business_licence_address" id="business_licence_address" value="<?php echo htmlentities($joinin_detail['business_licence_address']); ?>"></td></tr><tr>

                      <th><?php echo htmlentities(lang('validity_business_license')); ?>：</th>
                      <td><input type="text" class="txt" name="business_licence_start" id="business_licence_start" value="<?php echo htmlentities($joinin_detail['business_licence_start']); ?>"> - <input type="text" class="txt" name="business_licence_end" id="business_licence_end" value="<?php echo htmlentities($joinin_detail['business_licence_end']); ?>"></td>
                  </tr>
                  <tr>
                      <th><?php echo htmlentities(lang('legal_scope_business')); ?>：</th>
                      <td colspan="20"><input type="text" class="txt w300" name="business_sphere" value="<?php echo htmlentities($joinin_detail['business_sphere']); ?>"></td>
                  </tr>
                  <tr>
                      <th><?php echo htmlentities(lang('business_license')); ?><br /><?php echo htmlentities(lang('electronic_version')); ?>：</th>
                      <td colspan="20">
                          <?php if(!(empty($joinin_detail['business_licence_number_electronic']) || (($joinin_detail['business_licence_number_electronic'] instanceof \think\Collection || $joinin_detail['business_licence_number_electronic'] instanceof \think\Paginator ) && $joinin_detail['business_licence_number_electronic']->isEmpty()))): ?>
                          <a data-lightbox="lightbox-image"  href="<?php echo get_store_joinin_imageurl($joinin_detail['business_licence_number_electronic']); ?>"> <img src="<?php echo get_store_joinin_imageurl($joinin_detail['business_licence_number_electronic']); ?>" height="100"/> </a>
                          <input class="w200" type="file" name="business_licence_number_electronic">
                          <?php endif; ?>
                      </td>
                  </tr>
              </tbody>
          </table>


          <table border="0" cellpadding="0" cellspacing="0" class="store-joinin ds-default-table">
              <thead>
                  <tr>
                      <th colspan="2"><?php echo htmlentities(lang('store_alipay_info')); ?>：</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <th><?php echo htmlentities(lang('store_alipay_account_name')); ?>：</th>
                      <td><input type="text" class="txt w300" name="settlement_bank_account_name" value="<?php echo htmlentities($joinin_detail['settlement_bank_account_name']); ?>"></td>
                  </tr>
                  <tr>
                      <th><?php echo htmlentities(lang('store_alipay_account_number')); ?>：</th>
                      <td><input type="text" class="txt w300" name="settlement_bank_account_number" value="<?php echo htmlentities($joinin_detail['settlement_bank_account_number']); ?>"></td>
                  </tr>
              </tbody>

          </table>
   <?php endif; ?>
          <div><input class="btn" type="submit" value="<?php echo htmlentities(lang('ds_submit')); ?>"/></div>
      </form>
</div>
</div>
<link rel="stylesheet" href="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery.lightbox/css/lightbox.min.css">
<script src="<?php echo htmlentities(PLUGINS_SITE_ROOT); ?>/js/jquery.lightbox/js/lightbox.min.js"></script>
<script type="text/javascript">
$(function(){
    $("#company_address").ds_region();
    $("#business_licence_address").ds_region();
    $("#bank_address").ds_region();
    $("#settlement_bank_address").ds_region();
    $('#business_licence_start').datepicker({dateFormat: 'yy-mm-dd'});
    $('#business_licence_end').datepicker({dateFormat: 'yy-mm-dd'});

    
    $('#joinin_form').validate({
        errorPlacement: function(error, element){
            error.appendTo(element.parentsUntil('tr').parent().find('td:last'));
        },
        rules : {
              business_licence_start:{
                required: true,
              }
        },
        messages : {
            business_licence_start:{
                required: '<?php echo htmlentities(lang('business_licence_start_required')); ?>',
            }
        }
    });
    
});
</script>